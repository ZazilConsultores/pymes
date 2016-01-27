<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_Model_Cliente
{
	private $idCliente;

    public function getIdCliente() {
        return $this->idCliente;
    }
    
    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    private $idEmpresa;

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
    
    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
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
    	$this->idClientes = $datos["idCliente"];
        $this->idEmpresa = $datos["idEmpresa"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idCliente"] = $this->idClientes;
		$datos["idEmpresa"] = $this->idEmpresa;
		
		return $datos;
	}
	
}

