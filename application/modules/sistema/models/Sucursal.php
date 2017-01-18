<?php

class Sistema_Model_Sucursal
{
	private $idSucursal;

    public function getIdSucursal() {
        return $this->idSucursal;
    }
    
    public function setIdSucursal($idSucursal) {
        $this->idSucursal = $idSucursal;
    }

    private $idFiscales;

    public function getIdFiscales() {
        return $this->idFiscales;
    }
    
    public function setIdFiscales($idFiscales) {
        $this->idFiscales = $idFiscales;
    }

    private $nombreSucursal;

    public function getNombreSucursal() {
        return $this->nombreSucursal;
    }
    
    public function setNombreSucursal($nombreSucursal) {
        $this->nombreSucursal = $nombreSucursal;
    }

    private $tipoSucursal;

    public function getTipoSucursal() {
        return $this->tipoSucursal;
    }
    
    public function setTipoSucursal($tipoSucursal) {
        $this->tipoSucursal = $tipoSucursal;
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

    public function __construct(array $datos)
    {
        if(array_key_exists("idSucursal", $datos)) $this->idSucursal = $datos["idSucursal"];
		if(array_key_exists("idFiscales", $datos)) $this->idFiscales = $datos["idFiscales"];
		$this->nombreSucursal = $datos["nombreSucursal"];
		$this->tipoSucursal = $datos["tipoSucursal"];
		$this->idDomicilio = $datos["idDomicilio"];
		$this->idsTelefonos = $datos["idsTelefonos"];
		$this->idsEmails = $datos["idsEmails"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idSucursal"] = $this->idSucursal;
		$datos["idFiscales"] = $this->idFiscales;
		$datos["nombreSucursal"] = $this->nombreSucursal;
		$datos["tipoSucursal"] = $this->tipoSucursal;
		$datos["idDomicilio"] = $this->idDomicilio;
		$datos["idsTelefonos"] = $this->idsTelefonos;
		$datos["idsEmails"] = $this->idsEmails;
		
		return $datos;
	}
	

}

