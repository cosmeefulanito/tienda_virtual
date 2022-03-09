<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Productos extends Controllers{
	public function __construct()
	{
		parent::__construct();
		session_start();
		session_regenerate_id(true); //impide inyeccion de session por el navegador
		if(empty($_SESSION['login'])){
			header('Location:'.base_url().'/login');
		}
		getPermisosModulo(4);
	}

	public function productos()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header('Location: '.BASE_URL.'/dashboard');
		}
		$data['page_tag']="Mantenedor de <small>Productos</small>";
		$data['page_title']="Administracion de productos";
		$data['page_name']="Productos";
		$data['page_function_js']="functions_productos.js";
		$this->views->getView($this,"Productos",$data);
	}	

	public function getProductos(){
		if($_SESSION['permisosMod']['r']){
			$arrProductos = $this->model->selectProductos();
			$btnView = '';
			$btnEdit = '';		
			$btnDelete = '';

			for ($i=0; $i < count($arrProductos) ; $i++) {
				if ($arrProductos[$i]["status"]==1) {
					$arrProductos[$i]['status']='<span class="badge badge-pill badge-success">Activo</span>';			
				}else{
					$arrProductos[$i]['status']='<span class="badge badge-pill badge-danger">Inactivo</span>';
				}

				$arrProductos[$i]['precio'] = MONEY. " ".formatMoney($arrProductos[$i]['precio']);

				if(!empty($_SESSION['permisosMod']['r'])){
						$btnView= '<button class="btn btn-info btn-sm" title="Ver" onClick="fntViewProducto('.$arrProductos[$i]['id'].')" type="button"><i class="fas fa-eye"></i></button>';
				}

				if(!empty($_SESSION['permisosMod']['u'])){					
						$btnEdit=' <button class="btn btn-primary btn-sm" title="Editar" onClick="fntEditProducto(this,'.$arrProductos[$i]['id'].')" type="button"><i class="fas fa-pencil-alt"></i></button>';
				}
				

				if(!empty($_SESSION['permisosMod']['d'])){
					$btnDelete=' <button class="btn btn-warning btn-sm" title="Eliminar" onClick="fntDeleteProducto('.$arrProductos[$i]['id'].')" type="button"><i class="fas fa-trash-alt"></i></button>';
				}

				$arrProductos[$i]['accion']='<div class="text-center">'.$btnView. ' '.$btnEdit. ' '.$btnDelete.'<div>';			
			} //endfor
			echo json_encode($arrProductos);
		}
		die();
	}

	public function setProducto(){
		if ($_POST) {
			if(empty($_POST['strNombreProducto']) || empty($_POST['txtDescripcionProducto']) || empty($_POST['txtCodigoProducto']) || empty($_POST['intPrecioProducto']) || empty($_POST['intStockProducto']) || empty($_POST['listCategoriaProducto']) || empty($_POST['listStatusProducto'])) {
				$arrResponse = array("status" => false, "msg" => "Formulario incompleto");
			}else{
				$IdProducto = intval($_POST['idproducto']);
				$Nombre = strClean($_POST['strNombreProducto']);
				$Descripcion = strClean($_POST['txtDescripcionProducto']);
				$Codigo = strClean($_POST['txtCodigoProducto']);
				$Precio = intval($_POST['intPrecioProducto']);
				$Stock = intval($_POST['intStockProducto']);
				$CategoriaProducto = intval($_POST['listCategoriaProducto']);
				$Estado = intval($_POST['listStatusProducto']);
				$Result="";
				if($IdProducto == 0){	// Creamos un producto
					$option = 1;
					if($_SESSION['permisosMod']['w']){			
						$Result = $this->model->insertProducto($Nombre,$Descripcion,$Codigo, $Precio,$Stock,$CategoriaProducto,$Estado);
					}
				}else{				// Actualizamos un producto
					$option = 2;
					if($_SESSION['permisosMod']['u']){
						$Result = $this->model->updateProducto($IdProducto,$Nombre,$Descripcion,$Codigo,$Precio,$Stock,$CategoriaProducto,$Estado);
					}
				}

				if ($Result>0) {
					if ($option==1) {
						$arrResponse = array('msg' => "Producto creado exitosamente" , "status" => true, "idproducto" => $Result);
					}else{
						$arrResponse = array('msg' => "Producto actualizado exitosamente" , "status" => true, "idproducto" => $IdProducto);
					}
				}else if($Result == "Existe"){
					echo "Entro...";
					$arrResponse = array('msg' => "Ya existe un producto con el mismo código" , "status" => false, "idproducto" => $Result);
				}else{
					$arrResponse = array('msg' => "No se ha podido almacenar la informacion" , "status" => false);
				}
			}

		}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
	}

	public function getProducto($idprod){
		if($_SESSION['permisosMod']['r']){
			//No parseamos el tipo de dato en el parametro porque da error; en vez de eso, parseamos con intval: 0 error, mayor a 0 es un entero valido
			$idProducto = intval($idprod);
			if ($idProducto>0) {
				$arrData = $this->model->selectProducto($idProducto);
				$arrImage= $this->model->selectImage($idProducto);

				if (empty($arrData)){
					$arrResponse = array("msg" => "Producto no encontrado", "status" => false);
				}else{
						if (count($arrImage)>0) {
							for ($i=0; $i < count($arrImage) ; $i++) {
								// $arrData[$i]['image'] = media().'/image/uploads/'.$arrImage[$i]['imagen'].'.jpg';
								$arrImage[$i]['pathimg'] = media().'/image/uploads/'.$arrImage[$i]['imagen'];
							}

							$arrData['imagen'] = $arrImage;
					}

					$arrResponse = array("msg" => "Producto cargado correctamente", "status" => true, "data" => $arrData);
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);			
		}
		die();
	}

	public function delProducto()
	{
		if($_POST){
			if($_SESSION['permisosMod']['d']){
				$idProducto = intval($_POST['idProducto']);
				$request = $this->model->deleteProducto($idProducto);

				if($request){
					$arr = array('msg' => 'Producto eliminado','status' => true);
				}else{
					$arr = array('msg' => 'Ha ocurrido un error, intente mas tarde','status' => false);
				}
			}
				echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delImg(){
				if ($_POST) {
					if (empty($_POST['idproducto']) || empty($_POST['file']) ) {
						$arrResponse = array("status" => false, "msg" => "Error en los datos");
					}else{
						$idProducto = intval($_POST['idproducto']);
						$imgName = strClean($_POST['file']);
						$requestImage = $this->model->deleteImage($idProducto,$imgName);

						if ($requestImage) {
							$uploadImage = deleteFile($imgName);
							$arrResponse = array("status" => true, "msg" => "Foto eliminada correctamente");
						}else{
							$arrResponse = array("status" => false, "msg" => "Error al eliminar la foto");
						}
					}
								
				}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
	}

	public function setImage(){
		// if (empty($idProducto)) {
			// $arrResponse = array("status" => false, "msg" => "Error en dato del producto");
		// }else{
				if ($_POST) {
					$idProducto = intval($_POST['idproducto']);
					// $idProducto = 1;
					$Photo = $_FILES['photo'];
					$imgName = 'prod_'.md5(date('d-m-Y H:m:s')).'.jpg';
					$requestImage = $this->model->insertImage($idProducto,$imgName);

					if ($requestImage) {
						$uploadImage = uploadImage($Photo,$imgName);
						$arrResponse = array("status" => true, "imgname" =>  $imgName , "msg" => "Foto cargada correctamente");
					}else{
						$arrResponse = array("status" => false, "msg" => "Error al cargar la foto");
					}			
				}
		// }		
		sleep(1);
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
	}


}


?>