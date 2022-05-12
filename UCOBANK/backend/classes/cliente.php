<?php 
    include("user.php"); 
    class Cliente extends User
    {

        private string $gestorAsociado_; 
        private int $ID_; 

        public function __construct(string $name, string $dni, int $sucursalNumber, int $telefono, string $correo, string $fechaNacimiento, string $password, string $gestorAsociado, int $id)
        {
            parent::__construct($name, $dni,$sucursalNumber,$telefono,$correo,$fechaNacimiento,$password);
            $this->gestorAsociado_ = $gestorAsociado; 
            $this->ID_ = $id; 
        }

        public function getGestorAsociado()
        {
            return $this->gestorAsociado_; 
        }

        public function getID()
        {
            return $this->ID_; 
        }


        public function setGestorAsociado(string $gestor)
        {
            $this->gestorAsociado_ = $gestor; 
        }
        public function setID(int $id)
        {
            $this->ID_ = $id; 
        }
        
    }    
?>