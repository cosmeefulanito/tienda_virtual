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

				if(!empty($_SESSION['permisosMod']['r'])){
						$btnView= '<button class="btn btn-info btn-sm" title="Ver" onClick="fntViewCategoria('.$arrProductos[$i]['id'].')" type="button"><i class="fas fa-eye"></i></button>';
				}

				if(!empty($_SESSION['permisosMod']['u'])){					
						$btnEdit=' <button class="btn btn-primary btn-sm" title="Editar" onClick="fntEditCategoria(this,'.$arrProductos[$i]['id'].')" type="button"><i class="fas fa-pencil-alt"></i></button>';
				}
				

				if(!empty($_SESSION['permisosMod']['d'])){
					$btnDelete=' <button class="btn btn-warning btn-sm" title="Eliminar" onClick="fntDeleteCategoria('.$arrProductos[$i]['id'].')" type="button"><i class="fas fa-trash-alt"></i></button>';
				}

				$arrProductos[$i]['accion']='<div class="text-center">'.$btnView. ' '.$btnEdit. ' '.$btnDelete.'<div>';			
			} //endfor
			echo json_encode($arrProductos);
		}
		die();
	}


}


?>