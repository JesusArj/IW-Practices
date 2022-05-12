<?php
    require("../../backend/data/common/DBConnection.php");
    require("../../backend/classes/cliente.php");
    
    $DB = new DBConnection(); 

    function getAllClients()
    {
        global $DB; 
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
        $Connection = $DB->OpenCon();
        return $ArrayClientes; 
    }

    function isValidUser(string $dni, string $password)
    {
        global $DB; 
        $Connection = $DB->OpenCon();
       $AllClientes = getAllClients(); 
       foreach ( $AllClientes as $cliente)
       {
           if( ($cliente->getDNI()== $dni ) && ($cliente->getPassword() == $password) )
           {
                return true; 

           }
       }
       $Connection->close(); 
       return false; 
    }

    function getIDbyDNI(string $dni)
    {
        global $DB; 
        $Connection = $DB->OpenCon();
        $AllClientes = getAllClients();
        foreach ($AllClientes as $cliente)
        {
            if( ($cliente->getDNI() == $dni ))
            { 
                return $cliente->getID(); 
            }
        }
        $Connection->close(); 
    }
    
    function uploadClient($name, $dni, $mail, $phone)
    {
        global $DB; 
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
        global $DB; 
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
        global $DB; 
        $Connection = $DB->OpenCon();
        $consulta = "DELETE FROM i92rurof.mensajes WHERE cliente='$idUser'"; 
        if(!$Connection->query($consulta))
        {
            printf("Query Failed! SQL: $sql - Error: ".mysqli_error($Connection), E_USER_ERROR);
        } 
        $Connection->close(); 
    }

    function upUserMoney($idUser, $money)
    {
        global $DB; 
        $Connection = $DB->OpenCon();
        $consulta = "UPDATE i92rurof.cuentas SET saldo=saldo+$money WHERE cliente='$idUser'"; 
        if(!$Connection->query($consulta))
        {
            printf("Query Failed! SQL: $sql - Error: ".mysqli_error($Connection), E_USER_ERROR);
        }  
        $Connection->close(); 
    }

    function downUserMoney($idUser, $money)
    {
        global $DB; 
        $Connection = $DB->OpenCon();
        $consulta = "UPDATE i92rurof.cuentas SET saldo=saldo-$money WHERE cliente='$idUser'"; 
        if(!$Connection->query($consulta))
        {
            printf("Query Failed! SQL: $sql - Error: ".mysqli_error($Connection), E_USER_ERROR);
        }  
        $Connection->close(); 
    }

    function transferirDinero($receptor, $emisor, $concepto, $cantidad, $tipo)
    {
        global $DB; 
        $Connection = $DB->OpenCon();
        $zonahoraria = new DateTimeZone('Europe/Paris'); 
        $fecha = new DateTime();
        $fecha->setTimezone($zonahoraria);
        $fechaFormateada = $fecha->format('Y-m-d');
        $consulta = "INSERT INTO i92rurof.movimientos (tipo, fecha, cantidad, receptor, emisor, concepto) VALUES ('$tipo', '$fechaFormateada', '$cantidad', '$receptor', '$emisor', '$concepto')";
        if($Connection->query($consulta))
        {
            upUserMoney($receptor, $cantidad); 
            downUserMoney($emisor, $cantidad);  
        }
        else
        {
            printf("Query Failed! SQL: $sql - Error: ".mysqli_error($Connection), E_USER_ERROR);
        }  
        $Connection->close(); 
    }
    
    function creditCardExist($numero)
    {
        global $DB; 
        $Connection = $DB->OpenCon();
        $consulta = "SELECT numero FROM i92rurof.tarjetas";
        if ($resultado = $Connection->query($consulta)) 
        {
            $row = $resultado->fetch_array(MYSQLI_NUM);
        }
        else
        {
            printf("Query Failed! SQL: $sql - Error: ".mysqli_error($Connection), E_USER_ERROR);
            exit; 
        }
        foreach($row as $numeroT)
        {
            if(strval($numeroT) == strval($numero))
            {
               return true; 
            }
        }
        $Connection->close(); 
        return false; 
    }   

    function generarTarjetaCliente($idCliente, $idCuenta)
    {
        global $DB; 
        $Connection = $DB->OpenCon();

        $numero = random_int(0000000000000000,9999999999999999); 
        if(strlen($numero)==16)
        {
            if(creditCardExist($numero))
            {
                generarTarjetaCliente($idCliente);
            }
            else
            {
                $CVV = random_int(000,999);
                $FechaCaducidad = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 1460 day"));
                $consulta = "INSERT INTO i92rurof.tarjetas (numero, caducidad, cvv, cliente, cuenta) VALUES ('$numero', '$FechaCaducidad', '$CVV', '$idCliente', '$idCuenta')";
                if(!$Connection->query($consulta))
                {
                    printf("Query Failed! SQL: $sql - Error: ".mysqli_error($Connection), E_USER_ERROR);
                    $Connection->close(); 
                    exit; 
                }
            }
        }
        else
        {
            generarTarjetaCliente($idCliente); 
        }
        $Connection->close(); 
    }

    function cuentaBancariaExist($CodigoIBAN)
    {
        global $DB; 
        $Connection = $DB->OpenCon();
        ///
        $consulta = "SELECT numero FROM i92rurof.cuentas";
        if ($resultado = $Connection->query($consulta)) 
        {
            $row = $resultado->fetch_array(MYSQLI_NUM);
        }
        else
        {
            printf("Query Failed! SQL: $sql - Error: ".mysqli_error($Connection), E_USER_ERROR);
            exit; 
        }
        foreach($row as $numeroCuenta)
        {
            if(strval($numeroCuenta) == strval($CodigoIBAN))
            {
               return true; 
            }
        }
        $Connection->close(); 
        return false; 
        ///
    }

    function generarCuentaCliente($idCliente, $tipo)
    {
        global $DB; 
        $Connection = $DB->OpenCon();
        $digito_control = 12; 
        $entidad=1234; 
        $oficina = 0001; 
        $numerocuenta = random_int(0000000000,9999999999); 
        $CodigoIBAN = ("ES" . strval($digito_control) . strval($entidad) . strval($oficina) . strval($digito_control) . strval($numerocuenta)); 
        if(cuentaBancariaExist($CodigoIBAN))
        {
            generarCuentaCliente($idCliente, $tipo); 
        }
        else
        {
            $consulta = "INSERT INTO i92rurof.cuentas (numero, saldo, tipo, cliente) VALUES ('$numerocuenta', '0', '$tipo', '$idCliente')";
            if (!$Connection->query($consulta)) 
            {
                printf("Query Failed! SQL: $sql - Error: ".mysqli_error($Connection), E_USER_ERROR);
                exit; 
            }
        }


        $Connection->close(); 
    }
?>