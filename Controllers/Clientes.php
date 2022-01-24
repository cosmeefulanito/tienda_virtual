<?php

class Clientes extends Controllers{
	public function __construct()
	{
		parent::__construct();
		session_start();
		session_regenerate_id(true); //impide inyeccion de session por el navegador
		if(empty($_SESSION['login'])){
			header('Location:'.base_url().'/login');
		}
		getPermisosModulo(3);
	}

	public function clientes()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header('Location: '.BASE_URL.'/dashboard');
		}
		$data['page_tag']="Mantenedor clientes";
		$data['page_title']="Administracion de clientes";
		$data['page_name']="Clientes";
		$data['page_function_js']="functions_clientes.js";
		$this->views->getView($this,"clientes",$data);
	}

	public function setCliente(){		
		if($_POST){
			if(empty($_POST['txt_rut']) || empty($_POST['txt_nombre']) || empty($_POST['txt_apellidos']) || empty($_POST['txt_telefono']) || empty($_POST['txt_email']) || empty($_POST['txt_rut_empresa']) || empty($_POST['txt_razon_social']) || empty($_POST['txt_nombre_fantasia'])){
				$arrResponse = array('status' => false, 'msg' => 'Formulario incompleto');
			}else{
				$IdUsuario = isset($_POST['idusuario']) ? intval($_POST['idusuario']) : '';
				$Rut = strClean($_POST['txt_rut']);
				$Nombre = strClean($_POST['txt_nombre']);
				$Apellido = strClean($_POST['txt_apellidos']);
				$Fono = intval(strClean($_POST['txt_telefono']));
				$Email = strtolower(strClean($_POST['txt_email']));
				$RutEmpresa = strClean($_POST['txt_rut_empresa']);
				$RazonSocial = strClean($_POST['txt_razon_social']);
				$NombreFantasia = strClean($_POST['txt_nombre_fantasia']);
				$DireccionEmpresa = strClean($_POST['txt_direccion_empresa']);
				$RolId = 2;
				$Request="";

				if($IdUsuario == 0){	
						// Si usuario es nuevo
						$option = 1;
						$Pswd = empty($_POST['txt_password']) ? hash('SHA256', passGenerator()) : hash('SHA256', $_POST['txt_password']);
						$Request = $this->model->insertCliente($Rut,$Nombre,$Apellido,$Fono,$Email,$Pswd,$RolId,$RutEmpresa,$RazonSocial,$NombreFantasia,$DireccionEmpresa);
						}else{
							// Actualizo usuario existente						
							$option = 2;
							$Pswd = empty($_POST['txt_password']) ? "" : hash('SHA256', $_POST['txt_password']);
							$Request = $this->model->updateCliente($IdUsuario,$Rut,$Nombre,$Apellido,$Fono,$Email,$Pswd,$RutEmpresa,$RazonSocial,$NombreFantasia,$DireccionEmpresa);
					}


					// Si usuario ya existe
					if($Request>0){
						if($option == 1)
						$arrResponse = array('status' => true, 'msg' => 'Usuario ingresado correctamente');
						else if ($option == 2)
						$arrResponse = array('status' => true, 'msg' => 'Usuario actualizado correctamente');
					}else if($Request == 'Existe'){
						$arrResponse = array('status' => false, 'msg' => 'Email o RUT ya existe');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Ha ocurrido un problema al guardar los datos');
					}				
			}

			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);				
		}
	}

	public function getClientes()
	{
		if($_SESSION['permisosMod']['r']){
			$arrUsuarios = $this->model->selectClientes();

			$btnView = '';
			$btnEdit = '';		
			$btnDelete = '';
			for ($i=0; $i < count($arrUsuarios) ; $i++) {

				if(!empty($_SESSION['permisosMod']['r'])){
						$btnView= '<button class="btn btn-info btn-sm" title="Usuario" onClick="fntViewCliente('.$arrUsuarios[$i]['id'].')" type="button"><i class="fas fa-eye"></i></button>';
				}

				if(!empty($_SESSION['permisosMod']['u'])){					
						$btnEdit=' <button class="btn btn-primary btn-sm" title="Editar" onClick="fntEditCliente('.$arrUsuarios[$i]['id'].')" type="button"><i class="fas fa-pencil-alt"></i></button>';
				}
				

				if(!empty($_SESSION['permisosMod']['d'])){
					$btnDelete=' <button class="btn btn-warning btn-sm" title="Eliminar" onClick="fntDeleteCliente('.$arrUsuarios[$i]['id'].')" type="button"><i class="fas fa-trash-alt"></i></button>';
				}

				$arrUsuarios[$i]['accion']='<div class="text-center">'.$btnView. ' '.$btnEdit. ' '.$btnDelete.'<div>';			
			} //endfor
			echo json_encode($arrUsuarios);
		}		
	}

	public function getCliente($idpersona)
	{
		if ($_SESSION['permisosMod']['r']) {
			$idusuario = intval($idpersona);
			if($idusuario>0){
				$arrUsuario = $this->model->selectCliente($idusuario);
				if(empty($arrUsuario)){
					$arrResponse = array('status' => false, 'msg' => 'Sin datos');
				}else{
					$arrResponse = array('status' => true, 'msg' => 'OK', 'data' => $arrUsuario);
				}
			}
			// dep($arrUsuario);		
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}	
	}

	public function delCliente()
	{
		if ($_SESSION['permisosMod']['d']) {
			if($_POST){
				$idusuario = intval($_POST['idusuario']);
				$request = $this->model->deleteCliente($idusuario);
				if($request){
					$arr = array('msg' => 'Cliente eliminado','status' => true);
				}else{
					$arr = array('msg' => 'Ha ocurrido un problema','status' => false);
				}
				echo json_encode($arr, JSON_UNESCAPED_UNICODE);
			}	
		}		
	}


}

?>