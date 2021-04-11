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

	public function selectRol(int $idrol){
		$this->intId = $idrol;
		$Select = "SELECT * FROM rol WHERE id = {$this->intId}";
		$Response = $this->select($Select);
		return $Response;
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

	public function updateRol(int $idrol, string $nombre, string $descripcion,int $estado){		
		$this->intId = $idrol;
		$this->strNombre = $nombre;
		$this->strDescripcion = $descripcion;
		$this->intEstado = $estado;
		$sql = "SELECT * FROM rol WHERE nombre = '$this->strNombre' AND id != $this->intId"; 
		$resultSql = $this->select_All($sql);
		if(empty($resultSql)){
			$Arr = array($this->strNombre, $this->strDescripcion, $this->intEstado, $this->intId);
			$Query = "UPDATE rol set nombre = ? , descripcion = ?, status = ?  WHERE id = ? ";
			$Response = $this->update($Query, $Arr);	
		}else{
			$Response="Exist";
		}
		
		return $Response;
	}

	public function deleteRol(int $idrol){
		$this->intId = $idrol;
		$Validate = "SELECT * FROM persona WHERE rolid = $this->intId";
		$Result = $this->select_All($Validate); 
		if(empty($Result)){
			$Arr = array(0);
			$Query = "UPDATE rol SET status = ? WHERE id = $this->intId";
			
			if($this->update($Query,$Arr)){
				$Response="OK";
			}else{
				$Response="Error";
			}
		}else{
			$Response="exist";
		}
		return $Response;
	}

	
} //fin clase rol

?>