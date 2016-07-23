<?php

class Contabilidad_Model_Cuentasxc
{
	private $idCuestasxc;

    public function getIdCuestasxc() {
        return $this->idCuestasxc;
    }
    
    public function setIdCuestasxc($idCuestasxc) {
        $this->idCuestasxc = $idCuestasxc;
    }

    private $idTipoMovimiento;

    public function getIdTipoMovimiento() {
        return $this->idTipoMovimiento;
    }
    
    public function setIdTipoMovimiento($idTipoMovimiento) {
        $this->idTipoMovimiento = $idTipoMovimiento;
    }

    private $numeroReferencia;

    public function getNumeroReferencia() {
        return $this->numeroReferencia;
    }
    
    public function setNumeroReferencia($numeroReferencia) {
        $this->numeroReferencia = $numeroReferencia;
    }

    private $secuencial;

    public function getSecuencial() {
        return $this->secuencial;
    }
    
    public function setSecuencial($secuencial) {
        $this->secuencial = $secuencial;
    }

    private $idEmpresa;

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
    
    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    private $idCoP;

    public function getIdCoP() {
        return $this->idCoP;
    }
    
    public function setIdCoP($idCoP) {
        $this->idCoP = $idCoP;
    }

    private $numFolio;

    public function getNumFolio() {
        return $this->numFolio;
    }
    
    public function setNumFolio($numFolio) {
        $this->numFolio = $numFolio;
    }

    

    private $idProyecto;

    public function getIdProyecto() {
        return $this->idProyecto;
    }
    
    public function setIdProyecto($idProyecto) {
        $this->idProyecto = $idProyecto;
    }

   	private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

	private $estatus;

    public function getEstatus() {
        return $this->estatus;
    }
    
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
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

    private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    private $fechaCaptura;

    public function getFechaCaptura() {
        return $this->fechaCaptura;
    }
    
    public function setFechaCaptura($fechaCaptura) {
        $this->fechaCaptura = $fechaCaptura;
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
	
	public function __construct(array $datos)
	{
		if(array_key_exists("idCuentasxc", $datos)) $this->idCuentasxc = $datos["idCuentasxc"];
		if(array_key_exists("idTipoMovimiento", $datos)) $this->tipoMovimiento = $datos["tipoMovimiento"];
		if(array_key_exists("numeroReferencia", $datos)) $this->numeroReferencia =$datos["numeroReferencia"];
		if(array_key_exists("secuencial", $datos)) $this->secuencial =$datos["secuencial"];
		if(array_key_exists("idEmpresa", $datos)) $this->idEmpresa =$datos["idEmpresa"];
		if(array_key_exists("idCoP", $datos)) $this->idCoP =$datos["idCoP"];
		if(array_key_exists("numFolio", $datos)) $this->numFolio =$datos["numFolio"];
		if(array_key_exists("idProyecto", $datos)) $this->idProyecto = $datos["idProyecto"];
		if(array_key_exists("descripcion", $datos)) $this->descripcion =$datos["descripcion"];
		if(array_key_exists("estatus", $datos)) $this->estatus =$datos["estatus"];
		if(array_key_exists("conceptoPago", $datos)) $this->conceptoPago =$datos["conceptoPago"];
		if(array_key_exists("formaLiquidar", $datos)) $this->formaLiquidar = $datos["formaLiquidar"];
		if(array_key_exists("fecha", $datos)) $this->fecha =$datos["fecha"];
		if(array_key_exists("fechaCaptura", $datos)) $this->fechaCaptura =$datos["fechaCaptura"];
		if(array_key_exists("subTotal", $datos)) $this->subtotal =$datos["subTotal"];
		if(array_key_exists("total", $datos)) $this->total =$datos["total"];
		
		if(array_key_exists("fechaCaptura", $datos)) $this->fechaCaptura =$datos["fechaCaptura"];
		if(array_key_exists("formaLiquidar", $datos)) $this->formaLiquidar =$datos["formaLiquidar"];
		if(array_key_exists("conceptoPago", $datos)) $this->conceptoPago =$datos["conceptoPago"];
		
		
	}

    public function toArray()
    {
        $datos = array();
		
		$datos["idCuentasxc"] = $this->idCuestasxc;
		$datos["idTipoMovimiento"] = $this->idTipoMovimiento;
		$datos["idEmpresa"] = $this->idEmpresa;
		$datos["idCoP"] = $this->idCoP;
		$datos["numFolio"] = $this->numFolio;
		$datos["idProyecto"] = $this->idProyecto;
		$datos["descripcion"] = $this->descripcion;
		$datos["numeroReferencia"] = $this->numeroReferencia;
		$datos["secuencial"] = $this->secuencial;
		$datos["estatus"] = $this->estatus;
		$datos["fecha"] = $this->fecha;
		$datos["fechaCaptura"] = $this->fechaCaptura;
		$datos["formaLiquidar"] = $this->formaLiquidar;
		$datos["conceptoPago"] = $this->conceptoPago;
		$datos["subTotal"] = $this->subtotal;
		$datos["total"] = $this->total;
		
		$datos["idBanco"] = $this->idBanco;
		$datos["idDivisa"] = $this->idDivisa;
		$datos["numFolio"] = $this->numFolio;
			
		return $datos;
    }
}

