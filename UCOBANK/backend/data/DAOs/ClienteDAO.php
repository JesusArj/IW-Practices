<?php
    require("../../backend/data/common/DBConnection.php");
    require("../../backend/classes/cliente.php");
    

    function getAllClients()
    {
        $DB = new DBConnection(); 
        $Connection = $DB->OpenCon();
        $consulta = "SELECT * FROM i92rurof.clientes "; 
        $ArrayClientes = array();
        if ($resultado = $Connection->query($consulta)) 
        {
            $row = $resultado->fetch_array(MYSQLI_ASSOC);
            foreach ($resultado as $row)
            {
                $ClienteAux = new Cliente($row['nombre'], $row['DNI'], $row['sucursal'], $row['telefono'], $row['correo'], $row['fecha_nacimiento'], $row['password'], $row['gestor'], $row['ID']);
                array_push($ArrayClientes,$ClienteAux);
            }
 
        }
        $resultado->close();
        $Connection->close(); 
        return $ArrayClientes; 
    }

    function isValidUser(string $dni, string $password)
    {
       $AllClientes = getAllClients(); 
       foreach ( $AllClientes as $cliente)
       {
           if( ($cliente->getDNI()== $dni ) && ($cliente->getPassword() == $password) )
           {
                return true; 

           }
       }
       return false; 
    }

    function getIDbyDNI(string $dni)
    {
        $AllClientes = getAllClients();
        foreach ($AllClientes as $cliente)
        {
            if( ($cliente->getDNI() == $dni ))
            { 
                return $cliente->getID(); 
            }
        }
    }
    
    function uploadClient($name, $dni, $mail, $phone)
    {
        $DB = new DBConnection(); 
        $Connection = $DB->OpenCon();
        $consulta = "INSERT INTO i92rurof.clientes (DNI, nombre, sucursal, telefono, correo, verificado, gestor) VALUES ('$dni', '$name', '1', '$phone', '$mail','0','1' )"; 

        if(!$Connection->query($consulta)) 
        {
           printf("Query Failed! SQL: $sql - Error: ".mysqli_error($Connection), E_USER_ERROR);
        }
        $Connection->close(); 
    }

    function popMsg($idMsg)
    {
        $DB = new DBConnection(); 
        $Connection = $DB->OpenCon();   
        $consulta = "DELETE FROM i92rurof.mensajes WHERE ID='$idMsg'"; 
        if(!$Connection->query($consulta))
        {
            printf("Query Failed! SQL: $sql - Error: ".mysqli_error($Connection), E_USER_ERROR);
        } 
        $Connection->close(); 
    }
    
    function popMsgUser($idUser)
    {
        $DB = new DBConnection(); 
        $Connection = $DB->OpenCon();   
        $consulta = "DELETE FROM i92rurof.mensajes WHERE cliente='$idUser'"; 
        if(!$Connection->query($consulta))
        {
            printf("Query Failed! SQL: $sql - Error: ".mysqli_error($Connection), E_USER_ERROR);
        } 
        $Connection->close(); 
    }

?>
