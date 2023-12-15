<?php
class Usuario{
    private $id;
    private $name;
    private $password;
    private $rol;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function setRol($rol): void {
        $this->rol = $rol;
    }

    public function __construct($id, $name, $password, $rol) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->rol = $rol;
    }
    
    public function __destruct() {
       
    }  
    
}