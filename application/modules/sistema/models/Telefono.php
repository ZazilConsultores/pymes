<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_Model_Telefono
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
	
	private $tipo;

    public function getTipo() {
        return $this->tipo;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
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
	
	private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
	
	private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    
    private $hash;

    function getHash() {
    	if(is_null($this->hash)) $this->hash = Util_Secure::generateKey($this->toArray());
        return $this->hash;
    }
    
    function setHash($hash) {
        $this->hash = $hash;
    }
    
    public function __construct(array $datos) {
    	if(array_key_exists("idTelefono", $datos)) $this->idTelefono = $datos["idTelefono"];
    	if(array_key_exists("lada", $datos)) $this->lada = $datos["lada"];
    	$this->tipo = $datos["tipo"];
    	$this->telefono = $datos["telefono"];
		if(array_key_exists("extensiones", $datos)) $this->extensiones = $datos["extensiones"];
		if(array_key_exists("descripcion", $datos)) $this->descripcion = $datos["descripcion"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray() {
		$datos = array();
		
		$datos["idTelefono"] = $this->idTelefono;
		$datos["tipo"] = $this->tipo;
		$datos["lada"] = $this->lada;
		$datos["telefono"] = $this->telefono;
		$datos["extensiones"] = $this->extensiones;
		$datos["descripcion"] = $this->descripcion;
		$datos["fecha"] = $this->fecha;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

