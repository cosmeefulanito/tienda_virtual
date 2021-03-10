<?php

class Home extends Controllers{
	public function __construct(){
		parent::__construct();
	}

	public function home(){
		// echo "<br>Mensaje desde el controlador Home";
		$data['tag_page']="Home";
		$data['page_title']="Home pagina principal";
		$data['page_name']="Inicio";
		$data['page_id']=5;
		$this->views->getView($this,"Home",$data);
	}

	public function insertar(){
		$data = $this->model->setUser("Mati", 21);
		print_r($data);
	}

	public function verUsuario($id){
		$result = $this->model->getUser($id);
		print_r($result);
	}

	public function actualizar(){
		$result = $this->model->updateUser(3, "Camila", 15);
		print_r($result);
	}

	public function verUsuarios(){
		$result = $this->model->getUsers();
		echo "<pre>";		
		print_r($result);
		echo "</pre>";
	}

	public function eliminarUsuario($id){
		$result = $this->model->deleteUsers($id);
		echo "<pre>";		
		print_r($result);
		echo "</pre>";
	}
}

?>