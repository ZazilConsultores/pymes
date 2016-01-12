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

    public function __construct(array $datos)
    {
    	//$this->idRespuesta = $datos["idRespuesta"];
        //$this->idPregunta = $datos["idPregunta"];
		$this->respuesta = $datos["respuesta"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idRespuesta"] = $this->idRespuesta;
		$datos["idPregunta"] = $this->idPregunta;
		$datos["respuesta"] = $this->respuesta;
		
		return $datos;
	}
}

