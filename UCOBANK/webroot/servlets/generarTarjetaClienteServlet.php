<?php


if(isset($_POST['idCliente']) &&  isset($_POST['idCuenta']))
{
    $idCliente = $_POST['idCliente']; 
    $idCuenta = $_POST['idCliente'];
    generarTarjetaCliente($idCliente, $idCuenta); 
}



?>