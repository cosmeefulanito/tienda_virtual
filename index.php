<?php
require_once("Config/Config.php");
require_once("Helpers/Helpers.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

$url = !empty($_GET['url']) ? $_GET['url'] : 'home/home';
$arr = explode("/", $url);

$controller = $arr[0];
$method = $arr[0];
$params="";
// Valido que el metodo exista
if(!empty($arr[1])){
	if($arr[1] !=""){
		$method = $arr[1];
	}
}

// valido que los parametros existan y los recorro
if(!empty($arr[2])){
	if($arr[2] !=""){
		
		for ($i=2; $i < count($arr); $i++) { 
			$params.= $arr[$i].",";
		}
		$params = trim($params,","); //quita la ultima coma		
	}
}

require_once("Libraries/Core/Autoload.php");
require_once("Libraries/Core/Load.php");


?>


