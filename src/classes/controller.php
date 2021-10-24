<?php

    use Framework\Classes\config;
    use eftec\bladeone\BladeOne;
    
    class controller {

        public function index() {

        }

        public function create() {

        }

        public function update() {

        }

        public function delete() {

        }
    }
    
    /**
     * view
     *
     * @param  string $file
     * @param   array $variables
     * @return void
     */
    function view($file, $variables = null) {
        $views = __DIR__ . '/../../views';
        $cache = __DIR__ . '/../../cache';
        
        $blade = new BladeOne($views,$cache);
        if(isset($variables)) {
            $variables["baseUrl"] = $_SERVER['SERVER_NAME'];
            $variables["route"] = $_SERVER['REQUEST_URI'];
            echo $blade->run($file,$variables);
        } else {
            echo $blade->run($file, ["baseUrl" => $_SERVER['SERVER_NAME'], "route" => $_SERVER['REQUEST_URI']]);
        }
    }
    
    /**
     * secure
     *
     * @param  string $string
     * @return string $secured
     */
    function securePassword($string) {
        $config = new config();
        $key = $config->getValue('key_env');
        $string = $string . $key;
        $secured = password_hash($string, PASSWORD_BCRYPT);
        $config = null;
        return $secured;
    }
    
    /**
     * verifySecure
     *
     * @param  string $string1
     * @param  string $string2
     * @return bool $verify
     */
    function verifySecurePassword($string1, $string2) {
        $config = new config();
        $key = $config->getValue('key_env');
        $string1 = $string1 . $key;
        $verify = password_verify($string1, $string2);
        $config = null;
        return $verify;
    }

    function getBaseUrl() {
        return $_SERVER['SERVER_NAME'];
    }

    function getRoute() {
        return $_SERVER['REQUEST_URI'];
    }