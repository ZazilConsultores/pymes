<?php

class Encuesta_Model_Grado
{
	private $idGrado;

    public function getIdGrado() {
        return $this->idGrado;
    }
    
    public function setIdGrado($idGrado) {
        $this->idGrado = $idGrado;
    }

    private $idNivel;

    public function getIdNivel() {
        return $this->idNivel;
    }
    
    public function setIdNivel($idNivel) {
        $this->idNivel = $idNivel;
    }

    private $grado;

    public function getGrado() {
        return $this->grado;
    }
    
    public function setGrado($grado) {
        $this->grado = $grado;
    }

    private $abreviatura;

    public function getAbreviatura() {
        return $this->abreviatura;
    }
    
    public function setAbreviatura($abreviatura) {
        $this->abreviatura = $abreviatura;
    }

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
	
	private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->hash = Util_Secure::generateKey(array("idNivel"=>$this->idNivel,"grado"=>strtolower($this->getGrado())));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos)
    {
        if(array_key_exists("idGrado", $datos)) $this->idGrado = $datos["idGrado"];
		if(array_key_exists("idNivel", $datos)) $this->idNivel = $datos["idNivel"];
		$this->grado = $datos["grado"];
		$this->abreviatura = $datos["abreviatura"];
		$this->descripcion = $datos["descripcion"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idGrado"] = $this->idGrado;
		$datos["idNivel"] = $this->idNivel;
		$datos["grado"] = $this->grado;
		$datos["abreviatura"] = $this->abreviatura;
		$datos["descripcion"] = $this->descripcion;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

