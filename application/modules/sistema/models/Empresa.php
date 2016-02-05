<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_Model_Empresa
{
	private $idEmpresa;

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
    
    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }
    
    private $idFiscales;

    public function getIdFiscales() {
        return $this->idFiscales;
    }
    
    public function setIdFiscales($idFiscales) {
        $this->idFiscales = $idFiscales;
    }
    
    private $esEmpresa;

    public function getEsEmpresa() {
        return $this->esEmpresa;
    }
    
    public function setEsEmpresa($esEmpresa) {
        $this->esEmpresa = $esEmpresa;
    }
    
    private $esCliente;

    public function getEsCliente() {
        return $this->esCliente;
    }
    
    public function setEsCliente($esCliente) {
        $this->esCliente = $esCliente;
    }
    
    private $esProveedor;

    public function getEsProveedor() {
        return $this->esProveedor;
    }
    
    public function setEsProveedor($esProveedor) {
        $this->esProveedor = $esProveedor;
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
    
    public function __construct(array $datos) {
        if(array_key_exists("idEmpresa", $datos)) $this->idEmpresa = $datos["idEmpresa"];
		if(array_key_exists("idFiscales", $datos)) $this->idFiscales = $datos["idFiscales"];
		if(array_key_exists("esEmpresa", $datos)) $this->esEmpresa = $datos["esEmpresa"];
		if(array_key_exists("esCliente", $datos)) $this->esCliente = $datos["esCliente"];
		if(array_key_exists("esProveedor", $datos)) $this->esProveedor = $datos["esProveedor"];
		if(array_key_exists("idsBancos", $datos)) $this->idsBancos = $datos["idsBancos"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray() {
		$datos = array();
		
		$datos["idEmpresa"] = $this->idEmpresa;
		$datos["idFiscales"] = $this->idFiscales;
		$datos["esEmpresa"] = $this->esEmpresa;
		$datos["esCliente"] = $this->esCliente;
		$datos["esProveedor"] = $this->esProveedor;
		$datos["fecha"] = $this->fecha;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}

}

