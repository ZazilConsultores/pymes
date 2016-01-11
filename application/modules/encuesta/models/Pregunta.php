<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Pregunta
{
	private $idPregunta;

    function getIdPregunta() {
        return $this->idPregunta;
    }
    
    function setIdPregunta($idPregunta) {
        $this->idPregunta = $idPregunta;
    }
    
	private $nombre;

    function getNombre() {
        return $this->nombre;
    }
    
    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
	
	private $tipo;

    function getTipo() {
        return $this->tipo;
    }
    
    function setTipo($tipo) {
        $this->tipo = $tipo;
    }
	
	private $orden;

    function getOrden() {
        return $this->orden;
    }
    
    function setOrden($orden) {
        $this->orden = $orden;
    }
		
    function __construct(array $datos) {
		$this->nombre = $datos["nombre"];
		if(array_key_exists("idPregunta", $datos)){
			$this->idPregunta = $datos["idPregunta"];
		}else{
			$this->idPregunta = hash("adler32", $datos["nombre"]);
		}
		//$this->idPregunta = hash("adler32", $datos["pregunta"]);
		//if(array_key_exists("origen", $datos)) $this->origen = $datos["origen"];
		if(array_key_exists("orden", $datos)) $this->orden = $datos["orden"];
		if(array_key_exists("tipo", $datos)){
			$this->tipo = $datos["tipo"];
		}else{
			$this->tipo = "AB";
		}
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idPregunta"] = $this->idPregunta;
		$datos["nombre"] = $this->nombre;
		$datos["orden"] = $this->orden;
		$datos["tipo"] = $this->tipo;
		
		return $datos;
	}
}

