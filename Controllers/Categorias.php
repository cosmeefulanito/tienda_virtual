<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Categorias extends Controllers{
	public function __construct()
	{
		parent::__construct();
		session_start();
		session_regenerate_id(true); //impide inyeccion de session por el navegador
		if(empty($_SESSION['login'])){
			header('Location:'.base_url().'/login');
		}
		getPermisosModulo(6);
	}

	public function categorias()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header('Location: '.BASE_URL.'/dashboard');
		}
		$data['page_tag']="Mantenedor de <small>categorias</small>";
		$data['page_title']="Administracion de categorias";
		$data['page_name']="Categorias";
		$data['page_function_js']="functions_categorias.js";
		$this->views->getView($this,"Categorias",$data);
	}

	public function setCategoria(){
		// dep($_POST);
		// dep($_FILES);
		// die();
		if ($_POST) {
			if(empty($_POST['nombre_cat']) || empty($_POST['descripcion_cat']) || empty($_POST['estado_cat'])) {
				$arrResponse = array("status" => false, "msg" => "Formulario incompleto");
			}else{
				$IdCategoria = intval($_POST['idcategoria']);
				$Nombre = strClean($_POST['nombre_cat']);
				$Descripcion = strClean($_POST['descripcion_cat']);
				$Estado = intval($_POST['estado_cat']);

				// validamos parametros de foto
				$foto = $_FILES['foto'];
				$NameImg = $foto["name"];
				$TypeImg = $foto["type"];
				$NameTmpImg = $foto["tmp_name"];
				$SizeImg = $foto["size"];
				$ErrImg = $foto["error"];
				$ImgFront = "portada_categoria.png";
				$Request="";
				if ($NameImg != ""){
					$ImgFront = "img_".md5(date('d-m-Y H:m:s')).'.jpg';
				}
				
				if ($IdCategoria == 0) {
					// crear
					if($_SESSION['permisosMod']['w']){
						$Request = $this->model->insertCategoria($Nombre,$Descripcion,$Estado,$ImgFront);
						$option=1;
					}
				}else{
					// actualizar
					if($_SESSION['permisosMod']['u']){
						if($NameImg == ""){ //Validacion para cuando NO enviamos foto para actualizacion
							if ($_POST["foto_actual"] != "portada_categoria.png" && $_POST["foto_remove"]==0) {
								$ImgFront = $_POST["foto_actual"];				}
						}
						$Request = $this->model->updateCategoria($IdCategoria,$Nombre,$Descripcion,$Estado,$ImgFront);
						$option=2;
					}
				}

				if ($Request>0) {
					if ($option == 1) {
						$arrResponse = array("status" => true, "msg" => "Categoria creada correctamente");
						if ($NameImg!="") {uploadImage($foto, $ImgFront);}
					}else{
						$arrResponse = array("status" => true, "msg" => "Categoria actualizada correctamente");
						if ($NameImg!="") {uploadImage($foto, $ImgFront);}
						if ( ($NameImg == "" && $_POST["foto_actual"]!="portada_categoria.png" && $_POST["foto_remove"]==1) || ($NameImg!="" && $_POST["foto_actual"]!="portada_categoria.png") ){
							deleteFile($_POST["foto_actual"]);
						}
					}
				}else if($Request=="Existe"){
						$arrResponse = array("status" => false, "msg" => "Categoria ya existe");						
				}else{
					$arrResponse = array("status" => false, "msg" => "Ha ocurrido un error al guardar la categoria");
				}

			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}

		}
	}

	public function getCategorias(){
		if($_SESSION['permisosMod']['r']){
			$arrCategorias = $this->model->selectCategorias();
			$btnView = '';
			$btnEdit = '';		
			$btnDelete = '';

			for ($i=0; $i < count($arrCategorias) ; $i++) {
				if ($arrCategorias[$i]["status"]==1) {
					$arrCategorias[$i]['status']='<span class="badge badge-pill badge-success">Activo</span>';			
				}else{
					$arrCategorias[$i]['status']='<span class="badge badge-pill badge-danger">Inactivo</span>';
				}

				if(!empty($_SESSION['permisosMod']['r'])){
						$btnView= '<button class="btn btn-info btn-sm" title="Ver" onClick="fntViewCategoria('.$arrCategorias[$i]['id'].')" type="button"><i class="fas fa-eye"></i></button>';
				}

				if(!empty($_SESSION['permisosMod']['u'])){					
						$btnEdit=' <button class="btn btn-primary btn-sm" title="Editar" onClick="fntEditCategoria(this,'.$arrCategorias[$i]['id'].')" type="button"><i class="fas fa-pencil-alt"></i></button>';
				}
				

				if(!empty($_SESSION['permisosMod']['d'])){
					$btnDelete=' <button class="btn btn-warning btn-sm" title="Eliminar" onClick="fntDeleteCategoria('.$arrCategorias[$i]['id'].')" type="button"><i class="fas fa-trash-alt"></i></button>';
				}

				$arrCategorias[$i]['accion']='<div class="text-center">'.$btnView. ' '.$btnEdit. ' '.$btnDelete.'<div>';			
			} //endfor
			echo json_encode($arrCategorias);
		}
		die();
	}

	public function getCategoria($idcategoria){
		$idcategoria = intval(strClean($idcategoria));
		if ($_SESSION['permisosMod']['r']) {
			if($idcategoria>0){
				$Response = $this->model->selectCategoria($idcategoria);
				if($Response){
					$Response['url_portada'] = media()."/image/uploads/".$Response['portada'];
					$arrResponse = array('status' => true , 'msg' => 'Datos cargados correctamente','data'=> $Response );								
				}else{
					$arrResponse = array('status' => false , 'msg' => 'Error al cargar los datos' );	
				}			
			}			
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delCategoria()
	{
		if($_POST){
			if($_SESSION['permisosMod']['d']){
				$idusuario = intval($_POST['idCategoria']);
				$request = $this->model->deleteCategoria($idusuario);

				if($request=="OK"){
					$arr = array('msg' => 'Categoria eliminada','status' => true);
				}else if($request == "Existe"){
					$arr = array('msg' => 'No es posible eliminar, hay un producto asociado a esa categoria','status' => false);
				}else{
					$arr = array('msg' => 'Ha ocurrido un error, intente mas tarde','status' => false);
				}
			}
				echo json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getSelectCategorias(){
		$htmlOptions = "";
		$arrData = $this->model->selectCategorias();		
		if (count($arrData)>0) {
			for ($i=0; $i < count($arrData) ; $i++) {
				if ($arrData[$i]["status"] == 1) {
					$htmlOptions.= "<option value='".$arrData[$i]["id"]."'>" . $arrData[$i]["nombre"]. "</option>";
				}
			}			
		}
		echo $htmlOptions;
		die();
	}


}


?>