<?php

class Dashboard extends Controllers{
	public function __construct(){
		parent::__construct();
		session_start();
		session_regenerate_id(true);
		if(!isset($_SESSION['login'])){
			header('Location:'.base_url().'/login');
		}
		getPermisosModulo(1);
	}

	public function dashboard(){
		// echo "<br>Mensaje desde el controlador Home";
		$data['tag_page']="Dashboard";
		$data['page_title']="Dashboard - tienda virtual";
		$data['page_name']="Reporteria";
		$data['page_id']=3;
		$data['page_function_js']="functions_dashboard.js";
		$this->views->getView($this,"Dashboard",$data);
	}

	
	}

?>