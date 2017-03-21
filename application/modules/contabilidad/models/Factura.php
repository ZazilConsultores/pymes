<?php

class Contabilidad_Model_Factura
{
	private $idFactura;

    public function getIdFactura() {
        return $this->idFactura;
    }
    
    public function setIdFactura($idFactura) {
        $this->idFactura = $idFactura;
    }

    private $idTipoMovimiento;

    public function getIdTipoMovimiento() {
        return $this->idTipoMovimiento;
    }
    
    public function setIdTipoMovimiento($idTipoMovimiento) {
        $this->idTipoMovimiento = $idTipoMovimiento;
    }

    private $idSucursal;

    public function getIdSucursal() {
        return $this->idSucursal;
    }
    
    public function setIdSucursal($idSucursal) {
        $this->idSucursal = $idSucursal;
    }
	
	private $idCoP;

    public function getIdCoP() {
        return $this->idCoP;
    }
    
    public function setIdCoP($idCoP) {
        $this->idCoP = $idCoP;
    }
	
	private $idDivisa;

    public function getIdDivisa() {
        return $this->idDivisa;
    }
    
    public function setIdDivisa($idDivisa) {
        $this->idDivisa = $idDivisa;
    }

    /**/
    private $numeroFactura;

    public function getNumeroFactura() {
        return $this->numeroFactura;
    }
    
    public function setNumeroFactura($numeroFactura) {
        $this->numeroFactura = $numeroFactura;
    }

    private $estatus;

    public function getEstatus() {
        return $this->estatus;
    }
    
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }
	
	private $descuento;

    public function getDescuento() {
        return $this->descuento;
    }
    
    public function setDescuento($descuento) {
        $this->descuento = $descuento;
    }
	

	private $conceptoPago;

    public function getConceptoPago() {
        return $this->conceptoPago;
    }
    
    public function setConceptoPago($conceptoPago) {
        $this->conceptoPago = $conceptoPago;
    }
   
 	private $formaPago;

    public function getFormaPago() {
        return $this->formaPago;
    }
    
    public function setFormaPago($formaPago) {
        $this->formaPago = $formaPago;
    }
	
	private $fechaFactura;

    public function getFechaFactura() {
        return $this->fechaFactura;
    }
    
    public function setFechaFactura($fechaFactura) {
        $this->fechaFactura = $fechaFactura;
    }
	
	/*private $fechaCancelada;

    public function getFechaCancelada() {
        return $this->fechaCancelada;
    }
    
    public function setFechaCancelada($fechaCancelada) {
        $this->fechaCancelada = $fechaCancelada;
    }*/

 
	private $subtotal;

    public function getSubtotal() {
        return $this->subtotal;
    }
    
    public function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    private $total;

    public function getTotal() {
        return $this->total;
    }
    
    public function setTotal($total) {
        $this->total = $total;
    }
    public function __construct(array $datos){
    	if (array_key_exists("idFactura", $datos)) $this->idFactura = $datos["idFactura"];
		if (array_key_exists("idTipoMovimiento", $datos)) $this->idTipoMovimiento = $datos["idTipoMovimiento"];
		if (array_key_exists("idSucursal", $datos)) $this->idSucursal = $datos["idSucursal"];
    	if (array_key_exists("idCoP", $datos)) $this->idCoP = $datos["idCoP"];
		if (array_key_exists("idDivisa", $datos)) $this->idDivisa = $datos["idDivisa"];
		$this->numeroFactura = $datos["numeroFactura"];
		$this->estatus = $datos["estatus"];
		$this->descuento = $datos["descuento"];
		$this->conceptoPago = $datos["conceptoPago"];
		$this->formaPago = $datos["formaPago"];
		$this->fechaFactura = $datos["fechaFactura"];
		//$this->fechaCancelada = $datos["fechaCancelada"];
		$this->subtotal = $datos["subtotal"];
		$this->total = $datos["total"];

	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idFactura"] = $this->idFactura;
		$datos["idTipoMovimiento"] = $this->idTipoMovimiento;
		$datos["idSucursal"] = $this->idSucursal;
		$datos["idCoP"] = $this->idCoP;
		$datos["idDivisa"] = $this->idDivisa;
		$datos["numeroFactura"] = $this->numeroFactura;
		$datos["estatus"] = $this->estatus;
		$datos["descuento"]=$this->descuento;
		$datos["conceptoPago"] = $this->conceptoPago;
		$datos["formaPago"] = $this->formaPago;
		$datos["fechaFactura"]=$this->fechaFactura;
		//$datos["fechaCancelada"]= $this->fechaCancelada;
		$datos["subTotal"] = $this->subtotal;
		$datos["total"] = $this->total;
		return $datos;		
		
	}

    
}

