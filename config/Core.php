<?php
/*****************************************************************
 *        Trata de formar la URL base de manera dinámica
*****************************************************************/
    if (isset($_SERVER['HTTPS'])) {
        $protocol = 'https://';
    } else {
        $protocol = 'http://';
    }

    $directoryPadre = dirname(__DIR__);
    $segments = explode(DIRECTORY_SEPARATOR, $directoryPadre);
    $carpetaProyecto = $segments[count($segments) - 1];

    $requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', $requestUrl);
    $dossier = empty($segments[1]) ? "" : $segments[1];
    $url = $protocol . $_SERVER["SERVER_NAME"] . '/';
    //echo $url;
    if (is_array($segments) && in_array($carpetaProyecto, $segments)) {
        foreach ($segments as $path) {
            if ($path != '') {
                $url .= $path . '/';
                if ($path == $carpetaProyecto) {
                    break;
                }
            }
        }
    }
    define('base_url', $url);
/*****************************************************************
 *              Variables para el archivo Conexión.php
*****************************************************************/
    define('HOST', 'localhost');

    define('PASSWORD', '');

    define('USER', '');

    define('DATABASE', '');
