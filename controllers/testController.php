<?php

    use Framework\Classes\database;
    class testController extends controller {

        public function index() {

            $db = new database();

            $getBlogSQL = 'SELECT * FROM blog WHERE id = 1';
            $getBlog = $db->query($getBlogSQL);

            $secured = securePassword('ciao');
            
            $verify = verifySecurePassword('prova', $secured);

            return view('test', $getBlog);
        }

    }