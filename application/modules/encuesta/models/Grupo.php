<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Grupo
{
	private $idGrupo;

    public function getIdGrupo() {
        return $this->idGrupo;
    }
    
    public function setIdGrupo($idGrupo) {
        $this->idGrupo = $idGrupo;
    }
	
	private $idSeccion;

    public function getIdSeccion() {
        return $this->idSeccion;
    }
    
    public function setIdSeccion($idSeccion) {
        $this->idSeccion = $idSeccion;
    }

    private $nombre;

    public function getNombre() {
        return $this->nombre;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    private $tipo;

    public function getTipo() {
        return $this->tipo;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
	
	private $opciones;

    public function getOpciones() {
        return $this->opciones;
    }
    
    public function setOpciones($opciones) {
        $this->opciones = $opciones;
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

    public function __construct(array $datos) {
		
		if(array_key_exists("idGrupo", $datos)) $this->idGrupo = $datos["idGrupo"];
		if(array_key_exists("idSeccion", $datos)) $this->idSeccion = $datos["idSeccion"];
		$this->nombre = $datos["nombre"];
		$this->tipo = $datos["tipo"];
		if(array_key_exists("opciones", $datos)) $this->opciones = $datos["opciones"];
		if(array_key_exists("orden", $datos)) $this->orden = $datos["orden"];
		if(array_key_exists("elementos", $datos)) $this->elementos = $datos["elementos"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idGrupo"] = $this->idGrupo;
		$datos["idSeccion"] = $this->idSeccion;
		$datos["nombre"] = $this->nombre;
		$datos["tipo"] = $this->tipo;
		$datos["opciones"] = $this->opciones;
		$datos["orden"] = $this->orden;
		$datos["elementos"] = $this->elementos;
		$datos["fecha"] = $this->fecha;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

