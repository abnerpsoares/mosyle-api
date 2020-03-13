<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once 'config/Routes.php';

    function __autoload($class) {
        $config = 'config/' . $class . '.php';
        $controller = 'controller/' . $class . '.php';
        $helper = 'helpers/' . $class . '.php';
        $model = 'model/' . $class . '.php';
        if( file_exists($config) ){ include_once $config; }
        if( file_exists($controller) ){ include_once $controller; }
        if( file_exists($helper) ){ include_once $helper; }
        if( file_exists($model) ){ include_once $model; }
    }

    function getCurrentRoute($routes) {
        $op = $_GET['op'];
        $request_method = $_SERVER['REQUEST_METHOD'];
        if( !empty($_GET['urlid']) ){ $op .= '/:iduser'; }
        if( !empty($_GET['third']) ){ $op .= '/' . $_GET['third']; }
        foreach( $routes as $props ){
            if( $props[0] == $op && $props[1] == $request_method ){
                return $props;
            }
        }
        throw new ExceptionHelper('API não encontrada.');
    } 

    try {
        
        $current = getCurrentRoute($routes);
        $currentController = $current[2];
        $currentMethod     = $current[3];
        $currentNeedsToken = $current[4];

        if( !class_exists($currentController) || !method_exists($currentController, $currentMethod) ){
            throw new ExceptionHelper('Erro na rota da API.');
        }

        $class = new $currentController($currentNeedsToken);
        if( empty($_GET['urlid']) ){
            $class->$currentMethod();
        }else{
            $class->$currentMethod($_GET['urlid']);
        }

    }catch(Exception $ex){
        throw new ExceptionHelper($ex->getMessage());
    }

?>