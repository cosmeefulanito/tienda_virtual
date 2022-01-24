<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

class ClientesModel extends Mysql {
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
	private $strRutEmpresa;
	private $strRazonSocial;
	private $strNombreFantasia;
	private $strDireccion;

	public function __construct(){
		parent::__construct();
	}

	public function insertCliente(string $rut, string $nombre, string $apellidos, int $telefono, string $correo, string $password, int $tipo, string $rutEmpresa, string $razonSoc,string $nombreFant,string $direccion){

		$this->strRut = $rut;
		$this->strNombre = $nombre;
		$this->strApellidos = $apellidos;
		$this->intFono = $telefono;
		$this->strEmail = $correo;
		$this->strPassword = $password;
		$this->intRol = $tipo;		
		$this->strRutEmpresa = $rutEmpresa;
		$this->strRazonSocial = $razonSoc;
		$this->strNombreFantasia = $nombreFant;
		$this->strDireccion = $direccion;

		$Query = "SELECT * FROM persona WHERE email = '{$this->strEmail}' OR identificacion ='{$this->strRut}'";
		$Res = $this->select_All($Query);
			if(empty($Res)){
				$Query_insert ="INSERT INTO persona (identificacion,nombres,apellidos,telefono,email,password,nit,nombre_fiscal,direccion_fiscal,nombre_fantasia,rolid,datecreated) values (?,?,?,?,?,?,?,?,?,?,?,?)";
				$Request = $this->insert($Query_insert,array($this->strRut,$this->strNombre,$this->strApellidos,$this->intFono,$this->strEmail,$this->strPassword,$this->strRutEmpresa,$this->strRazonSocial,$this->strDireccion,$this->strNombreFantasia,$this->intRol, date('Y-m-d H:i:s')));
			}else{
				$Request='Existe';
			}

		return $Request;
	}

	public function selectClientes(){
		$Select_usuarios = "SELECT id, identificacion as rut,CONCAT(nombres, ' ', apellidos) as nombre,telefono,email,nit,nombre_fiscal,nombre_fantasia,direccion_fiscal,status FROM persona WHERE status != 0 AND rolid = 2 ORDER BY id DESC";
		// echo $Select_usuarios;die();
						return $this->select_All($Select_usuarios);
	}	

	public function selectCliente(int $idpersona){		
		if ($idpersona) {
			$this->intIdUsuario  = $idpersona ;
			$Select_usuario = "SELECT id,identificacion,nombres,apellidos,telefono,email,rolid,status,DATE_FORMAT(datecreated, '%d/%m/%Y %H:%i') as fecha_crea,nit,nombre_fiscal,nombre_fantasia,direccion_fiscal FROM persona WHERE id = $this->intIdUsuario ";			
		}		
		return $this->select($Select_usuario);
	}

	public function updateCliente(int $id,string $rut,string $nombre,string $apellidos,string $telefono,string $correo,string $password,string $nit,string $nombre_fiscal,string $nombre_fantasia,string $direccion_fiscal){
		$this->intIdUsuario = $id;
		$this->strRut = $rut;
		$this->strNombre = $nombre;
		$this->strApellidos = $apellidos;
		$this->intFono = $telefono;
		$this->strEmail = $correo;
		$this->strPassword = $password;
		$this->strRutEmpresa = $nit;
		$this->strRazonSocial = $nombre_fiscal;
		$this->strNombreFantasia = $nombre_fantasia;
		$this->strDireccion = $direccion_fiscal;

		// Validamos que el identificador y el correo no estén repetidos
		$Query="SELECT * FROM persona WHERE (email = '{$this->strEmail}' AND id != '{$this->intIdUsuario}') OR (identificacion = '{$this->strRut}' AND id != '{$this->intIdUsuario}')";		
		$Request = $this->select_All($Query);
		
		if(empty($Request)){
			if($this->strPassword != '') {
				$Query = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email = ?, password = ?, nit = ?, nombre_fiscal = ?, nombre_fantasia = ?, direccion_fiscal = ? WHERE id = '{$this->intIdUsuario}'";
				$Arr = array($this->strRut,
							$this->strNombre,
							$this->strApellidos,
							$this->intFono,
							$this->strEmail,
							$this->strPassword,
							$this->intRol,
							$this->intEstado);
			}else{
				$Query = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email = ?, nit = ?, nombre_fiscal = ?,nombre_fantasia = ?, direccion_fiscal = ? WHERE id = '{$this->intIdUsuario}'";
				$Arr = array($this->strRut,
							$this->strNombre,
							$this->strApellidos,
							$this->intFono,
							$this->strEmail,
							$this->strRutEmpresa,
							$this->strRazonSocial,
							$this->strNombreFantasia,
							$this->strDireccion);
			}

			$Request = $this->update($Query, $Arr);
		}else{
			$Request = "Existe";
		}

		return $Request;
	}

	public function deleteCliente($id){
		$this->intIdUsuario = $id;
		$Query ="UPDATE persona SET status = ? WHERE id = '{$this->intIdUsuario}' ";
		$arr = array(0);
		$request = $this->update($Query, $arr);
		return $request;
	}


}

	

?>