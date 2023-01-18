<?php
Class Input {
    private $index;
    
    public function get( $key = null ) {
        $data = null;
        $auxiliar = (isset($_GET) && !empty($_GET)) ? $_GET : null;
        if(array_key_exists('router', $auxiliar)) {
            unset($auxiliar['router']);
        }
        if(count($auxiliar) > 0) {
            if( $key != null) {
                if(array_key_exists($key, $auxiliar)) {
                    $data = $auxiliar[$key];
                } else {
                    $data = null;
                }
            } else {
                $data = $auxiliar;
            }
        }
        return $data;
    }
    
    public function post( $key = null ) {
        $data = null;
        
        if(isset($_POST) && !empty($_POST)) {
            if( $key != null) {
                if(array_key_exists($key, $_POST)) {
                    $data = $_POST[$key];
                } else {
                    $data = null;
                }
            } else {
                $data = $_POST;
            }
        }
        return $data;
    }
    
    public function put($key = null) {
        $data = null;
        
        if($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            
            
            
            if(isset($request) && !empty($request)) {
                if( $key != null) {
                    if(array_key_exists($key, $request)) {
                        $data = $request[$key];
                    } else {
                        $data = null;
                    }
                } else {
                    $data = $request;
                }
            }
        }
        return $data;
    }
    
    public function delete($key = null) {
        $data = null;
        
        if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            
            
            
            if(isset($request) && !empty($request)) {
                if( $key != null) {
                    if(array_key_exists($key, $request)) {
                        $data = $request[$key];
                    } else {
                        $data = null;
                    }
                } else {
                    $data = $request;
                }
            }
        }
        
        return $data;
    }
}