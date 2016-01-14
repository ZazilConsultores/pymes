<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Seccion
{
	private $idSeccion;

    public function getIdSeccion() {
        return $this->idSeccion;
    }
    
    public function setIdSeccion($idSeccion) {
        $this->idSeccion = $idSeccion;
    }

    private $idEncuesta;

    public function getIdEncuesta() {
        return $this->idEncuesta;
    }
    
    public function setIdEncuesta($idEncuesta) {
        $this->idEncuesta = $idEncuesta;
    }

    private $nombre;

    public function getNombre() {
        return $this->nombre;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    private $orden;

    public function getOrden() {
        return $this->orden;
    }
    
    public function setOrden($orden) {
        $this->orden = $orden;
    }

    private $elementos;

    public function getElementos() {
        return $this->elementos;
    }
    
    public function setElementos($elementos) {
        $this->elementos = $elementos;
    }
	
	private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->setHash(Util_Secure::generateKey($this->toArray()));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos) {
		
		if(array_key_exists("idSeccion", $datos)) $this->idSeccion = $datos["idSeccion"];
		if(array_key_exists("idEncuesta", $datos)) $this->idEncuesta = $datos["idEncuesta"];
		$this->nombre = $datos["nombre"];
		$this->fecha = $datos["fecha"];
		if(array_key_exists("orden", $datos)) $this->orden = $datos["orden"];
		if(array_key_exists("elementos", $datos)) $this->elementos = $datos["elementos"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idSeccion"] = $this->idSeccion;
		$datos["idEncuesta"] = $this->idEncuesta;
		$datos["nombre"] = $this->nombre;
		$datos["fecha"] = $this->fecha;
		$datos["orden"] = $this->orden;
		$datos["elementos"] = $this->elementos;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

