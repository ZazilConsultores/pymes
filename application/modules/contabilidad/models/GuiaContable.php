<?php

class Contabilidad_Model_GuiaContable
{
	private $idGuiaContable;

    public function getIdGuiaContable() {
        return $this->idGuiaContable;
    }
    
    public function setIdGuiaContable($idGuiaContable) {
        $this->idGuiaContable = $idGuiaContable;
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

    private $origen;

    public function getOrigen() {
        return $this->origen;
    }
    
    public function setOrigen($origen) {
        $this->origen = $origen;
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

    private $fechaCaptura;

    public function getFechaCaptura() {
        return $this->fechaCaptura;
    }
    
    public function setFechaCaptura($fechaCaptura) {
        $this->fechaCaptura = $fechaCaptura;
    }

    public function __construct(array $datos){
    	if(array_key_exists("idGuiaContable", $datos)) $this->idGuiaContable = $datos["idGuiaContable"];
		if(array_key_exists("idModulo", $datos)) $this->idModulo = $datos["idModulo"];
		if(array_key_exists("idTipoProveedor", $datos)) $this->idTipoProveedor = $datos["idTipoProveedor"];
		$this->cta = $datos["cta"];
		$this->sub1 = $datos["sub1"];
		$this->sub2 = $datos["sub2"];
		$this->sub3 = $datos["sub3"];
		$this->sub4 = $datos["sub4"];
		$this->sub5 = $datos["sub5"];
		$this->origen = $datos["origen"];
		$this->descripcion = $datos["descripcion"];
		$this->cargo = $datos["cargo"];
		$this->abono = $datos["abono"];
		$this->fechaCaptura = $datos["fechaCaptura"];		
    }
	
	public function toArray(){
		$datos = array();
		
		 $datos["idGuiaContable"] = $this->idGuiaContable;
		 $datos["idModulo"] = $this->idModulo;
		 $datos["idTipoProveedor"] = $this->idTipoProveedor;
		 $datos["cta"] = $this->cta;
		 $datos["sub1"] = $this->sub1;
		 $datos["sub2"] = $this->sub2;
		 $datos["sub3"] = $this->sub3;
		 $datos["sub4"] = $this->sub4;
		 $datos["sub5"] = $this->sub5;
		 $datos["origen"] = $this->origen;
		 $datos["descripcion"] = $this->descripcion;
		 $datos["cargo"] = $this->cargo;
		 $datos["abono"] = $this->abono;
		 $datos["fechaCaptura"] = $this->fechaCaptura;		
		return $datos;
	}

}

