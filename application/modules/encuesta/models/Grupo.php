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

    private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    private $tipo;

    public function getTipo() {
        return $this->tipo;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
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

    public function __construct(array $datos) {
		
		//$this->idGrupo = $datos["idGrupo"];
		//$this->idSeccion = $datos["idSeccion"];
		$this->nombre = $datos["nombre"];
		$this->tipo = $datos["tipo"];
		$this->fecha = $datos["fecha"];
		//if(array_key_exists("orden", $datos)) $this->orden = $datos["orden"];
		//if(array_key_exists("elementos", $datos)) $this->elementos = $datos["elementos"];
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idGrupo"] = $this->idGrupo;
		$datos["idSeccion"] = $this->idSeccion;
		$datos["nombre"] = $this->nombre;
		$datos["tipo"] = $this->tipo;
		$datos["fecha"] = $this->fecha;
		$datos["orden"] = $this->orden;
		$datos["elementos"] = $this->elementos;
		
		return $datos;
	}
}

