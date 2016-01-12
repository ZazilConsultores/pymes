<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Pregunta
{
	private $idPregunta;

    public function getIdPregunta() {
        return $this->idPregunta;
    }
    
    public function setIdPregunta($idPregunta) {
        $this->idPregunta = $idPregunta;
    }

    private $pregunta;

    public function getPregunta() {
        return $this->pregunta;
    }
    
    public function setPregunta($pregunta) {
        $this->pregunta = $pregunta;
    }

    private $origen;

    public function getOrigen() {
        return $this->origen;
    }
    
    public function setOrigen($origen) {
        $this->origen = $origen;
    }

    private $idOrigen;

    public function getIdOrigen() {
        return $this->idOrigen;
    }
    
    public function setIdOrigen($idOrigen) {
        $this->idOrigen = $idOrigen;
    }

    private $tipo;

    public function getTipo() {
        return $this->tipo;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    private $orden;

    public function getOrden() {
        return $this->orden;
    }
    
    public function setOrden($orden) {
        $this->orden = $orden;
    }

    public function __construct(array $datos) {
    	//$this->idPregunta = $datos["idPregunta"];
		$this->pregunta = $datos["pregunta"];
		$this->origen = $datos["origen"];
		$this->idOrigen = $datos["idOrigen"];
		$this->tipo = $datos["tipo"];
		$this->orden = $datos["orden"];
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idPregunta"] = $this->idPregunta;
		$datos["pregunta"] = $this->pregunta;
		$datos["origen"] = $this->origen;
		$datos["idOrigen"] = $this->idOrigen;
		$datos["tipo"] = $this->tipo;
		$datos["orden"] = $this->orden;
		
		return $datos;
	}
}

