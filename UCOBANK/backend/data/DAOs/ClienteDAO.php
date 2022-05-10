<?php
    require("../common/DBConnection.php");
    require("../../classes/cliente.php");
    

    function getAllUsers()
    {
        $DB = new DBConnection(); 
        $Connection = $DB->OpenCon();
        $consulta = "SELECT * FROM i92rurof.clientes "; 
        if ($resultado = $Connection->query($consulta)) 
        {
            $row = $resultado->fetch_array(MYSQLI_ASSOC);
            foreach ($resultado as $row)
            {
                $ClienteAux = new Cliente($row['name'], $row['DNI'], $row['sucursal'], $row['telefono'], $row['correo'], $row['fecha_nacimiento'], $row['password'], $row['name']); 
            }
 
        }
        $resultado->close(); 
    }

    function isValidUser(string $user, string $password)
    {
        

    }

    getAllUsers();
?>
