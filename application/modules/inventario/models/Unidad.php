<?php

class Inventario_Model_Unidad
{
	private $idUnidad;

    public function getIdUnidad() {
        return $this->idUnidad;
    }
    
    public function setIdUnidad($idUnidad) {
        $this->idUnidad = $idUnidad;
    }
	
	private $unidad;

    public function getUnidad() {
        return $this->unidad;
    }
    
    public function setUnidad($unidad) {
        $this->unidad = $unidad;
    }
	
	private $abreviatura;

    public function getAbreviatura() {
        return $this->abreviatura;
    }
    
    public function setAbreviatura($abreviatura) {
        $this->abreviatura = $abreviatura;
    }

	/*private $hash;
	
	public function getHash() {
    	if(is_null($this->hash)) $this->setHash(Util_Secure::generateKey(array(strtolower($this->unidad))));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }*/
    
	
	public function __construct(array $datos)
	{
		if (array_key_exists("idUnidad", $datos)) $this->idUnidad = $datos["idUnidad"];
		$this->unidad = $datos["unidad"];
		$this->abreviatura = $datos["abreviatura"];
		//if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
	}
	public function toArray()
	{
		$datos = Array();
		
		$datos["idUnidad"] = $this->idUnidad;
		$datos["unidad"] = $this->unidad;
		$datos["abreviatura"] = $this->abreviatura;
		//$datos["hash"] = $this->hash;
		
		return $datos;
		
		 
	}

    

    

    

    

}

