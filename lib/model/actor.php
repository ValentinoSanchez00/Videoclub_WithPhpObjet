<?php


class Actor{
    private $id;
    private $nombre;
    private $apellido;
    private $fotografia;
    
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getFotografia() {
        return $this->fotografia;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido): void {
        $this->apellido = $apellido;
    }

    public function setFotografia($fotografia): void {
        $this->fotografia = $fotografia;
    }

    public function __construct($id, $nombre, $apellido, $fotografia) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->fotografia = $fotografia;
    }
    
    public function __destruct() {
       
    }


    
    
}