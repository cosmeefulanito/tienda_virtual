<?php

class Login extends Controllers{
	public function __construct(){
		
		session_start();
		if(isset($_SESSION['login'])){
			header('Location:'.base_url().'/dashboard');
		}
		parent::__construct();
	}

	public function login(){
		$data['tag_page']="Login";
		$data['page_title']="Pagina de identificacion";
		$data['page_name']="Log-in";
		$data['page_function_js']="function_login.js";
		$this->views->getView($this,"login",$data);
	}

	public function Auth(){
		if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) {
			$arrResponse = array('status' => false, 'msg' => 'Login incompleto' );
		}else{
			$strEmail = strtolower(strClean($_POST['txtEmail']));
			$strPass  = hash("sha256", $_POST['txtPassword']);
			$request = $this->model->authUsuario($strEmail,$strPass);

			if(empty($request)){
				$arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.' );
			}else{
				if ($request['status']==1) {
					// ----REQUEST----
					// [id] => 5
					// [identificacion] => 17786431-5
					// [nombres] => ANDRÉS
					// [apellidos] => ASTORGA
					// [telefono] => 934386071
					// [email] => andres.astorga@mayor.cl
					// [password] => 556d7dc3a115356350f1f9910b1af1ab0e312d4b3e4fc788d2da63668f36d017
					// [nit] => 
					// [nombre_fiscal] => 
					// [direccion_fiscal] => 
					// [token] => 
					// [rolid] => 29
					// [datecreated] => 2021-07-16 00:16:38
					// [status] => 1
					$_SESSION['iduser'] = $request['id'];
					$_SESSION['rut'] = $request['identificacion'];
					$_SESSION['nombre'] = $request['nombres']. " ".$request['apellidos'];
					$_SESSION['email'] = $request['email'];
					$_SESSION['rol'] = $request['rolid'];
					$_SESSION['login'] = true;
					$setUserSession = $this->model->setLoginUser($request['id']); // setear los campos, diferenciar idusuario del idrol
					// $_SESSION['userSession'] = $setUserSession;
					setSessionUser($_SESSION['iduser']);
					$arrResponse = array('status' => true, 'msg' => 'Usuario identificado' );
				}else{
					$arrResponse = array('status' => false,'msg' => 'Usuario inactivo' );
				}
			}
		}
		// sleep(5);
		
		echo json_encode($arrResponse);
	}

	public function resetPassword(){	
		if($_POST){
			if(empty($_POST['txt_email'])) {
				$arrResponse = array('status' => false , 'msg' => 'Correo invalido' );
			}else{
				$token = token();
				$strEmail = strtolower(strClean($_POST['txt_email']));
				$Response = $this->model->getUserReset($strEmail);

				if(empty($Response)){
					$arrResponse = array('status' => false , 'msg' => 'Correo no existe o inactivo');
				}else{
					$PathRecovery = base_url(). 'Login/confirmUser/'.$Response['email'].'/'.$token; //ruta de recuperacion
					$strNombreCompleto = $Response['nombres']. " ". $Response['apellidos'];
					$setResultPassword = $this->model->setTokenPassword($Response['id'], $token);
					$dataUser = array(
						'nombreUsuario' => $strNombreCompleto, 
						'email' => $strEmail, 
						'asunto' => 'Recuperar contraseña - '. NOMBRE_REMITENTE,
						'url_recovery' => $PathRecovery
					);					

					if($setResultPassword){
						$sendMail = sendEmail($dataUser,'email_recovery_password');
						if ($sendMail) {
							$arrResponse = array('status' => true, 'msg' => 'Se ha enviado un correo para reestablecer tu contraseña');
						}else{
							// envio email con ruta de recuperacion para restabelcer contraseña
							$arrResponse = array('status' => false, 'msg' => 'No ha sido posible recuperar la contraseña');
						}						
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es posible realizar este proceso, vuelva a intentarlo');
					}

				}
			}
		}

		echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

	}

	public function confirmUser(string $params){
		if(!empty($params)){
			$arrParams = explode(",", $params);
			$Email = strClean($arrParams[0]);
			$Token = strClean($arrParams[1]);
			$arrUser = $this->model->getUsuario($Email, $Token);
			if(empty($arrUser)){
				header('Location: '. base_url());	
			}else{
				// print_r($arrUser);
				$data['tag_page']="Cambio de contraseña";
				$data['page_title']="Tienda - reestablecer password";
				$data['page_name']="Recuperacion de contraseña";
				$data['id_persona']=$arrUser['id'];
				$data['Email']=$Email;
				$data['token']=$Token;
				$data['page_function_js']="function_login.js";
				$this->views->getView($this,"password_recovery",$data);

			}
		}else{
			header('Location: '. base_url());
		}

	}

	public function changePassword(){
		// print_r($_POST);
		if(empty($_POST['idusuario']) || empty($_POST['txt_email']) || empty($_POST['txt_token']) || empty($_POST['txtNuevoPass']) || empty($_POST['txtConfirmaPass'])){
				$arrResponse = array('status' => false, 'msg' => 'Formulario incompleto');
		}else{
			$idusuario = intval($_POST['idusuario']);
			$Email = strClean($_POST['txt_email']);
			$Token = strClean($_POST['txt_token']);
			$Password = strClean($_POST['txtNuevoPass']);
			$ConfirmPassword = strClean($_POST['txtConfirmaPass']);

			if($Password!=$ConfirmPassword){
				$arrResponse = array('status' => false, 'msg' => 'Las contraseñas no son iguales');
			}else{
				$Request = $this->model->getUsuario($Email,$Token);
				if (empty($Request)) {
					$arrResponse = array('status' => false, 'msg' => 'Error en la busqueda de datos');
				}else{
					$StrPassword = hash("SHA256", $Password);
					$Request = $this->model->insertPassword($idusuario,$StrPassword);
					if($Request){
						$arrResponse = array('status' => true, 'msg' => 'Contraseña actualizada con éxito');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Ha ocurrido un problema');
					}
				}
			}
			
		}

		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

	}
}

?>