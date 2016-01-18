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
	
	/*private $tipo;

    public function getTipo() {
        return $this->tipo;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }*/

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
	
	/*private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }*/

    public function __construct(array $datos)
    {
    	if(array_key_exists("idTelefono", $datos)) $this->idTelefono = $datos["idTelefono"];
    	//$this->idTelefono = $datos["idTelefono"];
		//$this->tipo = $datos["tipo"];
    	$this->lada= $datos["lada"];
    	$this->telefono = $datos["telefono"];
		$this->extensiones = $datos["extensiones"];
		//$this->descripcion =$datos["descripcion"];
	
    }
	
	public function toArray()
	{
		$datos = array();	
		$datos["idTelefono"] = $this->idTelefono;
		//$datos["tipo"] = $this->tipo;
		$datos["lada"] = $this->lada; 
		$datos["telefono"] = $this->telefono;
		$datos["extensiones"] = $this->extensiones;
		//$datos["descripcion"] = $this->descripcion;
	
		return $datos;
	}
    

}

