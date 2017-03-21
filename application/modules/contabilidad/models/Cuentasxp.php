<?php

class Contabilidad_Model_Cuentasxp
{
	private $idCuestasxp;

    public function getIdCuestasxp() {
        return $this->idCuestasxp;
    }
    
    public function setIdCuestasxp($idCuestasxp) {
        $this->idCuestasxp = $idCuestasxp;
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
	
	private $idFactura;

    public function getIdFactura() {
        return $this->idFactura;
    }
    
    public function setIdFactura($idFactura) {
        $this->idFactura = $idFactura;
    }

    private $idCoP;

    public function getIdCoP() {
        return $this->idCoP;
    }
    
    public function setIdCoP($idCoP) {
        $this->idCoP = $idCoP;
    }
	
	private $idBanco;

    public function getIdBanco() {
        return $this->idBanco;
    }
    
    public function setIdBanco($idBanco) {
        $this->idBanco = $idBanco;
    }
	
	private $idDivisa;

    public function getIdDivisa() {
        return $this->idDivisa;
    }
    
    public function setIdDivisa($idDivisa) {
        $this->idDivisa = $idDivisa;
    }

	private $numeroFolio;

    public function getNumeroFolio() {
        return $this->numeroFolio;
    }
    
    public function setNumeroFolio($numeroFolio) {
        $this->numeroFolio = $numeroFolio;
    }

    private $secuencial;

    public function getSecuencial() {
        return $this->secuencial;
    }
    
    public function setSecuencial($secuencial) {
        $this->secuencial = $secuencial;
    }
	
	private $fechaCaptura;

    public function getFechaCaptura() {
        return $this->fechaCaptura;
    }
    
    public function setFechaCaptura($fechaCaptura) {
        $this->fechaCaptura = $fechaCaptura;
    }

	private $fechaPago;

    public function getFechaPago() {
        return $this->fechaPago;
    }
    
    public function setFechaPago($fechaPago) {
        $this->fechaPago = $fechaPago;
    }

   	private $estatus;

    public function getEstatus() {
        return $this->estatus;
    }
    
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }
	
	private $numeroReferencia;

    public function getNumeroReferencia() {
        return $this->numeroReferencia;
    }
    
    public function setNumeroReferencia($numeroReferencia) {
        $this->numeroReferencia = $numeroReferencia;
    }
	
	private $conceptoPago;

    public function getConceptoPago() {
        return $this->conceptoPago;
    }
    
    public function setConceptoPago($conceptoPago) {
        $this->conceptoPago = $conceptoPago;
    }

	private $formaLiquidar;

    public function getFormaLiquidar() {
        return $this->formaLiquidar;
    }
    
    public function setFormaLiquidar($formaLiquidar) {
        $this->formaLiquidar = $formaLiquidar;
    }
	
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
	
//*********************************
		
	public function __construct(array $datos)
	{
		if(array_key_exists("idCuentasxp", $datos)) $this->idCuentasxp = $datos["idCuentasxp"];
		if(array_key_exists("idTipoMovimiento", $datos)) $this->idTipoMovimiento = $datos["idTipoMovimiento"];
		if(array_key_exists("idSucursal", $datos)) $this->idSucursal =$datos["idSucursal"];
		if(array_key_exists("idFactura", $datos)) $this->idFactura =$datos["idFactura"];
		if(array_key_exists("idCoP", $datos)) $this->idCoP =$datos["idCoP"];
		$this->idBanco =$datos["idBanco"];
		if(array_key_exists("idDivisa", $datos)) $this->idDivisa = $datos["idDivisa"];
		$this->numeroFolio =$datos["numeroFolio"];
		$this->secuencial = $datos["secuencial"];
		$this->fechaCaptura =$datos["fechaCaptura"];
		$this->fechaPago =$datos["fechaPago"];
		$this->estatus =$datos["estatus"];
		$this->numeroReferencia =$datos["numeroReferencia"];
		$this->conceptoPago =$datos["conceptoPago"];
		$this->formaLiquidar =$datos["formaLiquidar"];
		$this->subtotal =$datos["subTotal"];
		$this->total =$datos["total"];
		
	}

    public function toArray()
    {
        $datos = array();
		
		$datos["idCuentasxp"] = $this->idCuestasxp;
		$datos["idTipoMovimiento"] = $this->idTipoMovimiento;
		$datos["idSucursal"] = $this->idSucursal;
		$datos["idFactura"] = $this->idFactura;
		$datos["idCoP"] = $this->idCoP;
		$datos["idBanco"] = $this->idBanco;
		$datos["idDivisa"] = $this->idDivisa;
		$datos["numeroFolio"] = $this->numeroFolio;
		$datos["secuencial"] = $this->secuencial;
		$datos["fechaCaptura"] = $this->fechaCaptura;
		$datos["fechaPago"] = $this->fechaPago;
		$datos["estatus"] = $this->estatus;
		$datos["numeroReferencia"] = $this->numeroReferencia;
		$datos["conceptoPago"] = $this->conceptoPago;
		$datos["formaLiquidar"] = $this->formaLiquidar;
		$datos["subTotal"] = $this->subtotal;
		$datos["total"] = $this->total;
		
		return $datos;
    }

}

