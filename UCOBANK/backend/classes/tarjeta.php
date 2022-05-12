<?php 
    include("user.php"); 
    class Tarjeta
    {
        private string $ID_; 
        private int $numero_;
        private string $caducidad_; 
        private int $CVV_; 
        private string $cuenta_;
        private int $idCLiente_;

        public function __constructor(int $id, int $numero, string $caducidad, int $CVV, string $cuenta, int $idCliente)
        {
            $this->ID_ = $id; 
            $this->numero_ = $numero; 
            $this->caducidad_= $caducidad; 
            $this->CVV_ = $CVV; 
            $this->cuenta_ = $cuenta; 
            $this->idCliente_ = $idCliente;
        }

        public function getID()
        {
            return $this->ID_; 
        }

        public function getNum()
        {
            return $this->numero_; 
        }
        public function getCaducidad()
        {
            return $this->caducidad_; 
        }
        public function getCVV()
        {
            return $this->CVV_; 
        }
        public function getCuenta()
        {
            return $this->cuenta_; 
        }
        public function getIDCliente()
        {
            return $this->idCliente_; 
        }
 
        public function setID(int $id)
        {
            $this->ID_ = $id; 
        }

        public function setNum(string $num)
        {
            $this->numero_ = $num; 
        }
        
        public function setCaducidad(string $caducidad)
        {
            $this->caducidad_ = $caducidad; 
        }

        public function setCVV(string $CVV)
        {
            $this->CVV_ = $CVV; 
        }

        public function setCuenta(string $cuenta)
        {
            $this->cuenta_ = $cuenta; 
        }
    }    
?>