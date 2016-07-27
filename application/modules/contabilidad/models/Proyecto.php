<?php

class Contabilidad_Model_Proyecto
{
	protected $_name = 'Proyecto';
	
	private $idProyecto;

    public function getIdProyecto() {
        return $this->idProyecto;
    }
    
    public function setIdProyecto($idProyecto) {
        $this->idProyecto = $idProyecto;
    }

	private $idCoP;

    public function getIdCoP() {
        return $this->idCoP;
    }
    
    public function setIdCoP($idCoP) {
        $this->idCoP = $idCoP;
    }

    private $idSucursal;

    public function getIdSucursal() {
        return $this->idSucursal;
    }
    
    public function setIdSucursal($idSucursal) {
        $this->idSucursal = $idSucursal;
    }
		
	private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

	private $costo;

    public function getCosto() {
        return $this->costo;
    }
    
    public function setCosto($costo) {
        $this->costo = $costo;
    }
    
    private $ganancia;

    public function getGanancia() {
        return $this->ganancia;
    }
    
    public function setGanancia($ganancia) {
        $this->ganancia = $ganancia;
    }

    private $fechaApertura;

    public function getFechaApertura() {
        return $this->fechaApertura;
    }
    
    public function setFechaApertura($fechaApertura) {
        $this->fechaApertura = $fechaApertura;
    }

	private $fechaCierre;

    public function getFechaCierre() {
        return $this->fechaCierre;
    }
    
    public function setFechaCierre($fechaCierre) {
        $this->fechaCierre = $fechaCierre;
    }
	
	public function __construct(array $datos)
	{
		if(array_key_exists("idProyecto", $datos)) $this->idProyecto = $datos["idProyecto"];
		
		$this->idCoP = $datos["idCoP"];
		$this->idSucursal = $datos["idSucursal"];
		$this->descripcion = $datos["descripcion"];
		$this->costo = $datos["costo"];
		$this->ganancia = $datos["ganancia"];
		$this->fechaApertura = $datos["fechaApertura"];
		$this->fechaCierre = $datos["fechaCierre"];

		
		
	}

    public function toArray()
    {
        $datos = array();
		
		$datos["idProyecto"] = $this->idProyecto;
		$datos["idCoP"] = $this->idCoP;
		$datos["idSucursal"] = $this->idSucursal;
		$datos["descripcion"] = $this->descripcion;
		$datos["costo"] = $this->costo;
		$datos["gananacia"] = $this->ganancia;
		$datos["fechaApertura"] = $this->fechaApertura;
		$datos["fechaCierre"] = $this->fechaCierre;
		
		return $datos;
    }


}

