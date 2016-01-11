<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_FacturaDetalle
{
	private $idFacturaDetalle;

    public function getIdFacturaDetalle() {
        return $this->idFacturaDetalle;
    }
    
    public function setIdFacturaDetalle($idFacturaDetalle) {
        $this->idFacturaDetalle = $idFacturaDetalle;
    }

    private $idFactura;

    public function getIdFactura() {
        return $this->idFactura;
    }
    
    public function setIdFactura($idFactura) {
        $this->idFactura = $idFactura;
    }

    private $idMultiplos;

    public function getIdMultiplos() {
        return $this->idMultiplos;
    }
    
    public function setIdMultiplos($idMultiplos) {
        $this->idMultiplos = $idMultiplos;
    }

    private $secuencial;

    public function getSecuencial() {
        return $this->secuencial;
    }
    
    public function setSecuencial($secuencial) {
        $this->secuencial = $secuencial;
    }

	private $cantidad;

    public function getCantidad() {
        return $this->cantidad;
    }
    
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    private $precioUnitario;

    public function getPrecioUnitario() {
        return $this->precioUnitario;
    }
    
    public function setPrecioUnitario($precioUnitario) {
        $this->precioUnitario = $precioUnitario;
    }

    private $importe;

    public function getImporte() {
        return $this->importe;
    }
    
    public function setImporte($importe) {
        $this->importe = $importe;
    }

    public function __construct(array $datos)
    {
        $this->idFactura = $datos["idFactura"];
		$this->idMultiplos = $datos["idMultiplos"];
		$this->secuencial = $datos["secuencial"];
		$this->cantidad = $datos["cantidad"];
		$this->descripcion = $datos["descripcion"];
		$this->precioUnitario = $datos["precioUnitario"];
		$this->importe = $datos["importe"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idFacturaDetalle"] = $this->idFacturaDetalle;
		$datos["idFactura"] = $this->idFactura;
		$datos["idMultiplos"] = $this->idMultiplos;
		$datos["secuencial"] = $this->secuencial;
		$datos["cantidad"] = $this->cantidad;
		$datos["descripcion"] = $this->descripcion;
		$datos["precioUnitario"] = $this->precioUnitario;
		$datos["importe"] = $this->importe;
		
		return $datos;
	}

}

