<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Opcion
{
	private $idOpcion;

    public function getIdOpcion() {
        return $this->idOpcion;
    }
    
    public function setIdOpcion($idOpcion) {
        $this->idOpcion = $idOpcion;
    }

    private $idCategoria;

    public function getIdCategoria() {
        return $this->idCategoria;
    }
    
    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    private $opcion;

    public function getOpcion() {
        return $this->opcion;
    }
    
    public function setOpcion($opcion) {
        $this->opcion = $opcion;
    }
	
	private $orden;

    public function getOrden() {
        return $this->orden;
    }
    
    public function setOrden($orden) {
        $this->orden = $orden;
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
    	if(is_null($this->hash)) $this->setHash(Util_Secure::generateKey($this->toArray()));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos) 
    {
    	if(array_key_exists("idOpcion", $datos)) $this->idOpcion = $datos["idOpcion"];
		if(array_key_exists("idCategoria", $datos)) $this->idCategoria = $datos["idCategoria"];
		$this->opcion = $datos["opcion"];
		$this->orden = $datos["orden"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idOpcion"] = $this->idOpcion;
		$datos["idCategoria"] = $this->idCategoria;
		$datos["opcion"] = $this->opcion;
		$datos["orden"] = $this->orden;
		$datos["fecha"] = $this->fecha;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

