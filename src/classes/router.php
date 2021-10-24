<?php

    namespace Framework\Classes;

    class router 
    {

        private $routes = [];
               
        /**
         * addRoute
         *
         * @param  string $uri
         * @param  string $file
         * @param  array $variables
         * @return void
         */
        public function addRoute($uri, $file, $variables = null) {
            $this->routes['files'][] = ['request' => $uri,'file' => $file, 'variables' => $variables];
        }
        
        /**
         * addController
         *
         * @param string $uri
         * @param string $controller
         * @param string $method
         * @return void
         */
        public function addController($uri, $controller, $method) {
            $this->routes['controllers'][] = ['request' => $uri,'controller' => $controller, 'method' => $method];
        }
        
        /**
         * getRoutes
         *
         * @return $routes
         */
        public function getRoutes() {
            return $this->routes;
        }
    }

    require __DIR__.'/../../vendor/autoload.php';
    