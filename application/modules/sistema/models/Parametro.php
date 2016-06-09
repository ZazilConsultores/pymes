<?php

class Sistema_Model_Parametro
{
	private $idParametro;

    public function getIdParametro() {
        return $this->idParametro;
    }
    
    public function setIdParametro($idParametro) {
        $this->idParametro = $idParametro;
    }

    private $parametro;

    public function getParametro() {
        return $this->parametro;
    }
    
    public function setParametro($parametro) {
        $this->parametro = $parametro;
    }

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
	
	private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
	}

    public function __construct(array $datos) {
        if(array_key_exists("idParametro", $datos)) $this->idParametro = $datos["idParametro"];
		$this->parametro = $datos["parametro"];
		$this->descripcion = $datos["descripcion"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
    }
	
	public function toArray() {
		$datos = array();
		
		$datos["idParametro"] = $this->idParametro;
		$datos["parametro"] = $this->parametro;
		$datos["descripcion"] = $this->descripcion;
		$datos["fecha"] = $this->fecha;
		
		return $datos;
	}

}

