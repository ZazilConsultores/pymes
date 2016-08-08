<?php

class Inventario_Model_Inventario
{
	private $idInventario;

    public function getIdInventario() {
        return $this->idInventario;
    }
    
    public function setIdInventario($idInventario) {
        $this->idInventario = $idInventario;
    }

	private $idProducto;

    public function getIdProducto() {
        return $this->idProducto;
    }
    
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

	private $idEmpresa;

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
    
    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }
	
	private $idDivisa;

    public function getIdDivisa() {
        return $this->idDivisa;
    }
    
    public function setIdDivisa($idDivisa) {
        $this->idDivisa = $idDivisa;
    }
	
	private $existencia;

    public function getExistencia() {
        return $this->existencia;
    }
    
    public function setExistencia($existencia) {
        $this->existencia = $existencia;
    }

	private $apartado;

    public function getApartado() {
        return $this->apartado;
    }
    
    public function setApartado($apartado) {
        $this->apartado = $apartado;
    }

	private $existenciaReal;

    public function getExistenciaReal() {
        return $this->existenciaReal;
    }
    
    public function setExistenciaReal($existenciaReal) {
        $this->existenciaReal = $existenciaReal;
    }
	
	private $maximo;

    public function getMaximo() {
        return $this->maximo;
    }
    
    public function setMaximo($maximo) {
        $this->maximo = $maximo;
    }

	private $minimo;

    public function getMinimo() {
        return $this->minimo;
    }
    
    public function setMinimo($minimo) {
        $this->minimo = $minimo;
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

	private $porcentajeGanancia;

    public function getPorcentajeGanancia() {
        return $this->porcentajeGanancia;
    }
    
    public function setPorcentajeGanancia($porcentajeGanancia) {
        $this->porcentajeGanancia = $porcentajeGanancia;
    }

	private $cantidadGanancia;

    public function getCantidadGanancia() {
        return $this->cantidadGanancia;
    }
    
    public function setCantidadGanancia($cantidadGanancia) {
        $this->cantidadGanancia = $cantidadGanancia;
    }
	private $costoCliente;

    public function getCostoCliente() {
        return $this->costoCliente;
    }
    
    public function setCostoCliente($costoCliente) {
        $this->costoCliente = $costoCliente;
    }

    public function __construct(array $datos)
	{
		if(array_key_exists("idInventario", $datos)) $this->idInventario = $datos["idInventario"];
		if(array_key_exists("idProducto", $datos)) $this->idProducto = $datos["idProducto"];
		if(array_key_exists("idEmpresa", $datos)) $this->idEmpresa = $datos["idEmpresa"];
		if(array_key_exists("idDivisa", $datos)) $this->idDivisa = $datos["idDivisa"];
	
		$this->existencia = $datos["existencia"];
		$this->apartado = $datos["apartado"];
		$this->existenciaReal = $datos["existenciaReal"];
		$this->maximo = $datos["maximo"];
		$this->minimo = $datos["minimo"];
		$this->fecha = $datos["fecha"];
		$this->costoUnitario = $datos["costoUnitario"];
		$this->porcentajeGanancia = $datos["porcentajeGanancia"];
		$this->cantidadGanancia = $datos["cantidadGanancia"];
		$this->costoCliente = $datos["costoCliente"];

	}
	
	public function toArray()
	{
		$datos = Array();
		
		$datos["idInventario"] = $this->idInventario;
		$datos["idProducto"] = $this->idProducto;
		$datos["idEmpresa"] = $this->idEmpresa;
		$datos["idDivisa"] = $this->idDivisa;
		$datos["existencia"] = $this->existencia;
		$datos["apartado"] = $this->apartado;
		$datos["existenciaReal"] = $this->existenciaReali;
		$datos["maximo"]=$this->maximo;
		$datos["minimo"]=$this->minimo;
		$datos["fecha"]=$this->fecha;
		$datos["costoUnitario"]=$this->costoUnitario;
		$datos["porcentajeGanancia"]=$this->porcentajeGanancia;
		$datos["cantidadGanancia"]=$this->cantidadGanancia;
		$datos["costoCliente"]=$this->costoCliente;
		
		return $datos;
			 
	}
}

