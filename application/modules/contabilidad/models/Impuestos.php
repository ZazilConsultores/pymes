<?php

class Contabilidad_Model_Impuestos
{
	private $idImpuestos;

    public function getIdImpuestos() {
        return $this->idImpuestos;
    }
    
    public function setIdImpuestos($idImpuestos) {
        $this->idImpuestos = $idImpuestos;
    }

 
    private $idTipoMovimiento;

    public function getIdTipoMovimiento() {
        return $this->idTipoMovimiento;
    }
    
    public function setIdTipoMovimiento($idTipoMovimiento) {
        $this->idTipoMovimiento = $idTipoMovimiento;
    }

    private $idFactura;

    public function getIdFactura() {
        return $this->idFactura;
    }
    
    public function setIdFactura($idFactura) {
        $this->idFactura = $idFactura;
    }

    	
	private $idProducto;

    public function getIdProducto() {
        return $this->idProducto;
    }
    
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
		
	private $abreviatura;

    public function getAbreviatura() {
        return $this->abreviatura;
    }
    
    public function setAbreviatura($abreviatura) {
        $this->abreviatura = $abreviatura;
    }
	
    /**/
    private $porcentaje;

    public function getPorcentaje() {
        return $this->porcentaje;
    }
    
    public function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }
	
    private $importe;

    public function getImporte() {
        return $this->importe;
    }
    
    public function setImporte($importe) {
        $this->importe = $importe;
    }

    

    
    public function __construct(array $datos){
    	if (array_key_exists("idImpuestos", $datos)) $this->idImpuestos = $datos["ïdImpuestos"];
		if (array_key_exists("idTipoMovimiento", $datos)) $this->idTipoMovimiento = $datos["ïdTipoMovimiento"];
		if (array_key_exists("idFactura", $datos)) $this->idSucursal = $datos["idFactura"];
    	if (array_key_exists("idProducto", $datos)) $this->idCoP = $datos["idProducto"];
		
		$this->descripcion = $datos["descripcion"];
		$this->abreviatura = $datos["abreviatura"];
		$this->porcentaje = $datos["porcentaje"];
		$this->importe = $datos["importe"];
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idImpuestos"] = $this->idImpuestos;
		$datos["idTipoMovimiento"] = $this->idTipoMovimiento;
		$datos["idFactura"] = $this->idFactura;
		$datos["idProducto"] = $this->idProducto;
		$datos["descripcion"] = $this->descripcion;
		$datos["abreviatura"] = $this->abreviatura;
		$datos["porcentaje"] = $this->porcentaje;
		$datos["importe"]=$this->importe;
		
		return $datos;		
		
	}


}

