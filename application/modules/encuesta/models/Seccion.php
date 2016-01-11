<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Seccion
{
	private $idSeccion;

    function getIdSeccion() {
        return $this->idSeccion;
    }
    
    function setIdSeccion($idSeccion) {
        $this->idSeccion = $idSeccion;
    }

	private $idEncuesta;

    function getIdEncuesta() {
        return $this->idEncuesta;
    }
    
    function setIdEncuesta($idEncuesta) {
        $this->idEncuesta = $idEncuesta;
    }

	private $nombre;

    function getNombre() {
        return $this->nombre;
    }
    
    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
	private $orden;

    function getOrden() {
        return $this->orden;
    }
    
    function setOrden($orden) {
        $this->orden = $orden;
    }
	
	private $elementos;
	
	function getElementos() {
        return $this->elementos;
    }
    
    function setElementos($elementos) {
        $this->elementos = $elementos;
    }
	
	function __construct(array $datos) {
		
		$this->idEncuesta = $datos["idEncuesta"];
		$this->nombre = $datos["nombre"];
		if(array_key_exists("orden", $datos)) $this->orden = $datos["orden"];
		if(array_key_exists("elementos", $datos)) $this->elementos = $datos["elementos"];
		
		if(array_key_exists("idSeccion", $datos)){
			$this->idSeccion = $datos["idSeccion"];
		}else{
			$conjunto = $datos["idEncuesta"] . $datos["nombre"];
			$this->idSeccion = hash("adler32", $conjunto);
		}
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idSeccion"] = $this->idSeccion;
		$datos["idEncuesta"] = $this->idEncuesta;
		$datos["nombre"] = $this->nombre;
		$datos["orden"] = $this->orden;
		$datos["elementos"] = $this->elementos;
		
		return $datos;
	}
}

