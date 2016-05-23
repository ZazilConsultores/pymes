<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Respuesta
{
	private $idRespuesta;

    public function getIdRespuesta() {
        return $this->idRespuesta;
    }
    
    public function setIdRespuesta($idRespuesta) {
        $this->idRespuesta = $idRespuesta;
    }
	
	private $idEncuesta;

    public function getIdEncuesta() {
        return $this->idEncuesta;
    }
	
	private $idAsignacion;

    public function getIdAsignacion() {
        return $this->idAsignacion;
    }
    
    public function setIdAsignacion($idAsignacion) {
        $this->idAsignacion = $idAsignacion;
    }
    
    public function setIdEncuesta($idEncuesta) {
        $this->idEncuesta = $idEncuesta;
    }
	/*
	private $idRegistro;

    public function getIdRegistro() {
        return $this->idRegistro;
    }
    
    public function setIdRegistro($idRegistro) {
        $this->idRegistro = $idRegistro;
    }*/
	/*
	private $idGrupo;

    public function getIdGrupo() {
        return $this->idGrupo;
    }
    
    public function setIdGrupo($idGrupo) {
        $this->idGrupo = $idGrupo;
    }
    */
    private $idPregunta;

    public function getIdPregunta() {
        return $this->idPregunta;
    }
    
    public function setIdPregunta($idPregunta) {
        $this->idPregunta = $idPregunta;
    }
	
	private $conjunto;

    public function getConjunto() {
        return $this->conjunto;
    }
    
    public function setConjunto($conjunto) {
        $this->conjunto = $conjunto;
    }
    
    private $respuesta;

    public function getRespuesta() {
        return $this->respuesta;
    }
    
    public function setRespuesta($respuesta) {
        $this->respuesta = $respuesta;
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
    	if(is_null($this->hash)) $this->setHash(Util_Secure::generateKey($this->toArray()));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos)
    {
    	if(array_key_exists("idRespuesta", $datos)) $this->idRespuesta = $datos["idRespuesta"];
    	if(array_key_exists("idEncuesta", $datos)) $this->idEncuesta = $datos["idEncuesta"];
		if(array_key_exists("idAsignacion", $datos)) $this->idAsignacion = $datos["idAsignacion"];
        //if(array_key_exists("idRegistro", $datos)) $this->idRegistro = $datos["idRegistro"];
    	//if(array_key_exists("idGrupo", $datos)) $this->idGrupo = $datos["idGrupo"];
    	if(array_key_exists("idPregunta", $datos)) $this->idPregunta = $datos["idPregunta"];
		if(array_key_exists("conjunto", $datos)) $this->conjunto = $datos["conjunto"];
		$this->respuesta = $datos["respuesta"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idRespuesta"] = $this->idRespuesta;
		$datos["idEncuesta"] = $this->idEncuesta;
		$datos["idAsignacion"] = $this->idAsignacion;
		//$datos["idRegistro"] = $this->idRegistro;
		//$datos["idGrupo"] = $this->idGrupo;
		$datos["idPregunta"] = $this->idPregunta;
		$datos["conjunto"] = $this->conjunto;
		$datos["respuesta"] = $this->respuesta;
		$datos["fecha"] = $this->fecha;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

