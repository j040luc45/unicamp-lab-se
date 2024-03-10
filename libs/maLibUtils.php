<?php

function validate($nom,$type="REQUEST") {	
	switch($type){
		case 'REQUEST': 
		if(isset($_REQUEST[$nom]) && !($_REQUEST[$nom] == "")) 	
			return $_REQUEST[$nom]; 	
		break;
		case 'GET': 	
		if(isset($_GET[$nom]) && !($_GET[$nom] == "")) 			
			return $_GET[$nom]; 
		break;
		case 'POST': 	
		if(isset($_POST[$nom]) && !($_POST[$nom] == "")) 	
			return $_POST[$nom]; 		
		break;
		case 'COOKIE': 	
		if(isset($_COOKIE[$nom]) && !($_COOKIE[$nom] == "")) 	
			return $_COOKIE[$nom];	
		break;
		case 'SESSION': 
		if(isset($_SESSION[$nom]) && !($_SESSION[$nom] == "")) 	
			return $_SESSION[$nom]; 		
		break;
		case 'SERVER': 
		if(isset($_SERVER[$nom]) && !($_SERVER[$nom] == "")) 	
			return $_SERVER[$nom]; 		
		break;
	}
	return false; 
}

function setData(&$data, $success, $status) {
	$data["success"] = $success;
	$data["status"] = $status;
}

function verifyAllParameters($names, $otherNames = array()) {
	$result = array();
	foreach ($names as $name) {
		if ($value = valider($name))
			$result[$name] = $value;
		else
			return false;
	}
	foreach ($otherNames as $name) {
		if ($value = valider($name))
			$result[$name] = $value;
		else 
			$result[$name] = "";
	}

	return $result;
}


?>