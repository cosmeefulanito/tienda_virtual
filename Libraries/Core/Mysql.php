<?php

class Mysql extends Conexion{
	private $conexion;
	private $strquery;
	private $arrValues;


	function __construct(){
			$this->conexion = new Conexion();
			$this->conexion = $this->conexion->conect();
	}

	// Método para guardar un registro
	public function insert(string $query, array $arrValues){
		$this->strquery = $query;
		$this->arrValues = $arrValues;

		$insert = $this->conexion->prepare($this->strquery);
		$result = $insert->execute($this->arrValues);
		if($result){
			$lastInsertId = $this->conexion->lastInsertId();
		}else{
			$lastInsertId=0;
		}

		return $lastInsertId;

	}
	// obtenemos un registro
	public function select(string $query){
		$this->strquery = $query;
		$result = $this->conexion->prepare($this->strquery);
		$result->execute();
		$response = $result->fetch(PDO::FETCH_ASSOC);
		return $response;
	}

	// Devuelve todos los registros
	public function select_All(string $query){
		$this->strquery = $query;
		$result = $this->conexion->prepare($this->strquery);
		$result->execute();
		$response = $result->fetchAll(PDO::FETCH_ASSOC);
		return $response;		
	}

	// Actualiza un registro
	public function update(string $query, array $arr){
		$this->strquery = $query;
		$this->arrValues = $arr;
		$update = $this->conexion->prepare($this->strquery);		
		$response = $update->execute($this->arrValues);
		return $response;
	}

	// Actualiza un registro
	public function delete(string $query){
		$this->strquery = $query;		
		$result = $this->conexion->prepare($this->strquery);		
		$result->execute();
		return $result;
	}
}

?>