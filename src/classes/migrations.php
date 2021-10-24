<?php

    namespace Framework\Classes;

    class migrations {
        private $migrations;

        public function exec() {
            $db = new database;
            foreach ($this->migrations as $sql) {
                $db->query($sql);
            }
        }
        
        /**
         * addMigration
         *
         * @param  string $query
         * @return void
         */
        public function addMigration($query) {
            $this->migrations[] = $query;
        }

    }