<?php

class Roles extends Controllers{
	public function __construct(){
		parent::__construct();
	}

	public function roles(){
		// echo "<br>Mensaje desde el controlador Home";
		$data['page_tag']="Roles usuarios";
		$data['page_title']="Roles usuarios - tienda virtual";
		$data['page_name']="rol usuario";
		$data['page_id']=3;
		$this->views->getView($this,"Roles",$data);
	}

	public function getRoles(){
		$Roles = $this->model->getRoles();		

		for ($i=0; $i < count($Roles) ; $i++) {
			if($Roles[$i]['status']==1){
				// $Roles[$i]['status']='<button class="btn btn-success" type="button">Activo</button>';			
				$Roles[$i]['status']='<span class="badge badge-pill badge-success">Activo</span>';			
			}else{				
				$Roles[$i]['status']='<span class="badge badge-pill badge-danger">Inactivo</span>';
			}
			$Roles[$i]['accion']='<div class="text-center">';
			$Roles[$i]['accion'].='<button class="btn btn-info btnPermisosRol" title="Permisos" rl="'.$Roles[$i]['id'].'"  type="button"><i class="fas fa-key"></i></button>';
			$Roles[$i]['accion'].='<button class="btn btn-secondary btnEditarRol" title="Editar" rl="'.$Roles[$i]['id'].'" type="button"><i class="fas fa-edit"></i></button>';
			$Roles[$i]['accion'].='<button class="btn btn-warning btnEliminarRol" title="Eliminar" rl="'.$Roles[$i]['id'].'" type="button"><i class="fas fa-trash-alt"></i></button>';
			$Roles[$i]['accion'].='<div>';			
		}

		echo json_encode($Roles);
	}

	public function setRol(){
		$intIdRol = intval($_POST['idrol']);
		$strRol = strClean($_POST['nombre_rol']);
		$strDescripcion = strClean($_POST['descripcion_rol']);
		$strEstado = intval($_POST['estado']);
		if($intIdRol == 0){
			$Request = $this->model->insertRol($strRol,$strDescripcion,$strEstado);
			$tipo = 1;
		}else{
			$Request = $this->model->updateRol($intIdRol,$strRol,$strDescripcion,$strEstado);	
			$tipo = 2;
		}
		
		if($Request>0){
			if($tipo==1){$arrResponse = array('status' => true ,'msg' => 'Datos guardados correctamente' );}
			if($tipo==2){$arrResponse = array('status' => true ,'msg' => 'Datos ACtualizados correctamente' );}			
		}else if($Request=='existe'){
			$arrResponse = array('status' => false ,'msg' => 'Ya existe un rol con ese nombre' );
		}else{
			$arrResponse = array('status' => false ,'msg' => 'Ha ocurrido un error al guardar' );
		}		
		
		echo json_encode($arrResponse);
	}

	public function getRol(int $idrol){
		$idrol = intval(strClean($idrol));		

		if($idrol>0){
			$Response = $this->model->selectRol($idrol);
			if($Response){
				$arrResponse = array('status' => true , 'msg' => 'Datos cargados correctamente','data'=> $Response );				
			}else{
				$arrResponse = array('status' => false , 'msg' => 'Error al cargar los datos' );	
			}
			
		}
		// dep($arrResponse);
		echo json_encode($arrResponse);
	}

	public function delRol(){		
		if($_POST){
			$idrol = intval(strClean($_POST['idrol']));
			$request = $this->model->deleteRol($idrol);
			if($request == 'OK'){
				$arrResponse = array('status' => true , 'msg' => 'Datos eliminados correctamente');				
			}else if($request=='exist'){
				$arrResponse = array('status' => false , 'msg' => 'No es posible eliminar un rol asociado a un usuario');
			}else{
				$arrResponse = array('status' => false , 'msg' => 'Error al eliminar el rol');
			}
		}
		echo json_encode($arrResponse);	
		
	}

	
}

?>