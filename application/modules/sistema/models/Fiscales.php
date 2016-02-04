<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_Model_Fiscales {
	
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
    
    private $razonSocial;

    public function getRazonSocial() {
        return $this->razonSocial;
    }
    
    public function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
    }
    
    private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->hash = Util_Secure::generateKey($this->toArray());
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }
    
    public function __construct(array $datos) {
        if(array_key_exists("idFiscales", $datos)) $this->idFiscales = $datos["idFiscales"];
		$this->rfc = $datos["rfc"];
		$this->razonSocial = $datos["razonSocial"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	
	public function toArray() {
		$datos = array();
		
		$datos["idFiscales"] = $this->idFiscales;
		$datos["rfc"] = $this->rfc;
		$datos["razonSocial"] = $this->razonSocial;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

