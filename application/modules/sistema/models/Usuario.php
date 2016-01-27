<?php

class Sistema_Model_Usuario
{
	private $idUsuario;

    public function getIdUsuario() {
        return $this->idUsuario;
    }
    
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    private $idRol;

    public function getIdRol() {
        return $this->idRol;
    }
    
    public function setIdRol($idRol) {
        $this->idRol = $idRol;
    }

    private $usuario;

    public function getUsuario() {
        return $this->usuario;
    }
    
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
	
	private $nombres;

    function getNombres() {
        return $this->nombres;
    }
    
    function setNombres($nombres) {
        $this->nombres = $nombres;
    }
    
    private $apellidos;

    function getApellidos() {
        return $this->apellidos;
    }
    
    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }
    
    private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->setHash(Util_Secure::generateKey(array($this->toArray())));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos) {
        if(array_key_exists("idUsuario", $datos)) $this->idUsuario = $datos["idUsuario"];
		if(array_key_exists("idRol", $datos)) $this->idRol = $datos["idRol"];
		$this->usuario = $datos["usuario"];
		$this->nombres = $datos["nombres"];
		$this->apellidos = $datos["apellidos"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray() {
		$datos = array();
		
		$datos["idUsuario"] = $this->idUsuario;
		$datos["idRol"] = $this->idRol;
		$datos["usuario"] = $this->usuario;
		$datos["nombres"] = $this->nombres;
		$datos["apellidos"] = $this->apellidos;
		$datos["fecha"] = $this->fecha;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

