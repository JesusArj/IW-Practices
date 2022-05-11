<?php
include("../../backend/data/DAOs/ClienteDAO.php"); 


if(isset($_POST['dni']) &&  isset($_POST['password']))
{
  $dni = $_POST['dni'];
  $password = $_POST['password'];
  if(isValidUser($dni, $password))
  { 
    echo $id;
    session_start();
    $_SESSION["id"]=$id; 
    header("Location: ../views/home.html", TRUE, 301);
    exit;
  }
  else
  {
    header("Location: ../index.html", TRUE, 301);
    exit;
  }
}


?>