<?php

class rolesModel extends Mysql{

	public function __construct(){
		parent::__construct();
	}

	public function getRoles(){
		$Query="SELECT * FROM rol WHERE status !=0";
		$Result = $this->select_All($Query);
		return $Result;
	}

	
}

?>