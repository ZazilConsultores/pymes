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

    private $ciclo;

    public function getCiclo() {
        return $this->ciclo;
    }
    
    public function setCiclo($ciclo) {
        $this->ciclo = $ciclo;
    }

    private $anotaciones;

    public function getAnotaciones() {
        return $this->anotaciones;
    }
    
    public function setAnotaciones($anotaciones) {
        $this->anotaciones = $anotaciones;
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
		$this->ciclo = $datos["ciclo"];
		$this->anotaciones = $datos["anotaciones"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idCiclo"] = $this->idCiclo;
		$datos["ciclo"] = $this->ciclo;
		$datos["anotaciones"] = $this->anotaciones;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

