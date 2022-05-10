

<?php

class DBConnection
{
    private $servername = "oraclepr.uco.es:3306/i92rurof";
    private $username = "i92rurof";
    private $password = "bdPW_2122";

    public function OpenCon()
    {
        $conn = new mysqli($this->servername, $this->username, $this->password);
        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

}


?> 