<?php

    class DBConnection
    {
        private $server = "sql211.epizy.com";
        private $user = "epiz_31650333";
        private $pass = "ggzgUIXnNAvOaLM";
        private $db = "epiz_31650333_ucobank";

        public function OpenCon()
        {
            $conn =  new PDO("mysql:host={$this->server};dbname={$this->db};charset=utf8", $this->user, $this->pass);
            return $conn;
        }
    }
    $db = new DBConnection();
    $db->OpenCon(); 

?>