<?php

class Permisos extends Controllers{
	public function __construct(){
		parent::__construct();
	}

	public function getPermisosRol(int $idrol){
		$rolId = intval($idrol);
		//tiene id valido
		if($rolId>0){
			$arrModulos = $this->model->selectModulos();
			$arrPermisosRol = $this->model->selectPermisosRol($rolId);
			$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
			$arrPermisoRol = array('idrol' => $rolId);

			if(empty($arrPermisosRol)){
				for ($i=0; $i < count($arrModulos); $i++) {
					$arrModulos[$i]['permisos'] = $arrPermisos;
				}
			}else{
				for ($i=0; $i < count($arrModulos); $i++) { 
					$arrPermisos = array('r' => $arrPermisosRol[$i]['r'],
										 'w' => $arrPermisosRol[$i]['w'],
										 'u' => $arrPermisosRol[$i]['u'],
										 'd' => $arrPermisosRol[$i]['d']);

					if($arrModulos[$i]['id'] == $arrPermisosRol[$i]['moduloid']){
						$arrModulos[$i]['permisos'] = $arrPermisos;
					}
				}
			}

			$arrPermisoRol['modulos'] = $arrModulos;			
			$html = getModal("permisosModal",$arrPermisoRol);
		}

		die();
	}

	
	}



?>