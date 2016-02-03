<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
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
	
	private $hash;

    function getHash() {
    	if(is_null($this->hash)) $this->hash = Util_Secure::generateKey($this->toArray());
        return $this->hash;
    }
    
    function setHash($hash) {
        $this->hash = $hash;
    }
    
    public function __construct(array $datos) {
		if(array_key_exists("idDomicilio", $datos)) $this->idDomicilio = $datos["idDomicilio"];
		if(array_key_exists("idMunicipio", $datos)) $this->idMunicipio = $datos["idMunicipio"];
		$this->calle = $datos["calle"];
		$this->colonia = $datos["colonia"];
		$this->codigoPostal = $datos["codigoPostal"];
		$this->numeroInterior = $datos["numeroInterior"];
		$this->numeroExterior = $datos["numeroExterior"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray() {
		$datos = array();
		
		$datos["idDomicilio"] = $this->idDomicilio;
		$datos["idMunicipio"] = $this->idMunicipio;
		$datos["calle"] = $this->calle;
		$datos["colonia"] = $this->colonia;
		$datos["codigoPostal"] = $this->codigoPostal;
		$datos["numeroInterior"] = $this->numeroInterior;
		$datos["numeroExterior"] = $this->numeroExterior;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

