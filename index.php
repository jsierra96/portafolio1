<?php
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/
    
    require_once 'config/Autoload.php';
    require_once 'config/Input.php';
    require_once 'config/Core.php';
    
    $router = isset($_GET['router']) && !empty($_GET['router']) ? explode('/', $_GET['router']) : null;

    if( $router ) {
        if($router[0] == '404' || $router[0] == '403' || $router[0] == '500') {
            $nombre_controlador = 'Danger';
        } else {
            $nombre_controlador = ucfirst($router[0]);
        }
        
    } else {
        $nombre_controlador = 'Home';
    }

    if(class_exists($nombre_controlador)) {	

        $controlador = new $nombre_controlador();
        
	    if(isset($router) && count($router) >= 2 && !empty($router[1])) {
            $nombre_metodo = $router[1];

            if(method_exists($controlador, $nombre_metodo)) {

                if(count($router) > 2) {
                    unset($router[0], $router[1]);
                    $controlador->$nombre_metodo(...$router);
                } else {
                    $controlador->$nombre_metodo();
                }
                
            } else {
                header("HTTP/1.0 404 Not Found");
                header("Status: 404 Not Found");
                include 'view/error/404.php';
            }
	    }else{
            if(method_exists($controlador, 'index')) {
                $controlador->index();
            } else if($router[0] == '404') {
                $controlador->notFound();
            } else if($router[0] == '403') {
                $controlador->forbidden();
            } else if($router[0] == '500') {
                $controlador->FatalError();
            } else {
                header("HTTP/1.0 404 Not Found");
                header("Status: 404 Not Found");
                include 'view/error/404.php';
            }
	    }
    }else{
        header("HTTP/1.0 404 Not Found");
        header("Status: 404 Not Found");
        include 'view/error/404.php';
    }