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
	
	
	private $idUnidad;

    public function getIdUnidad() {
        return $this->idUnidad;
    }
    
    public function setIdUnidad($idUnidad) {
        $this->idUnidad = $idUnidad;
    }

	private $cantidad;

    public function getCantidad() {
        return $this->cantidad;
    }
    
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

	public function __construct(array $datos) {
	   	
	    if(array_key_exists("idMultiplos", $datos)) $this->idMultiplos = $datos["idMultiplos"];
		if(array_key_exists("idProducto", $datos)) $this->idProducto = $datos["idProducto"];
		if(array_key_exists("idUnidad", $datos)) $this->idUnidad = $datos["idUnidad"];
		
		$this->cantidad = $datos["cantidad"];
	
    }
	
	public function toArray() {
		$datos = array();
		$datos["idMultiplos"] = $this->idMultiplos;
		$datos["idProducto"] = $this->idProducto;
		$datos["idUnidad"] = $this->idUnidad;
		$datos["cantidad"] = $this->cantidad;
		
		return $datos;
	}
	
}

