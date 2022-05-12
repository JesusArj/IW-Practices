<?php
include("../../backend/data/DAOs/ClienteDAO.php"); 

function validateDNI($dni)
{
    $letra = substr($dni, -1);
    $numeros = substr($dni, 0, -1);
    if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen ($numeros) == 8 )
    {
      return true;
    }
    else
    {
      return false;
    }
}

if(isset($_POST['name']) &&  isset($_POST['dni']) &&  isset($_POST['mail']) &&  isset($_POST['phone']))
{
    $name = $_POST['name']; 
    $dni = $_POST['dni']; 
    $mail = $_POST['mail']; 
    $phone = $_POST['phone'];

    if(preg_match('/^[\p{L}\p{N} .-]+$/', $name) && validateDNI($dni) && (strlen($phone) == 9))
    {
        uploadClient($name, $dni, $mail, $phone); 
        echo "<script>
        alert('El formulario se ha enviado correctamente.');
        window.location.href='../index.html';
        </script>";
    }
    else
    {
        echo "<script>
        alert('Error en el envío de los datos, por favor, compruebe los datos introducidos.');
        window.location.href='../index.html';
        </script>";
    }

}


?>