<?php

function autoload_controller($class){

	$controllerPath = 'controller/'.$class.'.php';

	if(file_exists($controllerPath)) {
		include 'controller/' . $class . '.php';
	} else {
        header("HTTP/1.0 404 Not Found");
        header("Status: 404 Not Found");
    }
	
}

spl_autoload_register('autoload_controller');