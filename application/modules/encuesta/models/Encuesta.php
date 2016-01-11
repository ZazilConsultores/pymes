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

	private $detalle;

    public function getDetalle() {
        return $this->detalle;
    }
    
    public function setDetalle($detalle) {
        $this->detalle = $detalle;
    }
	
	private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    private $fechaRegistro;

    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    public function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
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
		$this->detalle = $datos["detalle"];
		$this->descripcion = $datos["descripcion"];
		$this->fechaRegistro = $datos["fechaRegistro"];
		$this->fechaInicio = $datos["fechaInicio"];
		$this->fechaFin = $datos["fechaFin"];
		$this->estatus = $datos["estatus"];
		//Generamos el ID de esta entidad
		//Este caso es cuando lo recuperamos de la base de datos (previamente generado)
		if(isset($datos["idEncuesta"]) && ! is_null($datos["idEncuesta"])){
			$this->idEncuesta = $datos["idEncuesta"];
		}else{
			//Este caso es cuando lo generamos en la aplicacion, es la primera vez que se genera.
			$conjunto = $datos["nombre"] . $datos["detalle"] . $datos["descripcion"] . $datos["fechaRegistro"];
			$conjunto .= $datos["fechaInicio"] . $datos["fechaFin"] . $datos["estatus"];
			
			$this->idEncuesta = hash("adler32", $conjunto);
			//echo sha1($conjunto);
		}
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["nombre"] = $this->nombre;
		$datos["detalle"] = $this->detalle;
		$datos["descripcion"] = $this->descripcion;
		$datos["fechaRegistro"] = $this->fechaRegistro;
		$datos["fechaInicio"] = $this->fechaInicio;
		$datos["fechaFin"] = $this->fechaFin;
		$datos["estatus"] = $this->estatus;
		
		if(isset($this->idEncuesta) && ! is_null($this->idEncuesta)){
			 $datos["idEncuesta"] = $this->idEncuesta;
		}else{
			$conjunto = $this->nombre . $this->detalle . $this->descripcion . $this->fechaRegistro;
			$conjunto .= $this->fechaInicio . $this->fechaFin . $this->estatus;
			$datos["idEncuesta"] = hash("adler32", $conjunto);
		}
		
		return $datos;
	}
}

