<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

class UsuariosModel extends Mysql {
	private $intIdUsuario;
	private $strRut;
	private $strNombre;
	private $strApellidos;
	private $intFono;
	private $strEmail;
	private $strPassword;
	private $strToken;
	private $intRol;
	private $intEstado;
	private $strRutFisc;
	private $strNombreFisc;
	private $strDireccionFisc;

	public function __construct(){
		parent::__construct();
	}

	public function insertUsuario(string $rut, string $nombre, string $apellidos, int $telefono, string $correo, int $rol, int $estado,string $password){
		$this->strRut = $rut;
		$this->strNombre = $nombre;
		$this->strApellidos = $apellidos;
		$this->intFono = $telefono;
		$this->strEmail = $correo;
		$this->strPassword = $password;
		$this->intRol = $rol;
		$this->intEstado = $estado;

		$Query = "SELECT * FROM persona WHERE email = '{$this->strEmail}' OR identificacion ='{$this->strRut}'";
		$Res = $this->select_All($Query);
			if(empty($Res)){
				$Query_insert ="INSERT INTO persona (identificacion,nombres,apellidos,telefono,email,password,rolid,status,datecreated) values (?,?,?,?,?,?,?,?,?)";
				$Request = $this->insert($Query_insert,array($this->strRut,$this->strNombre,$this->strApellidos,$this->intFono,$this->strEmail,$this->strPassword,$this->intRol,$this->intEstado,date('Y-m-d H:i:s')));
			}else{
				$Request='Existe';
			}

		return $Request;
	}

	public function selectUsuarios(){
		$Where = '';
		if($_SESSION['iduser']!=1){
			$Where = ' AND per.id !=1';
		}
		$Select_usuarios = "SELECT per.id,per.identificacion,per.nombres,per.apellidos,per.telefono,per.email,per.status,per.datecreated,r.id as idrol,r.nombre,r.descripcion FROM persona per INNER JOIN rol r ON per.rolid = r.id WHERE per.status != 0".$Where;
			return $this->select_All($Select_usuarios);
	}	

	public function selectUsuario(int $idpersona){		
		if ($idpersona) {
			$this->intIdUsuario  = $idpersona ;
			$Select_usuario = "SELECT per.id,per.identificacion,per.nombres,per.apellidos,per.telefono,per.email,per.rolid,per.status,DATE_FORMAT(per.datecreated, '%d/%m/%Y %H:%i') as fecha_crea,r.nombre as nombre_rol,r.descripcion as descripcion_rol
			FROM persona per INNER JOIN rol r ON per.rolid = r.id WHERE per.id = $this->intIdUsuario ";			
		}
		// echo $Select_usuario;
		return $this->select($Select_usuario);
	}

	public function updateUsuario(int $id,string $rut,string $nombre,string $apellidos,string $telefono,string $correo,string $rol,string $estado,string $password){
		$this->intIdUsuario = $id;
		$this->strRut = $rut;
		$this->strNombre = $nombre;
		$this->strApellidos = $apellidos;
		$this->intFono = $telefono;
		$this->strEmail = $correo;
		$this->strPassword = $password;
		$this->intRol = $rol;
		$this->intEstado = $estado;

		// Validamos que el identificador y el correo no estén repetidos
		$Query="SELECT * FROM persona WHERE (email = '{$this->strEmail}' AND id != '{$this->intIdUsuario}') OR (identificacion = '{$this->strRut}' AND id != '{$this->intIdUsuario}')";		
		$Request = $this->select_All($Query);
		
		if(empty($Request)){
			if($this->strPassword != '') {
				$Query = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email = ?, password = ?, rolid = ?, status = ? WHERE id = '{$this->intIdUsuario}'";
				$Arr = array($this->strRut,
							$this->strNombre,
							$this->strApellidos,
							$this->intFono,
							$this->strEmail,
							$this->strPassword,
							$this->intRol,
							$this->intEstado);
			}else{
				$Query = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email = ?, rolid = ?, status = ? WHERE id = '{$this->intIdUsuario}'";
				$Arr = array($this->strRut,
							$this->strNombre,
							$this->strApellidos,
							$this->intFono,
							$this->strEmail,
							$this->intRol,
							$this->intEstado);
			}

			$Request = $this->update($Query, $Arr);
		}else{
			$Request = "Existe";
		}

		return $Request;
	}

	public function deleteUsuario($id){
		$this->intIdUsuario = $id;
		$Query ="UPDATE persona SET status = ? WHERE id = '{$this->intIdUsuario}' ";
		$arr = array(0);
		$request = $this->update($Query, $arr);
		return $request;
	}

	// ***** Query's perfil *****
	public function updatePerfil(int $idUsuario,string $rut,string $nombre,string $apellido,int $fono,string $pass){
		$this->intIdUsuario = $idUsuario;
		$this->strRut = $rut;
		$this->strNombre = $nombre;
		$this->strApellidos = $apellido;
		$this->intFono = $fono;
		$this->strPassword = $pass;
		// echo $idUsuario . " " .$rut. " " .$nombre. " " . $apellido. " " . $fono. " " . $pass;die();
		
		if (!empty($this->strPassword)) {
			$ArrData = array($this->strRut,$this->strNombre,$this->strApellidos,$this->intFono,$this->strPassword,$this->intIdUsuario);	
			$Query = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, password = ? WHERE id = ?";			
		}else{
			$ArrData = array($this->strRut,$this->strNombre,$this->strApellidos,$this->intFono,$this->intIdUsuario);
			$Query = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ? WHERE id = ?";			
		}		
		$Request = $this->update($Query, $ArrData);
		return $Request;
	}

	public function updateDFiscal(int $idUsuario,string $rutFiscal, string $nombreFiscal, string $direccionFiscal){
		 $this->intIdUsuario = $idUsuario;
		 $this->strRutFisc = $rutFiscal;
		 $this->strNombreFisc = $nombreFiscal;
		 $this->strDireccionFisc = $direccionFiscal;

		 $Query = "UPDATE persona SET nit = ? , nombre_fiscal = ? , direccion_fiscal = ? WHERE id = ? ";
		 $ArrData = array($this->strRutFisc,$this->strNombreFisc,$this->strDireccionFisc,$this->intIdUsuario);
		 $Result = $this->update($Query,$ArrData);
		 return $Result;
	}


}

	

?>