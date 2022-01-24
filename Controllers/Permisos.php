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
				// si rol no tiene permisos se le asigna 0 a todos por defecto
				for ($i=0; $i < count($arrModulos); $i++) {
					$arrModulos[$i]['permisos'] = $arrPermisos;
				}
			}else{
				// si rol tiene permisos se le asigna los que encuentra en BD
				for ($i=0; $i < count($arrModulos); $i++) {
					$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
					if (isset($arrPermisosRol[$i])) {
						$arrPermisos = array('r' => $arrPermisosRol[$i]['r'],
										 'w' => $arrPermisosRol[$i]['w'],
										 'u' => $arrPermisosRol[$i]['u'],
										 'd' => $arrPermisosRol[$i]['d']);						
					}
					$arrModulos[$i]['permisos'] = $arrPermisos;
				}
			}

			$arrPermisoRol['modulos'] = $arrModulos;			
			$html = getModal("permisosModal",$arrPermisoRol);
		}

		die();
	}

	public function setPermisos(){			
		if($_POST){
			$idrol = intval($_POST['idrol']);
			$modulos = $_POST['modulos'];
			$this->model->deletePermisos($idrol);
			foreach ($modulos as $modulo) {
				$idmodulo = $modulo['id'];
				$r = empty($modulo['r']) ? 0 : 1;
				$w = empty($modulo['w']) ? 0 : 1;
				$u = empty($modulo['u']) ? 0 : 1;
				$d = empty($modulo['d']) ? 0 : 1;
				$requestPermisos = $this->model->insertPermisos($idrol,$idmodulo,$r,$w,$u,$d);
			}
			
			if($requestPermisos>0){
				$response = array('status' => true ,'msg' => 'Permisos asignados correctamente' );
			}else{
				$response = array('status' => false ,'msg' => 'Error al asignar los permisos' );
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
		}
		
	}

	
	}



?>