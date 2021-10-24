<?php
    class migrationBlog extends migration {
        public function migrate() {
            $this->setTable('blog');
            $this->addCol('id', 'int', false);
            $this->addCol('title', 'varchar(255)', false);
            $this->addCol('description', 'text', true);
            $this->setPrimaryKey('id');
        }
    }