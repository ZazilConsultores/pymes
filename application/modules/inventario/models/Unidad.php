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
	
	private $idMultiplos;

    public function getIdMultiplos() {
        return $this->idMultiplos;
    }
    
    public function setIdMultiplos($idMultiplos) {
        $this->idMultiplos = $idMultiplos;
    }
	
	private $unidad;

    public function getUnidad() {
        return $this->unidad;
    }
    
    public function setUnidad($unidad) {
        $this->unidad = $unidad;
    }
	
	private $abrevitura;

    public function getAbrevitura() {
        return $this->abrevitura;
    }
    
    public function setAbrevitura($abrevitura) {
        $this->abrevitura = $abrevitura;
    }

	
	public function __construct(array $datos)
	{
		if (array_key_exists("idUnidad", $datos)) $this->idUnidad = $datos["idUnidad"];
		if (array_key_exists("idMultiplos", $datos)) $this->idMultiplos = $datos["idMultiplos"];
		$this->unidad = $datos["unidad"];
		$this->abrevitura = $datos["abreviatura"];
	}
	public function toArray()
	{
		$datos = Array();
		
		$datos["idUnidad"] = $this->idUnidad;
		$datos["idMultiplos"] = $this->idMultiplos;
		$datos["unidad"] = $this->unidad;
		$datos["abreviatura"] = $this->abrevitura;
		
		return $datos;
		
		 
	}

    

    

    

    

}

