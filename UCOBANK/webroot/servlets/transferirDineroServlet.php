<?php
require("../../backend/data/DAOs/ClienteDAO.php"); 

if(isset($_POST['IDreceptor']) &&  isset($_POST['IDemisor']) &&  isset($_POST['concepto']) &&  isset($_POST['cantidad']) && isset($_POST['tipo']))
{
    $receptor = $_POST['IDreceptor'];
    $emisor = $_POST['IDemisor']; 
    $concepto = $_POST['concepto']; 
    $cantidad = $_POST['cantidad']; 
    $tipo = $_POST['tipo']; 
    transferirDinero($receptor, $emisor, $concepto, $cantidad, $tipo); 
}





?>