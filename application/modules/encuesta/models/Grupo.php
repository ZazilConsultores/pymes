<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Grupo
{
	private $idGrupo;

    function getIdGrupo() {
        return $this->idGrupo;
    }
    
    function setIdGrupo($idGrupo) {
        $this->idGrupo = $idGrupo;
    }

	private $idSeccion;

    function getIdSeccion() {
        return $this->idSeccion;
    }
    
    function setIdSeccion($idSeccion) {
        $this->idSeccion = $idSeccion;
    }
	
	private $nombre;

    function getNombre() {
        return $this->nombre;
    }
    
    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
	
	private $tipo;

    function getTipo() {
        return $this->tipo;
    }
    
    function setTipo($tipo) {
        $this->tipo = $tipo;
    }
	
	private $elementos;
	
	public function getElementos()
	{
		return $this->elementos;
	}
	
	public function setElementos($elementos)
	{
		$this->elementos = $elementos;
	}

	private $orden;

    function getOrden() {
        return $this->orden;
    }
    
    function setOrden($orden) {
        $this->orden = $orden;
    }
	
	function __construct(array $datos) {
		
		$this->idSeccion = $datos["idSeccion"];
		$this->nombre = $datos["nombre"];
		$this->tipo = $datos["tipo"];
		
		if(array_key_exists("orden", $datos)) $this->orden = $datos["orden"];
		if(array_key_exists("elementos", $datos)) $this->elementos = $datos["elementos"];
		
		if(array_key_exists("idGrupo", $datos)){
			$this->idGrupo = $datos["idGrupo"];
		} else {
			$conjunto = $this->idSeccion . $this->nombre . $this->tipo;
			$this->idGrupo = hash("adler32", $conjunto);
		}
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idGrupo"] = $this->idGrupo;
		$datos["idSeccion"] = $this->idSeccion;
		$datos["nombre"] = $this->nombre;
		$datos["tipo"] = $this->tipo;
		$datos["orden"] = $this->orden;
		$datos["elementos"] = $this->elementos;
		
		return $datos;
	}
}

