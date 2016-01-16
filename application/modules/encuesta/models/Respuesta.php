<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Respuesta
{
	private $idRegistro;

    public function getIdRegistro() {
        return $this->idRegistro;
    }
    
    public function setIdRegistro($idRegistro) {
        $this->idRegistro = $idRegistro;
    }

    private $idEncuesta;

    public function getIdEncuesta() {
        return $this->idEncuesta;
    }
    
    public function setIdEncuesta($idEncuesta) {
        $this->idEncuesta = $idEncuesta;
    }

    private $idRespuesta;

    public function getIdRespuesta() {
        return $this->idRespuesta;
    }
    
    public function setIdRespuesta($idRespuesta) {
        $this->idRespuesta = $idRespuesta;
    }

    private $idPregunta;

    public function getIdPregunta() {
        return $this->idPregunta;
    }
    
    public function setIdPregunta($idPregunta) {
        $this->idPregunta = $idPregunta;
    }

    private $respuesta;

    public function getRespuesta() {
        return $this->respuesta;
    }
    
    public function setRespuesta($respuesta) {
        $this->respuesta = $respuesta;
    }
	
	private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->setHash(Util_Secure::generateKey($this->toArray()));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos)
    {
    	if(array_key_exists("idRegistro", $datos)) $this->idRegistro = $datos["idRegistro"];
		if(array_key_exists("idEncuesta", $datos)) $this->idEncuesta = $datos["idEncuesta"];
        if(array_key_exists("idRespuesta", $datos)) $this->idRespuesta = $datos["idRespuesta"];
        if(array_key_exists("idPregunta", $datos)) $this->idPregunta = $datos["idPregunta"];
		$this->respuesta = $datos["respuesta"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idRegistro"] = $this->idRegistro;
		$datos["idEncuesta"] = $this->idEncuesta;
		$datos["idRespuesta"] = $this->idRespuesta;
		$datos["idPregunta"] = $this->idPregunta;
		$datos["respuesta"] = $this->respuesta;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

