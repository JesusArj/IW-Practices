<?php

if(isset($_POST['idCliente']) &&  isset($_POST['tipo']))
{
    $idCliente = $_POST['idCliente']; 
    $tipo = $_POST['tipo'];
    generarTarjetaCliente($idCliente, $idCuenta); 
}

?>