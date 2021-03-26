<?php

class Dashboard extends Controllers{
	public function __construct(){
		parent::__construct();
	}

	public function dashboard(){
		// echo "<br>Mensaje desde el controlador Home";
		$data['tag_page']="Dashboard";
		$data['page_title']="Dashboard - tienda virtual";
		$data['page_name']="Reporteria";
		$data['page_id']=3;
		$this->views->getView($this,"Dashboard",$data);
	}

	
	}

?>