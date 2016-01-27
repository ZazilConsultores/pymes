<?php
/*
 @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */

class Sistema_Model_Proveedor
{
	private $idProveedor;

    public function getIdProveedor() {
        return $this->idProveedor;
    }
    
    public function setIdProveedor($idProveedor) {
        $this->idProveedor = $idProveedor;
    }
	
	private $idEmpresa;

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
    
    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

	private $idTipoProveedor;

    public function getIdTipoProveedor() {
        return $this->idTipoProveedor;
    }
    
    public function setIdTipoProveedor($idTipoProveedor) {
        $this->idTipoProveedor = $idTipoProveedor;
    }
	
	private $fiscales;

    public function getFiscales() {
        return $this->fiscales;
    }
    
    public function setFiscales($fiscales) {
        $this->fiscales = $fiscales;
    }

    private $domicilio;

    public function getDomicilio() {
        return $this->domicilio;
    }
    
    public function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    private $telefono;

    public function getTelefono() {
        return $this->telefono;
    }
    
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    private $email;

    public function getEmail() {
        return $this->email;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }

	public function __construct(array $datos)
    {
    	$this->idProveedor= $datos["idProveedor"];
    	$this->idEmpresa = $datos["idEmpresa"];
		$this->idTipoEmpresa = $datos["idTipoEmpresa"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idProveedor"] = $this->idProveedor;
		$datos["idEmpresa"] = $this->idEmpresa; 
		$datos["idTipoEmpresa"] = $this->idTipoEmpresa;
	
		return $datos;
	}

}

