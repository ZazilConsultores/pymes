<?php

class Sistema_Model_Fiscal
{
	private $idFiscales;

    public function getIdFiscales() {
        return $this->idFiscales;
    }
    
    public function setIdFiscales($idFiscales) {
        $this->idFiscales = $idFiscales;
    }
	
	private $rfc;

    public function getRfc() {
        return $this->rfc;
    }
    
    public function setRfc($rfc) {
        $this->rfc = $rfc;
    }
	
	public $razonSocial;

    public function getRazonSocial() {
        return $this->razonSocial;
    }
    
    public function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
    }
	
	private $idDomicilio;

    public function getIdDomicilio() {
        return $this->idDomicilio;
    }
    
    public function setIdDomicilio($idDomicilio) {
        $this->idDomicilio = $idDomicilio;
    }
    
    private $idsTelefonos;

    public function getIdsTelefonos() {
        return $this->idsTelefonos;
    }
    
    public function setIdsTelefonos($idsTelefonos) {
        $this->idsTelefonos = $idsTelefonos;
    }
    
    private $idsEmails;

    public function getIdsEmails() {
        return $this->idsEmails;
    }
    
    public function setIdsEmails($idsEmails) {
        $this->idsEmails = $idsEmails;
    }
	
	private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    
    private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->hash = Util_Secure::generateKey($this->toArray());
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

	 public function __construct(array $datos)
    {
    	if(array_key_exists("idFiscales", $datos)) $this->idFiscales = $datos["idFiscales"];
    	$this->rfc= $datos["rfc"];
    	$this->razonSocial = $datos["razonSocial"];
		if(array_key_exists("idDomicilio", $datos)) $this->idDomicilio = $datos["idDomicilio"];
		if(array_key_exists("idsTelefonos", $datos)) $this->idsTelefonos = $datos["idsTelefonos"];
		if(array_key_exists("idsEmails", $datos)) $this->idsEmails = $datos["idsEmails"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray()
	{
		$datos = array();
			
		$datos["idFiscales"] = $this->idFiscales;
		$datos["rfc"] = $this->rfc; 
		$datos["razonSocial"] = $this->razonSocial;
		$datos["idDomicilio"] = $this->idDomicilio;
		$datos["idsTelefonos"] = $this->idsTelefonos;
		$datos["idsEmails"] = $this->idsEmails;
		$datos["fecha"] = $this->fecha;
		$datos["hash"] = $this->hash;
	
		return $datos;
	}
}

