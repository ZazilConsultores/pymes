<?php

class Contabilidad_Model_Movimientos
{
	protected $_name = 'Movimientos';
	
	private $idMovimientos;

    public function getIdMovimientos() {
        return $this->idMovimientos;
    }
    
    public function setIdMovimientos($idMovimientos) {
        $this->idMovimientos = $idMovimientos;
    }
	
	private $idProducto;

    public function getIdProducto() {
        return $this->idProducto;
    }
    
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }
	
	private $idTipoMovimiento;

    public function getIdTipoMovimiento() {
        return $this->idTipoMovimiento;
    }
    
    public function setIdTipoMovimiento($idTipoMovimiento) {
        $this->idTipoMovimiento = $idTipoMovimiento;
    }
	
	private $idEmpresa;

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
    
    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }


	private $idProyecto;

    public function getIdProyecto() {
        return $this->idProyecto;
    }
    
    public function setIdProyecto($idProyecto) {
        $this->idProyecto = $idProyecto;
    }
	

	private $cantidad;

    public function getCantidad() {
        return $this->cantidad;
    }
    
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    

	private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
	
	
	private $costoUnitario;

    public function getCostoUnitario() {
        return $this->costoUnitario;
    }
    
    public function setCostoUnitario($costoUnitario) {
        $this->costoUnitario = $costoUnitario;
    }
	
	private $totalImporte;

    public function getTotalImporte() {
        return $this->totalImporte;
    }
    
    public function setTotalImporte($totalImporte) {
        $this->totalImporte = $totalImporte;
    }
	
	private $estatus;

    public function getEstatus() {
        return $this->estatus;
    }
    
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }

    private $secuencial;

    public function getSecuencial() {
        return $this->secuencial;
    }
    
    public function setSecuencial($secuencial) {
        $this->secuencial = $secuencial;
    }
	
	private $esOrigen;

    public function getEsOrigen() {
        return $this->esOrigen;
    }
    
    public function setEsOrigen($esOrigen) {
        $this->esOrigen = $esOrigen;
    }
	
	private $numFactura;

    public function getNumFactura() {
        return $this->numFactura;
    }
    
    public function setNumFactura($numFactura) {
        $this->numFactura = $numFactura;
    }
	
	public function __construct(array $datos)
	{
		if(array_key_exists("idMovimientos", $datos)) $this->idMovimientos = $datos["idMovimientos"];
		if(array_key_exists("idProducto", $datos)) $this->idProducto = $datos["idProducto"];
		if(array_key_exists("idTipoMovimiento", $datos)) $this->idTipoMovimiento = $datos["idTipoMovimiento"];		
		if(array_key_exists("idEmpresa", $datos)) $this->idEmpresa = $datos["idEmpresa"];
		if(array_key_exists("idProyecto", $datos)) $this->idProyecto = $datos["idProyecto"];
		if (array_key_exists("cantidad",$datos )) $this->cantidad =$datos["cantidad"];
		if (array_key_exists("fecha",$datos )) $this->fecha =$datos["fecha"];
		if (array_key_exists("secuencial",$datos )) $this->secuencial =$datos["secuencial"];	
		if (array_key_exists("estatus",$datos )) $this->estatus =$datos["estatus"];
		if (array_key_exists("costoUnitario",$datos )) $this->costoUnitario =$datos["costoUnitario"];
		if (array_key_exists("esOrigen",$datos )) $this->esOrigen =$datos["esOrigen"];
		if (array_key_exists("totalImporte",$datos )) $this->totalImporte =$datos["totalImporte"];
		if (array_key_exists("numFactura",$datos )) $this->numFactura =$datos["numFactura"];

		
		
	}

    public function toArray()
    {
        $datos = array();
		
		$datos["idMovimientos"] = $this->idMovimientos;
		$datos["idProducto"] = $this->idProducto;
		$datos["idTipoMovimiento"] = $this->idTipoMovimiento;
		$datos["idEmpresa"] = $this->idEmpresa;
		
		$datos["idProyecto"] = $this->idProyecto;
		$datos["cantidad"] = $this->cantidad;
		$datos["fecha"] = $this->fecha;
		$datos["secuencial"] = $this->secuencial;
		$datos["estatus"] = $this->estatus;
		$datos["CostoUnitario"] = $this->costoUnitario;
		$datos["esOrigen"] = $this->esOrigen;
		$datos["totalImporte"]=$this->totalImporte;
		$datos["numFactura"]=$this->numFactura;
		
		
		
		return $datos;
    }
    

}

