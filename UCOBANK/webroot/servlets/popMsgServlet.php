<?php
include("../../backend/data/DAOs/ClienteDAO.php"); 

if(isset($_POST['idMensaje']))
{
    $idMensaje = $_POST['idMensaje']; 
    popMsg($idMensaje); 
}

if(isset($_POST['idUser']))
{
    $idUser = $_POST['idUser']; 
    popMsgUser($idUser); 
}

?>