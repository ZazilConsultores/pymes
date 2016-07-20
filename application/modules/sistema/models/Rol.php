<?php

class Sistema_Model_Rol
{
	private $idRol;

    public function getIdRol() {
        return $this->idRol;
    }
    
    public function setIdRol($idRol) {
        $this->idRol = $idRol;
    }

    private $rol;

    public function getRol() {
        return $this->rol;
    }
    
    public function setRol($rol) {
        $this->rol = $rol;
    }
	
	private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
	/*
    private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->setHash(Util_Secure::generateKey(array($this->toArray())));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }*/

    public function __construct(array $datos) {
		if(array_key_exists("idRol", $datos)) $this->idRol = $datos["idRol"];
		$this->rol = $datos["rol"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
		//if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
	}
	
	public function toArray() {
		
		$datos = array();
		
		$datos["idRol"] = $this->idRol;
		$datos["rol"] = $this->rol;
		$datos["fecha"] = $this->fecha;
		//$datos["hash"] = $this->hash;
		
		return $datos;
	}

}
















