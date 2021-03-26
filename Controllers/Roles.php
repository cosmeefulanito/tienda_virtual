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
		// dep($Roles[1]['status']);

		for ($i=0; $i < count($Roles) ; $i++) {
			if($Roles[$i]['status']==1){
				$Roles[$i]['status']='<button class="btn btn-success" type="button">Activo</button>';				
			}else{
				$Roles[$i]['status']='<button class="btn btn-danger" type="button">Inactivo</button>';
			}
			$Roles[$i]['accion']='<div class="text-center">';
			$Roles[$i]['accion'].='<button class="btn btn-info btnPermisosRol" title="Permisos" type="button"><i class="fas fa-key"></i></button>';
			$Roles[$i]['accion'].=' <button class="btn btn-secondary btnEditarRol" title="Editar" type="button"><i class="fas fa-edit"></i></button>';
			$Roles[$i]['accion'].=' <button class="btn btn-warning btnEliminarRol" title="Eliminar" type="button"><i class="fas fa-trash-alt"></i></button>';
			$Roles[$i]['accion'].='<div>';			
		}

		echo json_encode($Roles);
	}

	
}

?>