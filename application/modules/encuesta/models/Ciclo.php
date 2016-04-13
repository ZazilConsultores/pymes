<?php

class Encuesta_Model_Ciclo
{
	private $idCiclo;

    public function getIdCiclo() {
        return $this->idCiclo;
    }
    
    public function setIdCiclo($idCiclo) {
        $this->idCiclo = $idCiclo;
    }
	
	private $idPlanE;

    public function getIdPlanE() {
        return $this->idPlanE;
    }
    
    public function setIdPlanE($idPlanE) {
        $this->idPlanE = $idPlanE;
    }
    
    private $ciclo;

    public function getCiclo() {
        return $this->ciclo;
    }
    
    public function setCiclo($ciclo) {
        $this->ciclo = $ciclo;
    }

    private $inicio;

    public function getInicio() {
        return $this->inicio;
    }
    
    public function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    private $termino;

    public function getTermino() {
        return $this->termino;
    }
    
    public function setTermino($termino) {
        $this->termino = $termino;
    }
	
	private $actual;

    public function getActual() {
        return $this->actual;
    }
    
    public function setActual($actual) {
        $this->actual = $actual;
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
    	if(is_null($this->hash)) $this->hash = Util_Secure::generateKey(array("ciclo"=>strtoupper($this->ciclo)));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos)
	{
		if(array_key_exists("idCiclo", $datos)) $this->idCiclo = $datos["idCiclo"];
		if(array_key_exists("idPlanE", $datos)) $this->idPlanE = $datos["idPlanE"];
		$this->ciclo = $datos["ciclo"];
		$this->inicio = $datos["inicio"];
		$this->termino = $datos["termino"];
		$this->actual = $datos["actual"];
		$this->descripcion = $datos["descripcion"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idCiclo"] = $this->idCiclo;
		$datos["idPlanE"] = $this->idPlanE;
		$datos["ciclo"] = $this->ciclo;
		$datos["inicio"] = $this->inicio;
		$datos["termino"] = $this->termino;
		$datos["actual"] = $this->actual;
		$datos["descripcion"] = $this->descripcion;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

