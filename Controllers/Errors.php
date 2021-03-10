<?php

class Errors extends Controllers{
	
	public function __construct(){
		parent::__construct();
	}

	public function notFound(){		
		$this->views->getView($this,"Error");
	}
}

$Errors = new Errors();
$Errors->notFound();

?>