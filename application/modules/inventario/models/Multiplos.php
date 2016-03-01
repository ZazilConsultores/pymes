<?php

class Inventario_Model_Multiplos
{
	private $idMultiplos;

    public function getIdMultiplos() {
        return $this->idMultiplos;
    }
    
    public function setIdMultiplos($idMultiplos) {
        $this->idMultiplos = $idMultiplos;
    }
	
	private $idProducto;

    public function getIdProducto() {
        return $this->idProducto;
    }
    
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }
	
	private $cantidad;

    public function getCantidad() {
        return $this->cantidad;
    }
    
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
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
	
	private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->setHash(Util_Secure::generateKey(array($this->unidad)));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

	public function __construct(array $datos) {
	    if(array_key_exists("idMultiplos", $datos)) $this->idMultiplos = $datos["idMultiplos"];
		if(array_key_exists("idProducto", $datos)) $this->idProducto = $datos["idProducto"];
		$this->cantidad = $datos["cantidad"];
		
		$this->unidad = $datos["unidad"];
		$this->abreviatura = $datos["abreviatura"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray() {
		$datos = array();
		
		$datos["idMultiplos"] = $this->idMultiplos;
		$datos["idProducto"] = $this->idProducto;
		$datos["cantidad"] = $this->cantidad;
		$datos["unidad"] = $this->unidad;
		$datos["abreviatura"] = $this->abreviatura;
		$datos["hash"] = $this->hash;	
		
		return $datos;
	}
	
}

