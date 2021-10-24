<?php

    namespace Framework\Classes;

    class config {

        private $env;
        private $prefix;
        private $key;

        public function __construct() {
            $env = file_get_contents(__DIR__ . '/../../env');
            $env = explode(',', $env);
            
            foreach ($env as $key => $value) {
                $data = explode(':', $value);
                
                $env[$key] = [
                    'type' => trim($data[0]),
                    'value' => trim($data[1]),
                ];
            }
            
            $keyExist = array_filter($env, function($value) {
                return $value['type'] == 'key_env';
            });

            if($keyExist == []) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 50; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }

                $message = PHP_EOL . "key_env: $randomString";
                file_put_contents(__DIR__ . '/../../env', $message, FILE_APPEND);$randomString;

                $env = file_get_contents(__DIR__ . '/../../env');
                $env = explode(',', $env);
                
                foreach ($env as $key => $value) {
                    $data = explode(':', $value);
                    
                    $env[$key] = [
                        'type' => trim($data[0]),
                        'value' => trim($data[1]),
                    ];
                }
            }

            $this->env = $env;
        }
        
        /**
         * getData
         *
         * @param  string $prefix
         * @return array $data
         */
        public function getData($prefix) {
            $this->prefix = $prefix;
            $data = array_filter($this->env, function($value) {
                $value['type'] = explode('_', $value['type']);
                return $value['type'][0] == $this->prefix;
            });
            return $data;
        }
        
        /**
         * getValue
         *
         * @param  string $key
         * @return string $$data['value']
         */
        public function getValue($key) {
            $this->key = $key;
            $data = array_filter($this->env, function($value) {
                return $value['type'] == $this->key;
            });

            foreach ($data as $value) {
                $data = $value;
            }
            
            return $data['value'];
        }

    }