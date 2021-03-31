<?php

class rolesModel extends Mysql{
	public $intId;
	public $strNombre;
	public $strDescripcion;
	public $intEstado;

	public function __construct(){
		parent::__construct();
	}

	public function getRoles(){
		$Query="SELECT * FROM rol WHERE status !=0 order by id DESC";
		$Result = $this->select_All($Query);
		return $Result;
	}

	public function insertRol(string $nombre, string $descripcion, int $estado){
		$response = "";
		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intEstado = $estado;

		$Validate = "SELECT * FROM rol WHERE nombre = '{$this->strNombre}'";
		$Response_validate = $this->select_All($Validate);
		
		if(empty($Response_validate)){
			$Query = "INSERT INTO rol (nombre,descripcion,status) values (?,?,?)";			
			$arrData = array($this->strNombre, $this->strDescripcion, $this->intEstado);			
			$response = $this->insert($Query, $arrData);
		}else{
			$response = "existe";
		}

		return $response;

	}

	
}

?>