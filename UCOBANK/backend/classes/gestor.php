<?php 
include("user.php");

class Gestor extends User
{

private string $usuario_; 
private $ArrayIdsUsuarios = []; 

    public function __constructor(string $name, string $dni, int $sucursalNumber, int $telefono, string $correo, string $fechaNacimiento, string $password, string $usuario)
    {
        parent::__construct($name, $dni,$sucursalNumber,$telefono,$correo,$fechaNacimiento,$password);
        $this->usuario_ = $usuario;  
    }

    public function getUsuario()
    {
        return $this->usuario_; 
    }
    public function setUsuario(string $usuario)
    {
        $this->usuario_ = $usuario; 
    }
    public function addIDtoArray(int $id)
    {
        array_push($this->ArrayIdsUsuarios, $id);
    }

}
?>