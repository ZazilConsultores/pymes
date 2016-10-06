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
	
	private $fecha;
	
	public function getFecha() {
		return $this->fecha;
	}
	
	public function setFecha($fecha) {
		$this->fecha = $fecha;
	}

    public function __construct(array $datos)
	{
		if(array_key_exists("idCicloEscolar", $datos)) $this->idCiclo = $datos["idCicloEscolar"];
		if(array_key_exists("idPlanEducativo", $datos)) $this->idPlanE = $datos["idPlanEducativo"];
		$this->ciclo = $datos["ciclo"];
		$this->inicio = $datos["inicio"];
		$this->termino = $datos["termino"];
		$this->actual = $datos["vigente"];
		$this->descripcion = $datos["descripcion"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idCicloEscolar"] = $this->idCiclo;
		$datos["idPlanEducativo"] = $this->idPlanE;
		$datos["ciclo"] = $this->ciclo;
		$datos["vigente"] = $this->actual;
		$datos["inicio"] = $this->inicio;
		$datos["termino"] = $this->termino;
		$datos["descripcion"] = $this->descripcion;
		$datos["fecha"] = $this->fecha;
		
		return $datos;
	}
}

