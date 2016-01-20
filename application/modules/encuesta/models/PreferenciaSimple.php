<?php

class Encuesta_Model_PreferenciaSimple {

	private $idPregunta;

    public function getIdPregunta() {
        return $this->idPregunta;
    }
    
    public function setIdPregunta($idPregunta) {
        $this->idPregunta = $idPregunta;
    }

    private $idOpcion;

    public function getIdOpcion() {
        return $this->idOpcion;
    }
    
    public function setIdOpcion($idOpcion) {
        $this->idOpcion = $idOpcion;
    }

    private $preferencia;

    public function getPreferencia() {
        return $this->preferencia;
    }
    
    public function setPreferencia($preferencia) {
        $this->preferencia = $preferencia;
    }

    public function __construct(array $datos)
    {
        if(array_key_exists("idPregunta", $datos)) $this->idPregunta = $datos["idPregunta"];
		if(array_key_exists("idOpcion", $datos)) $this->idOpcion = $datos["idOpcion"];
		if(array_key_exists("preferencia", $datos)) $this->preferencia = $datos["preferencia"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idPregunta"] = $this->idPregunta;
		$datos["idOpcion"] = $this->idOpcion;
		$datos["preferencia"] = $this->preferencia;
		
		return $datos;
	}
}

