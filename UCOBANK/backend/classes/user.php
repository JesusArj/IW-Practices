<?php 
    class User
    {
        //properties
        protected string $name_;
        protected string $dni_; 
        protected int $sucursalNumber_;
        protected int $telefono_;
        protected string $correo_; 
        protected string $fechaNacimiento_; 
        protected string $password_;  


        public function __construct(string $name, string $dni, int $sucursalNumber, int $telefono, string $correo, string $fechaNacimiento, string $password)
        {
            $this->name_ = $name; 
            $this->dni_ = $dni; 
            $this->sucursalNumber_ = $sucursalNumber; 
            $this->telefono_ = $telefono; 
            $this->correo_ = $correo; 
            $this->fechaNacimiento_ = $fechaNacimiento; 
            $this->password_ = $password; 
            $this -> rol_ = $rol; 
        }

        public function getName()
        {
            return $this->name_; 
        }
        public function getDNI()
        {
            return $this->dni_;
        }
        public function getSucursalNumber()
        {
            return $this->sucursalNumber; 
        }
        public function getTelefono()
        {
            return $this->telefono_;
        }
        public function getCorreo()
        {
            return $this->correo_;
        }
        public function getPassword()
        {
            return $this->password_;
        }

        public function setName(string $name)
        {
            $this->name_= $name; 
        }
        public function setDNI(string $DNI)
        {
            $this->dni_= $DNI; 
        }
        public function setSucursalNumber(int $number)
        {
            $this->sucursalNumber_= $number; 
        }
        public function setTelefono(int $telefono)
        {
            $this->telefono_= $telefono; 
        }
        public function setCorreo(string $correo)
        {
            $this->correo_= $correo; 
        }
        public function setPassword(string $password)
        {
            $this->password_= $password; 
        }
    }

?>