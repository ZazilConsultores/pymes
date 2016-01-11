<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Multiplos
{
	private $idMultiplos;

    public function getIdMultiplos() {
        return $this->idMultiplos;
    }
    
    public function setIdMultiplos($idMultiplos) {
        $this->idMultiplos = $idMultiplos;
    }
		
	/*private $idProducto;

    public function getIdProducto() {
        return $this->idProducto;
    }
    
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }*/
    
    private $idCantidad;

    public function getIdCantidad() {
        return $this->idCantidad;
    }
    
    public function setIdCantidad($idCantidad) {
        $this->idCantidad = $idCantidad;
    }

	private $idUnidad;

    public function getIdUnidad() {
        return $this->idUnidad;
    }
    
    public function setIdUnidad($idUnidad) {
        $this->idUnidad = $idUnidad;
    }

	private $idAbreviatura;

    public function getIdAbreviatura() {
        return $this->idAbreviatura;
    }
    
    public function setIdAbreviatura($idAbreviatura) {
        $this->idAbreviatura = $idAbreviatura;
    }
	
	public function __construct(array $datos)
    {
        $this->producto = $datos["producto"];
		$this->cantidad = $datos["cantidad"];
		$this->unidad = $datos["unidad"];
		$this->abreviatura = $datos["abreviatura"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idMultiplos"] = $this->idMultiplos;
		$datos["producto"] = $this->producto; 
		$datos["cantidad"] = $this->cantidad;
		$datos["unidad"] = $this->unidad;
		$datos["abrevitura"] = $this->abrevitura;
		
		return $datos;
	}
	



}

