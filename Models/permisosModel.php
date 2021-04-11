<?php

class permisosModel extends Mysql{
	public $intId;
	public $intRolId;
	public $intModuloId;
	public $r;
	public $w;
	public $u;
	public $d;

	public function __construct(){
		parent::__construct();
	}

	public function selectModulos(){
		$sql = "SELECT * FROM modulo WHERE status !=0";
		$request = $this->select_All($sql);
		return $request;
	}

	public function selectPermisosRol(int $rolid){
		$this->intRolId = $rolid;
		$sql = "SELECT * FROM permisos WHERE rolid = $this->intRolId";
		$request = $this->select_All($sql);		
		return $request;
	}

	

	
} //fin clase permisos

?>