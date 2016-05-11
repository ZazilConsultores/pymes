<?php

class Contabilidad_Model_Capas
{
	
	protected $_name = 'Capas';
	
	private $idCapas;

    public function getIdCapas() {
        return $this->idCapas;
    }
    
    public function setIdCapas($idCapas) {
        $this->idCapas = $idCapas;
    }

    
	private $idProducto;

    public function getIdProducto() {
        return $this->idProducto;
    }
    
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }
	
	private $secuencial;

    public function getSecuencial() {
        return $this->secuencial;
    }
    
    public function setSecuencial($secuencial) {
        $this->secuencial = $secuencial;
    }

	private $entrada;

    public function getEntrada() {
        return $this->entrada;
    }
    
    public function setEntrada($entrada) {
        $this->entrada = $entrada;
    }

    
   
   	private $fechaEntrada;

    public function getFechaEntrada() {
        return $this->fechaEntrada;
    }
    
    public function setFechaEntrada($fechaEntrada) {
        $this->fechaEntrada = $fechaEntrada;
    }

    private $costoUnitario;

    public function getCostoUnitario() {
        return $this->costoUnitario;
    }
    
    public function setCostoUnitario($costoUnitario) {
        $this->costoUnitario = $costoUnitario;
    }

    private $costoTotal;

    public function getCostoTotal() {
        return $this->costoTotal;
    }
    
    public function setCostoTotal($costoTotal) {
        $this->costoTotal = $costoTotal;
    }


	private $idDivisa;

    public function getIdDivisa() {
        return $this->idDivisa;
    }
    
    public function setIdDivisa($idDivisa) {
        $this->idDivisa = $idDivisa;
    }
	
	public function __construct(array $datos)
	{
		if(array_key_exists("idCapas", $datos)) $this->idCapas = $datos["idCapas"];
		if(array_key_exists("idProducto", $datos)) $this->idProducto = $datos["idProducto"];
		if(array_key_exists("idDivisa", $datos)) $this->idDivisa = $datos["idDivisa"];
		if(array_key_exists("secuencial", $datos)) $this->secuencial =$datos["secuencial"];
		if(array_key_exists("entrada", $datos)) $this->entrada =$datos["entrada"];
		if(array_key_exists("fechaEntrada", $datos)) $this->fechaEntradaentrada =$datos["fechaEntrada"];
		if(array_key_exists("costoTotal", $datos)) $this->costoTotal =$datos["costoTotal"];
		if(array_key_exists("costoUnitario", $datos)) $this->costoUnitario =$datos["costoUnitario"];
		

	}

    public function toArray()
    {
        $datos = array();
		
		$datos["idCapas"] = $this->idCapas;
		$datos["idProducto"] = $this->idProducto;
		$datos["idDivisa"] = $this->idDivisa;
		$datos["secuencial"] = $this->secuencial;
		$datos["entrada"] = $this->entrada;
		$datos["fechaEntrada"] = $this->fechaEntrada;
		$datos["costoUnitario"] = $this->costoUnitario;
		$datos["costoTotal"] = $this->costoTotal;
			
		
		return $datos;
    }
    
	

}

