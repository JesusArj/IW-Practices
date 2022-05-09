<?php 
    include("user.php"); 
    class Cliente extends User
    {
        private string $cuentaBancaria_; 
        private int $numTarjeta_;
        private string $gestorAsociado_;  

        public function __constructor(string $name, string $dni, int $sucursalNumber, int $telefono, string $correo, string $fechaNacimiento, string $password, string $cuentaBancaria, int $numTarjeta, string $gestorAsociado)
        {
            parent::__construct($name, $dni,$sucursalNumber,$telefono,$correo,$fechaNacimiento,$password);
            $this->cuentaBancaria_ = $cuentaBancaria; 
            $this->numTarjeta_= $numTarjeta; 
            $this->gestorAsociado_ = $gestorAsociado; 
        }

        public function getCuentaBancaria()
        {
            return $this->cuentaBancaria_; 
        }
        public function getTarjeta()
        {
            return $this->numTarjeta_; 
        }
        public function getGestorAsociado()
        {
            return $this->gestorAsociado_; 
        }

        public function setCuentaBancaria(string $cuentaBancaria)
        {
            $this->cuentaBancaria_ = $cuentaBancaria; 
        }
        public function setTarjeta(int $tarjeta)
        {
            $this->numTarjeta_ = $tarjeta; 
        }
        public function setGestorAsociado(string $gestor)
        {
            $this->gestorAsociado_ = $gestor; 
        }
    }    
?>