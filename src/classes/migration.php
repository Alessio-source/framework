<?php

    class migration {

        private $tableName;
        private $primaryKey;
        private $cols;
        private $joins;

        public function migrate() {

        }
        
        /**
         * setTable
         *
         * @param  string $tableName
         * @return void
         */
        public function setTable($tableName) {
            $this->tableName = $tableName; 
        }
        
        /**
         * addCol
         *
         * @param  string $colName
         * @param  string $type
         * @param  boolean $nullable
         * @return void
         */
        public function addCol($colName, $type, $nullable) {
            $this->cols[] = [$colName, $type, $nullable];
        }
        
        /**
         * join
         *
         * @param  array $tableToJoin
         * @param  array $valueToJoin
         * @param  string $type
         * @return void
         */
        public function join($tableToJoin, $colToJoin, $tableColToJoin) {
            $this->joins[] = [$tableToJoin, $colToJoin, $tableColToJoin];
        }
        
        /**
         * setPrimaryKey
         *
         * @param  string $col
         * @return void
         */
        public function setPrimaryKey($col) {
            $this->primaryKey = $col;
        }
        
        /**
         * createSql
         *
         * @return $sql
         */
        public function createSql() {
            $sql = "CREATE TABLE IF NOT EXISTS $this->tableName (";
            //    column1 datatype,
            //    column2 datatype,
            //    column3 datatype,
            foreach ($this->cols as $index => $col) {
                if($col[2] == true) {
                    $sql .= " $col[0] $col[1] NULL,";
                } else {
                    $sql .= " $col[0] $col[1] NOT NULL,";
                }
            }

            if(isset($this->joins)) {
                $sql .= " PRIMARY KEY($this->primaryKey),";
            } else {
                $sql .= " PRIMARY KEY($this->primaryKey) ";
            }

            if(isset($this->joins)) {
                foreach ($this->joins as $key => $join) {
                    if($key < count($this->joins) - 1) {
                        $sql .= " FOREIGN KEY ($join[1])
                        REFERENCES $join[0]($join[2]),";
                    } else {
                        $sql .= " FOREIGN KEY ($join[1])
                        REFERENCES $join[0]($join[2]) ";
                    }
                }
            }

            $sql .= " );";

            return $sql;
        }
        
        /**
         * deleteSQL
         *
         * @return string delete QUERY
         */
        public function deleteSQL() {
            return "DROP TABLE $this->tableName";
        }
    }