<?php

    if(isset($_POST['idCliente']) &&  isset($_POST['cantidad']))
    {
        $idCliente = $_POST['idCliente']; 
        $cantidad = $_POST['cantidad'];
        downUserMoney($idUser, $cantidad); 
    }

?>