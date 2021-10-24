<?php

require "vendor/autoload.php";
use eftec\bladeone\BladeOne;
use Framework\Classes\config;
use Framework\Classes\router;

$request = $_SERVER['REQUEST_URI'];
$route = new router();

require 'routes/routes.php';

$routes = $route->getRoutes();

$file = array_search($request,  array_column($routes['files'], 'request'));

if($file === false){
    $controller = array_search($request,  array_column($routes['controllers'], 'request'));
}

if($file !== false) {
    $views = __DIR__ . '/views';
    $cache = __DIR__ . '/cache';
    
    $blade = new BladeOne($views,$cache);
    
    if(isset($routes['files'][$file]['variables'])) {
        $routes['files'][$file]['variables']['baseUrl'] = $_SERVER['SERVER_NAME'];
        $routes['files'][$file]['variables']['route'] = $_SERVER['REQUEST_URI'];
        echo $blade->run($routes['files'][$file]['file'],$routes['files'][$file]['variables']);
    } else {
        echo $blade->run($routes['files'][$file]['file'], ["baseUrl" => $_SERVER['SERVER_NAME'], "route" => $_SERVER['REQUEST_URI']]);
    }
} else if ($controller !== false) {
    $controllers = __DIR__ . '/controllers';
    $cache = __DIR__ . '/cache';

    require 'src/classes/controller.php';
    require $controllers . '/' . $routes['controllers'][$controller]['controller'] . '.php';

    $class = new $routes['controllers'][$controller]['controller'];
    $method = $routes['controllers'][$controller]['method'];
    $class->$method();
} else {
    $views = __DIR__ . '/views/errors';
    $cache = __DIR__ . '/cache';
    
    $blade = new BladeOne($views,$cache);
    echo $blade->run('404');
}
