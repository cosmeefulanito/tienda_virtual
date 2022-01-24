<?php

class Usuarios extends Controllers{
	public function __construct()
	{
		parent::__construct();
		session_start();
		session_regenerate_id(true); //impide inyeccion de session por el navegador
		if(empty($_SESSION['login'])){
			header('Location:'.base_url().'/login');
		}
		getPermisosModulo(2);
	}

	public function usuarios()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header('Location: '.BASE_URL.'/dashboard');
		}
		$data['page_tag']="Mantenedor <small>usuarios</small>";
		$data['page_title']="Administracion de usuarios";
		$data['page_name']="Usuarios";
		$data['page_function_js']="functions_usuarios.js";
		$this->views->getView($this,"Usuarios",$data);
	}

	public function setUsuario()
	{
		if($_POST){
			if(empty($_POST['txt_rut']) || empty($_POST['txt_nombre']) || empty($_POST['txt_apellidos']) || empty($_POST['txt_telefono']) || empty($_POST['txt_email']) || empty($_POST['listRol']) || empty($_POST['listStatus'])){
				$arrResponse = array('status' => false, 'msg' => 'Formulario incompleto');
			}else{
				$IdUsuario = isset($_POST['idusuario']) ? intval($_POST['idusuario']) : '';
				$Rut = strClean($_POST['txt_rut']);
				$Nombre = strClean($_POST['txt_nombre']);
				$Apellido = strClean($_POST['txt_apellidos']);
				$Fono = intval(strClean($_POST['txt_telefono']));
				$Email = strtolower(strClean($_POST['txt_email']));
				$Rol = intval(strClean($_POST['listRol']));
				$Estado = intval(strClean($_POST['listStatus']));
				$Request="";					

				// Si usuario es nuevo
				if($IdUsuario == 0){
					if ($_SESSION['permisosMod']['w']) {
						$option = 1;
						$Pswd = empty($_POST['txt_password']) ? hash('SHA256', passGenerator()) : hash('SHA256', $_POST['txt_password']);
						$Request = $this->model->insertUsuario($Rut,$Nombre,$Apellido,$Fono,$Email,$Rol,$Estado,$Pswd);
					}
					
				}else{
					if ($_SESSION['permisosMod']['u']) {
						$option = 2;
						$Pswd = empty($_POST['txt_password']) ? "" : hash('SHA256', $_POST['txt_password']);
						$Request = $this->model->updateUsuario($IdUsuario,$Rut,$Nombre,$Apellido,$Fono,$Email,$Rol,$Estado,$Pswd);						
					}					
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
			// sleep(3);
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);			
			
		}
	}

	public function getUsuarios()
	{
		if($_SESSION['permisosMod']['r']){
			$arrUsuarios = $this->model->selectUsuarios();		
			$btnView = '';
			$btnEdit = '';		
			$btnDelete = '';
			for ($i=0; $i < count($arrUsuarios) ; $i++) {
				if($arrUsuarios[$i]['status']==1){						
					$arrUsuarios[$i]['status']='<span class="badge badge-pill badge-success">Activo</span>';			
				}else{				
					$arrUsuarios[$i]['status']='<span class="badge badge-pill badge-danger">Inactivo</span>';
				}

				if(!empty($_SESSION['permisosMod']['r'])){
						$btnView= '<button class="btn btn-info btn-sm btnViewUser" title="Usuario" onClick="fntViewUsuario('.$arrUsuarios[$i]['id'].')" type="button"><i class="fas fa-eye"></i></button>';
				}

				if(!empty($_SESSION['permisosMod']['u'])){
					if (($_SESSION['iduser'] == 1 AND $_SESSION['rol'] == 1) ||
						($_SESSION['userSession']['rolid'] == 1 AND $arrUsuarios[$i]['idrol'] !=1) ) {
						$btnEdit=' <button class="btn btn-primary btn-sm btnEditUser" title="Editar" onClick="fntEditUsuario('.$arrUsuarios[$i]['id'].')" type="button"><i class="fas fa-pencil-alt"></i></button>';
					}else{
						$btnEdit=' <button class="btn btn-primary btn-sm btnEditUser disabled" title="Editar" type="button"><i class="fas fa-pencil-alt"></i></button>';
					}				
				}

				if(!empty($_SESSION['permisosMod']['d'])){
					if (($_SESSION['iduser'] == 1 AND $_SESSION['rol'] == 1) ||
						($_SESSION['userSession']['rolid'] == 1 AND $arrUsuarios[$i]['idrol'] !=1) AND
						($_SESSION['iduser'] != $arrUsuarios[$i]['id']) ) {

					$btnDelete=' <button class="btn btn-warning btn-sm btnDelUser" title="Eliminar" onClick="fntDeleteUsuario('.$arrUsuarios[$i]['id'].')" type="button"><i class="fas fa-trash-alt"></i></button>';
					}else{
						$btnDelete=' <button class="btn btn-warning btn-sm btnDelUser disabled" title="Eliminar" type="button"><i class="fas fa-trash-alt"></i></button>';
					}
				}

				$arrUsuarios[$i]['accion']='<div class="text-center">'.$btnView. ' '.$btnEdit. ' '.$btnDelete.'<div>';			
			} //endfor
			echo json_encode($arrUsuarios);
		}		
	}

	public function getUsuario($idpersona)
	{
		if ($_SESSION['permisosMod']['r']) {
			$idusuario = intval($idpersona);
			if($idusuario>0){
				$arrUsuario = $this->model->selectUsuario($idusuario);
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

	public function delUsuario()
	{
		if ($_SESSION['permisosMod']['d']) {
			if($_POST){
				$idusuario = intval($_POST['idusuario']);
				$request = $this->model->deleteUsuario($idusuario);
				if($request){
					$arr = array('msg' => 'Usuario eliminado','status' => true);
				}else{
					$arr = array('msg' => 'Ha ocurrido un problema','status' => false);
				}
				echo json_encode($arr, JSON_UNESCAPED_UNICODE);
			}	
		}		
	}

	public function perfil()
	{
		$data['page_tag']="Perfil";
		$data['page_title']="Mi perfil";
		$data['page_name']="perfil";
		$data['page_function_js']="functions_usuarios.js";
		$this->views->getView($this,"Perfil",$data);
	}

	public function putperfil()
	{
		if ($_POST) {
			if (empty($_POST['txt_rut']) || empty($_POST['txt_nombre']) || empty($_POST['txt_apellidos']) || empty($_POST['txt_telefono'])) {
				$arrResponse = array("status" => false, "msg" => "Formulario incompleto");
			}else{
				$idUsuario = intval($_SESSION['userSession']['id']);
				$strIdentificacion = strClean($_POST['txt_rut']);
				$strNombre = strClean($_POST['txt_nombre']);
				$strApellido = strClean($_POST['txt_apellidos']);
				$strTelefono = intval(strClean($_POST['txt_telefono']));
				$strPassword="";
				if ($_POST['txt_password']) {
					$strPassword .= hash("SHA256", $_POST['txt_password']);
				}

				$RequestPerfil = $this->model->updatePerfil($idUsuario,$strIdentificacion,$strNombre,$strApellido,$strTelefono,$strPassword);
				// dep($RequestPerfil);die();
				if ($RequestPerfil) {
					setSessionUser($_SESSION['userSession']['id']);
					$arrResponse = array("status" => true, "msg" => "Perfil actualizado correctamente");
				}else{
					$arrResponse = array("status" => false, "msg" => "No es posible actualizar el perfil");
				}

			}
		}		
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE) ;
	}

	public function putDFiscal()
	{
		if ($_POST) {
			if (empty($_POST['txt_rut_fiscal']) || empty($_POST['txt_nombre_fiscal']) || empty($_POST['txt_direccion_fiscal'])) {
				$arrResponse = array("status" => false, "msg" => "Formulario incompleto");				
			}else{
				$idUsuario = intval($_SESSION['userSession']['id']);
				$strIdentificacion = strClean($_POST['txt_rut_fiscal']);
				$strNombre = strClean($_POST['txt_nombre_fiscal']);
				$strDireccion = strClean($_POST['txt_direccion_fiscal']);
			}

			$RequestDFiscal = $this->model->updateDFiscal($idUsuario,$strIdentificacion,$strNombre,$strDireccion);
			if ($RequestDFiscal) {
				setSessionUser($idUsuario);
				$arrResponse = array("status" => true, "msg" => "Datos actualizados correctamente");
			}else{
				$arrResponse = array("status" => false, "msg" => "Error al actualizar los datos fiscales");
			}
		}
		// sleep(3);
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
	}




}

?>