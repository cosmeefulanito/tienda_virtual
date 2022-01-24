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


	public function deletePermisos(int $rolid){
		$this->intRolId = $rolid;
		$sql = "DELETE FROM permisos WHERE rolid = $this->intRolId";
		$request = $this->delete($sql);		
		return $request;
	}

	public function insertPermisos(int $idrol, int $idmodulo, int $r, int $w ,int $u, int $d){		
		$this->intRolId = $idrol;
		$this->intModuloId = $idmodulo;
		$this->r = $r;
		$this->w = $w;
		$this->u = $u;
		$this->d = $d;

		$Query ="INSERT INTO permisos (rolid,moduloid,r,w,u,d) values (?,?,?,?,?,?)";
		$arrPermisos = array($this->intRolId,$this->intModuloId,$this->r,$this->w,$this->u,$this->d);
		$Request = $this->insert($Query,$arrPermisos);
		return $Request;
	}

	public function permisosModulo(int $idrol){		
		$this->intRolId = $idrol;
		$Query ="SELECT perm.rolid, perm.id as idpermiso, perm.r, perm.w,perm.u,perm.d, modu.id as idmodulo, modu.titulo FROM permisos perm
				INNER JOIN modulo modu ON modu.id = perm.moduloid WHERE perm.rolid='{$this->intRolId}'";
				// echo $Query;
		$Request = $this->select_All($Query);
		// dep($Request);
		$arrPermisos = array();
		for ($i=0; $i < count($Request) ; $i++) {
			$arrPermisos[$Request[$i]['idmodulo']] = $Request[$i];
		}
		// dep($arrPermisos);
		return $arrPermisos;
	}

	

	
} //fin clase permisos

?>