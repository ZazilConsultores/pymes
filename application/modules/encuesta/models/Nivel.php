<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Nivel
{
	private $idNivel;

    public function getIdNivel() {
        return $this->idNivel;
    }
    
    public function setIdNivel($idNivel) {
        $this->idNivel = $idNivel;
    }

    private $nivel;

    public function getNivel() {
        return $this->nivel;
    }
    
    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
	
    public function __construct(array $datos)
    {
		if(array_key_exists("idNivel", $datos)) $this->idNivel = $datos["idNivel"];
		$this->nivel = $datos["nivel"];
		$this->descripcion = $datos["descripcion"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idNivel"] = $this->idNivel;
		$datos["nivel"] = $this->nivel;
		$datos["descripcion"] = $this->descripcion;
		
		return $datos;
	}

}

