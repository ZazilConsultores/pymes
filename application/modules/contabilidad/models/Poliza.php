<?php

class Contabilidad_Model_Poliza
{
	protected $_name = 'Poliza';
	
	private $idPoliza;

    public function getIdPoliza() {
        return $this->idPoliza;
    }
    
    public function setIdPoliza($idPoliza) {
        $this->idPoliza = $idPoliza;
    }

    private $idModulo;

    public function getIdModulo() {
        return $this->idModulo;
    }
    
    public function setIdModulo($idModulo) {
        $this->idModulo = $idModulo;
    }

    private $idTipoProveedor;

    public function getIdTipoProveedor() {
        return $this->idTipoProveedor;
    }
    
    public function setIdTipoProveedor($idTipoProveedor) {
        $this->idTipoProveedor = $idTipoProveedor;
    }

    private $idSucursal;

    public function getIdSucursal() {
        return $this->idSucursal;
    }
    
    public function setIdSucursal($idSucursal) {
        $this->idSucursal = $idSucursal;
    }

    private $idCoP;

    public function getIdCoP() {
        return $this->idCoP;
    }
    
    public function setIdCoP($idCoP) {
        $this->idCoP = $idCoP;
    }

    private $cta;

    public function getCta() {
        return $this->cta;
    }
    
    public function setCta($cta) {
        $this->cta = $cta;
    }

    private $sub1;

    public function getSub1() {
        return $this->sub1;
    }
    
    public function setSub1($sub1) {
        $this->sub1 = $sub1;
    }

	private $sub2;

    public function getSub2() {
        return $this->sub2;
    }
    
    public function setSub2($sub2) {
        $this->sub2 = $sub2;
    }

    private $sub3;

    public function getSub3() {
        return $this->sub3;
    }
    
    public function setSub3($sub3) {
        $this->sub3 = $sub3;
    }

    private $sub4;

    public function getSub4() {
        return $this->sub4;
    }
    
    public function setSub4($sub4) {
        $this->sub4 = $sub4;
    }

	private $sub5;

    public function getSub5() {
        return $this->sub5;
    }
    
    public function setSub5($sub5) {
        $this->sub5 = $sub5;
    }

    private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    private $cargo;

    public function getCargo() {
        return $this->cargo;
    }
    
    public function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    private $abono;

    public function getAbono() {
        return $this->abono;
    }
    
    public function setAbono($abono) {
        $this->abono = $abono;
    }

    private $numDocto;

    public function getNumDocto() {
        return $this->numDocto;
    }
    
    public function setNumDocto($numDocto) {
        $this->numDocto = $numDocto;
    }

    private $secuencial;

    public function getSecuencial() {
        return $this->secuencial;
    }
    
    public function setSecuencial($secuencial) {
        $this->secuencial = $secuencial;
    }
	
	public function __construct(array $datos)
	{
		if(array_key_exists("idPoliza", $datos)) $this->idPoliza = $datos["idPoliza"];
		if(array_key_exists("idModulo", $datos)) $this->idModulo = $datos["idModulo"];
		if(array_key_exists("idTipoProveedor", $datos)) $this->idTipoProveedor = $datos["idTipoProveedor"];
		if(array_key_exists("idSucursal", $datos)) $this->idSucursal = $datos["idSucursals"];
		if(array_key_exists("idCoP", $datos)) $this->idCoP = $datos["idCoP"];
		$this->cta = $datos["cta"];
		$this->sub1 = $datos["sub1"];
		$this->sub2 = $datos["sub2"];
		$this->sub3 = $datos["sub3"];
		$this->sub4 = $datos["sub4"];
		$this->sub5 = $datos["sub5"];
		$this->fecha = $datos["fecha"];
		$this->descripcion = $datos["descripcion"];
		$this->cargo = $datos["cargo"];
		$this->abono = $datos["abono"];
		$this->numDocto = $datos["numDocto"];
		$this->secuencial = $datos["secuencial"];
		
		$this->ganancia = $datos["ganancia"];
	}

    public function toArray()
    {
        $datos = array();
		
		$datos["idPoliza"] = $this->idPoliza;
		$datos["idModulo"] = $this->idModulo;
		$datos["idTipoProveedor"] = $this->idTipoProveedor;
		$datos["idSucursal"] = $this->idSucursal;
		$datos["idCoP"] = $this->idCoP;
		$datos["cta"] = $this->cta;
		$datos["sub1"] = $this->sub1;
		$datos["sub2"] = $this->sub2;
		$datos["sub3"] = $this->sub3;
		$datos["sub4"] = $this->sub4;
		$datos["sub5"] = $this->sub5;
		$datos["fecha"] = $this->fecha;
		$datos["descripcion"] = $this->descripcion;
		$datos["cargo"] = $this->cargo;
		$datos["abono"] = $this->abono;
		$datos["numDocto"] = $this->numDocto;
		$datos["secuencial"] = $this->secuencial;
		
		return $datos;
    }

    

}

