<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Encuesta
{
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
	
	private $nombreClave;

    public function getNombreClave() {
        return $this->nombreClave;
    }
    
    public function setNombreClave($nombreClave) {
        $this->nombreClave = $nombreClave;
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

    private $fechaInicio;

    public function getFechaInicio() {
        return $this->fechaInicio;
    }
    
    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    private $fechaFin;

    public function getFechaFin() {
        return $this->fechaFin;
    }
    
    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    private $estatus;

    public function getEstatus() {
        return $this->estatus;
    }
    
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }

    public function __construct(array $datos) {
		
		$this->nombre = $datos["nombre"];
		$this->nombreClave = $datos["nombreClave"];
		$this->descripcion = $datos["descripcion"];
		$this->fecha = $datos["fecha"];
		$this->fechaInicio = $datos["fechaInicio"];
		$this->fechaFin = $datos["fechaFin"];
		$this->estatus = $datos["estatus"];
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idEncuesta"] = $this->idEncuesta;
		$datos["nombre"] = $this->nombre;
		$datos["nombreClave"] = $this->nombreClave;
		$datos["descripcion"] = $this->descripcion;
		$datos["fecha"] = $this->fecha;
		$datos["fechaInicio"] = $this->fechaInicio;
		$datos["fechaFin"] = $this->fechaFin;
		$datos["estatus"] = $this->estatus;
		
		return $datos;
	}
}

