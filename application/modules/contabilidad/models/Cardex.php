<?php

class Contabilidad_Model_Cardex
{
	protected $_name = 'Cardex';
	
	private $idCardex;

    public function getIdCardex() {
        return $this->idCardex;
    }
    
    public function setIdCardex($idCardex) {
        $this->idCardex = $idCardex;
    }

	private $secuencialEntrada;

    public function getSecuencialEntrada() {
        return $this->secuencialEntrada;
    }
    
    public function setSecuencialEntrada($secuencialEntrada) {
        $this->secuencialEntrada = $secuencialEntrada;
    }
	
	private $fechaEntrada;

    public function getFechaEntrada() {
        return $this->fechaEntrada;
    }
    
    public function setFechaEntrada($fechaEntrada) {
        $this->fechaEntrada = $fechaEntrada;
    }

    private $idProducto;

    public function getIdProducto() {
        return $this->idProducto;
    }
    
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    private $secuencialSalida;

    public function getSecuencialSalida() {
        return $this->secuencialSalida;
    }
    
    public function setSecuencialSalida($secuencialSalida) {
        $this->secuencialSalida = $secuencialSalida;
    }

	private $fechaSalida;

    public function getFechaSalida() {
        return $this->fechaSalida;
    }
    
    public function setFechaSalida($fechaSalida) {
        $this->fechaSalida = $fechaSalida;
    }
    
	private $cantidad;

    public function getCantidad() {
        return $this->cantidad;
    }
    
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    private $costo;

    public function getCosto() {
        return $this->costo;
    }
    
    public function setCosto($costo) {
        $this->costo = $costo;
    }

    private $costoSalida;

    public function getCostoSalida() {
        return $this->costoSalida;
    }
    
    public function setCostoSalida($costoSalida) {
        $this->costoSalida = $costoSalida;
    }
	
    private $idFactura;

    public function getIdFactura() {
        return $this->idFactura;
    }
    
    public function setIdFactura($idFactura) {
        $this->idFactura = $idFactura;
    }

    private $utilidad;

    public function getUtilidad() {
        return $this->utilidad;
    }
    
    public function setUtilidad($utilidad) {
        $this->utilidad = $utilidad;
    }

    private $idDivisa;

    public function getIdDivisa() {
        return $this->idDivisa;
    }
    
    public function setIdDivisa($idDivisa) {
        $this->idDivisa = $idDivisa;
    }

	private $idPoliza;

    public function getIdPoliza() {
        return $this->idPoliza;
    }
    
    public function setIdPoliza($idPoliza) {
        $this->idPoliza = $idPoliza;
    }

    private $estatus;

    public function getEstatus() {
        return $this->estatus;
    }
    
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }
	
	public function __construct(array $datos)
	{
		if(array_key_exists("idCardex", $datos)) $this->idCardex = $datos["idCardex"];
		if(array_key_exists("secuecialEntrada", $datos)) $this->secuencialEntrada = $datos["secuencialEntrada"];
		if(array_key_exists("fechaEntrada", $datos)) $this->fechaEntrada = $datos["fechaEntrada"];
		if(array_key_exists("idProducto", $datos)) $this->idProducto =$datos["idProducto"];
		if(array_key_exists("secuencialSalida", $datos)) $this->secuencialSalida =$datos["secuencialSalida"];
		if(array_key_exists("fechaSalida", $datos)) $this->fechaSalida =$datos["fechaSalida"];
		if(array_key_exists("cantidad", $datos)) $this->cantidad =$datos["cantidad"];
		if(array_key_exists("costo", $datos)) $this->costo =$datos["costo"];
		if(array_key_exists("costoSalida", $datos)) $this->costoSalida = $datos["costoSalida"];
		if(array_key_exists("idFactura", $datos)) $this->idFactura =$datos["idFactura"];
		if(array_key_exists("utilidad", $datos)) $this->utilidad =$datos["utilidad"];
		if(array_key_exists("idDivisa", $datos)) $this->idDivisa =$datos["idDivisa"];
		if(array_key_exists("idPoliza", $datos)) $this->idPoliza =$datos["idPoliza"];
		if(array_key_exists("estatus", $datos)) $this->estatus =$datos["estatus"];
		

	}

    public function toArray()
    {
        $datos = array();
		
		$datos["idCardex"] = $this->idCardex;
		$datos["secuencialEntrada"] = $this->secuencialEntrada;
		$datos["fechaEntrada"] = $this->fechaEntrada;
		$datos["idProducto"] = $this->idProducto;
		$datos["secuencialSalida"] = $this->secuencialSalida;
		$datos["fechaSalida"] = $this->fechaSalida;
		$datos["cantidad"] = $this->cantidad;
		$datos["costo"] = $this->costo;
		
		$datos["costoSalida"] = $this->costoSalida;
		$datos["idFactura"] = $this->idFactura;
		$datos["utilidad"] = $this->utilidad;
		$datos["idDivisa"] = $this->idDivisa;
		$datos["idPoliza"] = $this->idPoliza;
		$datos["estatus"] = $this->estatus;
			
		return $datos;
    }
    
	

}

