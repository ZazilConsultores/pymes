<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Vendedor
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

	private $nombre;

    public function getNombre() {
        return $this->nombre;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

	/*private $idTelefono;

    public function getIdTelefono() {
        return $this->idTelefono;
    }
    
    public function setIdTelefono($idTelefono) {
        $this->idTelefono = $idTelefono;
    }
	private $idDomicilio;

    public function getIdDomicilio() {
        return $this->idDomicilio;
    }
    
    public function setIdDomicilio($idDomicilio) {
        $this->idDomicilio = $idDomicilio;
    }*/

    
	private $estatus;

    public function getEstatus() {
        return $this->estatus;
    }
    
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }

	private $idFechaAlta;

    public function getIdFechaAlta() {
        return $this->idFechaAlta;
    }
    
    public function setIdFechaAlta($idFechaAlta) {
        $this->idFechaAlta = $idFechaAlta;
    }

    
	private $comision;

    public function getComision() {
        return $this->comision;
    }
    
    public function setComision($comision) {
        $this->comision = $comision;
    }

    public function __construct(array $datos)
    {
    	$this->claveVendedor= $datos["claveVendedor"];
    	$this->nombre = $datos["nombre"];
		$this->estatus = $datos["estatus"];
		$this->fechaAlta= $datos["fechaAlta"];
		$this->comision = $datos["comision"];
	
	    
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idVendedor"] = $this->idVendedor;
		$datos["claveVendedor"] = $this->claveVendedor; 
		$datos["nombre"] = $this->nombre;
		$datos["estatus"] = $this->estatus;
		$datos["fechaAlta"] = $this->fechaAlta;
		$datos["comision"] = $this->comision;
	
		return $datos;
	}
	

}

