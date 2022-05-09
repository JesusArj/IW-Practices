<?php
    require("../common/DBConnection.php");
    require("../../classes/cliente.php");
    
    $DB = new DBConnection(); 

    function getAllUsers()
    {
        $DB->OpenCon();
        $consulta = "SELECT * FROM clientes"; 
        if($resultado  = $Connection->query($consulta))
        {
            while ($fila = $resultado->fetch_row()) {
                printf ("%s (%s)\n", $fila[0], $fila[1]);
            }
            $resultado->close();
        }
    }

    function isValidUser(string $user, string $password)
    {
        

    }
    getAllUsers();
?>