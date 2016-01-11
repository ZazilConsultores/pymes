<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Telefono
{
	private $idTelefono;

    public function getIdTelefono() {
        return $this->idTelefono;
    }
    
    public function setIdTelefono($idTelefono) {
        $this->idTelefono = $idTelefono;
    }
	
	private $lada;

    public function getLada() {
        return $this->lada;
    }
    
    public function setLada($lada) {
        $this->lada = $lada;
    }

	private $telefono;

    public function getTelefono() {
        return $this->telefono;
    }
    
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
	
	private $extensiones;

    public function getExtensiones() {
        return $this->extensiones;
    }
    
    public function setExtensiones($extensiones) {
        $this->extensiones = $extensiones;
    }

    public function __construct(array $datos)
    {
    	$this->lada= $datos["lada"];
    	$this->telefono = $datos["telefono"];
		$this->extensiones = $datos["extensiones"];
		
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idTelefono"] = $this->idTelefono;
		$datos["lada"] = $this->lada; 
		$datos["telefono"] = $this->telefono;
		$datos["extensiones"] = $this->extensiones;
	
		return $datos;
	}
    

}

