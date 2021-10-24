<?php

    namespace Framework\Classes;
    
    class database {
        private $config;
        private $db_host;
        private $db_port;
        private $db_user;
        private $db_database;
        private $db_password;

        public function __construct() {
            $this->config = new config;
            $configs = $this->config->getData('db');

            foreach ($configs as $config) {
                switch ($config['type']) {
                    case 'db_host':
                        $this->db_host = $config['value'];
                        break;
                    case 'db_port':
                        $this->db_port = isset($config['value']) ? $config['value'] : null;
                        break;
                    case 'db_user':
                        $this->db_user = $config['value'];
                        break;
                    case 'db_password':
                        $this->db_password = $config['value'];
                        break;
                    case 'db_database':
                        $this->db_database = $config['value'];
                        break;
                }
            }
        }
        
        /**
         * query
         *
         * @param  string $query
         * @return array $data
         */
        public function query($query) {
            try {
                if(isset($this->db_port) && $this->db_port != '') {
                    @$db = new \PDO("mysql:host=$this->db_host;port=$this->db_port;dbname=$this->db_database", $this->db_user, $this->db_password);
                } else {
                    @$db = new \PDO("mysql:host=$this->db_host;dbname=$this->db_database", $this->db_user, $this->db_password);
                }
            } catch (\PDOException $e) {
                echo $e;
                $db = null;
                return null;
            }
            try {
                $data = $db->query($query)->fetch(\PDO::FETCH_ASSOC);
            } catch (\Throwable $th) {
                $db = null;
                return null;
            }
            $db = null;
            return $data;
        }

    }