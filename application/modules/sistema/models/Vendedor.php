<?php

class Sistema_Model_Vendedor
{
	private $idVendedor;

    public function getIdVendedor() {
        return $this->idVendedor;
    }
    
    public function setIdVendedor($idVendedor) {
        $this->idVendedor = $idVendedor;
    }

  
    private $claveVendedor;

    public function getClaveVendedor() {
        return $this->claveVendedor;
    }
    
    public function setClaveVendedor($claveVendedor) {
        $this->claveVendedor = $claveVendedor;
    }

    private $idDomicilio;

    public function getIdDomicilio() {
        return $this->idDomicilio;
    }
    
    public function setIdDomicilio($idDomicilio) {
        $this->idDomicilio = $idDomicilio;
    }
    
    private $idTelefono;

    public function getIdTelefono() {
        return $this->idTelefono;
    }
    
    public function setIdTelefono($idTelefono) {
        $this->idTelefono = $idTelefono;
    }
	
    private $nombre;

    public function getNombre() {
        return $this->nombre;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    private $estatus;

    public function getEstatus() {
        return $this->estatus;
    }
    
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }

    private $fechaAlta;

    public function getFechaAlta() {
        return $this->fechaAlta;
    }
    
    public function setFechaAlta($fechaAlta) {
        $this->fechaAlta = $fechaAlta;
    }

	private $comision;

    public function getComision() {
        return $this->comision;
    }
    
    public function setComision($comision) {
        $this->comision = $comision;
    }

       
	
	public function __construct(array $datos) {
        if(array_key_exists("idVendedor", $datos)) $this->idVendedor = $datos["idVendedor"];
		$this->claveVendedor = $datos["claveVendedor"];
		$this->idDomicilio = $datos["idDomicilio"];
		$this->idTelefono = $datos["idTelefono"];
		$this->nombre = $datos["nombre"];
		$this->estatus = $datos["estatus"];
		if(array_key_exists("fechaAlta", $datos)) $this->fechaAlta = $datos["fechaAlta"];
		$this->comision = $datos["comision"];
    }
	
	public function toArray() {
		$datos = array();
		
		$datos["idVendedor"] = $this->idVendedor;
		$datos["claveVendedor"] = $this->claveVendedor;
		$datos["idDomicilio"] = $this->idDomicilio;
		$datos["idTelefono"] = $this->idTelefono;
		$datos["nombre"] = $this->nombre;
		$datos["estatus"] = $this->estatus;
		$datos["fechaAlta"] = $this->fechaAlta;
		$datos["comision"] = $this->comision;
		
		return $datos;
	}


}

