<?php

class loginModel extends Mysql{
	private $intId;
	private $strEmail;
	private $strPassword;
	private $strToken;

	public function __construct(){
		parent::__construct();
	}

	public function authUsuario(string $email, string $pass){
		$this->strEmail = $email;
		$this->strPassword = $pass;

		$sql = "SELECT * FROM persona WHERE email = '$this->strEmail' AND 
											password ='$this->strPassword' AND status !=0 ";		
		$query = $this->select($sql);
		return $query;
	}

	public function setLoginUser(int $idusuario){
		$this->intId = $idusuario;
		$query="SELECT * FROM persona per
						INNER JOIN rol r WHERE r.id = per.rolid AND per.id = '{$this->intId}' ";
						$Result = $this->select($query);
						$_SESSION['userSession'] = $Result;
						return $Result;
	}

	public function getUserReset(string $email){
		$this->strEmail = $email ;
		$Query="SELECT * FROM persona WHERE email = '{$this->strEmail}' AND status = 1 ";		
		return $this->select($Query);
	}

	public function setTokenPassword(int $idusuario, string $token){
		$this->intId = $idusuario;
		$this->strToken = $token;
		$arrData = array($this->strToken);
		$Query="UPDATE persona SET token = ? WHERE id = '{$this->intId}'";
		return $this->update($Query,$arrData);
	}

	public function getUsuario(string $email, string $token){
		$this->strEmail = $email;
		$this->strToken = $token;
		$Query="SELECT * FROM persona WHERE email = '{$this->strEmail}' AND token = '{$this->strToken}' AND status = 1";
		$Request = $this->select($Query);
		return $Request;
	}

	public function insertPassword(int $id, string $pass){
		$this->intId = $id;
		$this->strPassword =  $pass;
		$Query="UPDATE persona SET password =?, token = ? WHERE id='{$this->intId}' ";
		$arrData = array($this->strPassword, "");
		return $this->update($Query,$arrData);

	}
}
?>