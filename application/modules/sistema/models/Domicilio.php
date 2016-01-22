<?php

class Sistema_Model_Domicilio
{
	private $idDomicilio;

    public function getIdDomicilio() {
        return $this->idDomicilio;
    }
    
    public function setIdDomicilio($idDomicilio) {
        $this->idDomicilio = $idDomicilio;
    }

    private $idMunicipio;

    public function getIdMunicipio() {
        return $this->idMunicipio;
    }
    
    public function setIdMunicipio($idMunicipio) {
        $this->idMunicipio = $idMunicipio;
    }

    private $idEstado;

    public function getIdEstado() {
        return $this->idEstado;
    }
    
    public function setIdEstado($idEstado) {
        $this->idEstado = $idEstado;
    }

    private $calle;

    public function getCalle() {
        return $this->calle;
    }
    
    public function setCalle($calle) {
        $this->calle = $calle;
    }

    private $colonia;

    public function getColonia() {
        return $this->colonia;
    }
    
    public function setColonia($colonia) {
        $this->colonia = $colonia;
    }

    private $codigoPostal;

    public function getCodigoPostal() {
        return $this->codigoPostal;
    }
    
    public function setCodigoPostal($codigoPostal) {
        $this->codigoPostal = $codigoPostal;
    }

    private $numeroInterior;

    public function getNumeroInterior() {
        return $this->numeroInterior;
    }
    
    public function setNumeroInterior($numeroInterior) {
        $this->numeroInterior = $numeroInterior;
    }

    private $numeroExterior;

    public function getNumeroExterior() {
        return $this->numeroExterior;
    }
    
    public function setNumeroExterior($numeroExterior) {
        $this->numeroExterior = $numeroExterior;
    }

    public function __construct(array $datos)
    {
    	
        //$this->idMunicipio = $datos["idMunicipio"];
		//$this->idEstado = $datos["idEstado"];
		$this->calle = $datos["calle"];
		$this->colonia = $datos["colonia"];
		$this->codigoPostal = $datos["codigoPostal"];
		$this->numeroInterior = $datos["numeroInterior"];
		$this->numeroExterior = $datos["numeroExterior"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idDomicilio"] = $this->idDomicilio;
		$datos["idMunicipio"] = $this->idMunicipio;
		$datos["idEstado"] = $this->idEstado;
		$datos["calle"] = $this->calle;
		$datos["colonia"] = $this->colonia;
		$datos["codigoPostal"] = $this->codigoPostal;
		$datos["numeroInterior"] = $this->numeroInterior;
		$datos["numeroExterior"] = $this->numeroExterior;
		
		return $datos;
	}
	


}

