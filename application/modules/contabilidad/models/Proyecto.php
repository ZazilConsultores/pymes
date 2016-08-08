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

	private $idSucursal;

    public function getIdSucursal() {
        return $this->idSucursal;
    }
    
    public function setIdSucursal($idSucursal) {
        $this->idSucursal = $idSucursal;
    }
	
	private $idCliente;

    public function getIdCliente() {
        return $this->idCliente;
    }
    
    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }
	
    private $numeroFolio;

    public function getNumeroFolio() {
        return $this->numeroFolio;
    }
    
    public function setNumeroFolio($numeroFolio) {
        $this->numeroFolio = $numeroFolio;
    }

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
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

	private $costoInicial;

    public function getCostoInicial() {
        return $this->costoInicial;
    }
    
    public function setCostoInicial($costoInicial) {
        $this->costoInicial = $costoInicial;
    }

    private $costoFinal;

    public function getCostoFinal() {
        return $this->costoFinal;
    }
    
    public function setCostoFinal($costoFinal) {
        $this->costoFinal = $costoFinal;
    }

       
    private $ganancia;

    public function getGanancia() {
        return $this->ganancia;
    }
    
    public function setGanancia($ganancia) {
        $this->ganancia = $ganancia;
    }
	
	public function __construct(array $datos)
	{
		if(array_key_exists("idProyecto", $datos)) $this->idProyecto = $datos["idProyecto"];
		if(array_key_exists("idSucursal", $datos)) $this->idSucursal = $datos["idSucursal"];
		if(array_key_exists("idCliente", $datos)) $this->idCliente = $datos["idCliente"];
		
		$this->numeroFolio = $datos["numeroFolio"];
		$this->descripcion = $datos["descripcion"];
		$this->fechaApertura = $datos["fechaApertura"];
		$this->fechaCierre = $datos["fechaCierre"];
		$this->costoInicial = $datos["costoInicial"];
		$this->costoFinal = $datos["costoFinal"];
		$this->ganancia = $datos["ganancia"];
	}

    public function toArray()
    {
        $datos = array();
		
		$datos["idProyecto"] = $this->idProyecto;
		$datos["idSucursal"] = $this->idSucursal;
		$datos["idCliente"] = $this->idCliente;
		$datos["numeroFolio"] = $this->numeroFolio;
		$datos["descripcion"] = $this->descripcion;
		$datos["fechaApertura"] = $this->fechaApertura;
		$datos["fechaCierre"] = $this->fechaCierre;
		$datos["costoInicial"] = $this->costoInicial;
		$datos["costoFinal"] = $this->costoFinal;
		$datos["ganancia"] = $this->ganancia;
		
		
		return $datos;
    }


}

