<?php

class Sistema_Model_Subparametro
{
	private $idSubparametro;

    public function getIdSubparametro() {
        return $this->idSubparametro;
    }
    
    public function setIdSubparametro($idSubparametro) {
        $this->idSubparametro = $idSubparametro;
    }

    private $idParametro;

    public function getIdParametro() {
        return $this->idParametro;
    }
    
    public function setIdParametro($idParametro) {
        $this->idParametro = $idParametro;
    }

    private $subparametro;

    public function getSubparametro() {
        return $this->subparametro;
    }
    
    public function setSubparametro($subparametro) {
        $this->subparametro = $subparametro;
    }

    private $claveSubparametro;

    public function getClaveSubparametro() {
        return $this->claveSubparametro;
    }
    
    public function setClaveSubparametro($claveSubparametro) {
        $this->claveSubparametro = $claveSubparametro;
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
    	if(is_null($this->hash)) $this->setHash(Util_Secure::generateKey(array($this->subparametro)));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }
	
	public function __construct(array $datos) {
        if(array_key_exists("idSubparametro", $datos)) $this->idSubparametro = $datos["idSubparametro"];
		if(array_key_exists("idParametro", $datos)) $this->idParametro = $datos["idParametro"];
		$this->subparametro = $datos["subparametro"];
		$this->claveSubparametro = $datos["claveSubparametro"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray() {
		$datos = array();
		
		$datos["idSubparametro"] = $this->idSubparametro;
		$datos["idParametro"] = $this->idParametro;
		$datos["subparametro"] = $this->subparametro;
		$datos["claveSubparametro"] = $this->claveSubparametro;
		$datos["fecha"] = $this->fecha;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
    
}
