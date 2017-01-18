<?php

class Contabilidad_Model_ImpuestoProductos
{
	private $idImpuestoProducto;

    public function getIdImpuestoProducto() {
        return $this->idImpuestoProducto;
    }
    
    public function setIdImpuestoProducto($idImpuestoProducto) {
        $this->idImpuestoProducto = $idImpuestoProducto;
    }

    private $idImpuesto;

    public function getIdImpuesto() {
        return $this->idImpuesto;
    }
    
    public function setIdImpuesto($idImpuesto) {
        $this->idImpuesto = $idImpuesto;
    }

    private $idProducto;

    public function getIdProducto() {
        return $this->idProducto;
    }
    
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    private $importe;

    public function getImporte() {
        return $this->importe;
    }
    
    public function setImporte($importe) {
        $this->importe = $importe;
    }

    private $porcentaje;

    public function getPorcentaje() {
        return $this->porcentaje;
    }
    
    public function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }

    public function __construct(array $datos){
  
    	if (array_key_exists("idImpuestoProducto", $datos)) $this->idImpuestoProducto = $datos["idImpuestoProducto"];
		if (array_key_exists("idImpuesto", $datos)) $this->idImpuesto = $datos["idImpuesto"];
		if (array_key_exists("idProducto", $datos)) $this->idProducto = $datos["idProducto"];
		$this->importe = $datos["importe"];
		$this->porcentaje = $datos["porcentaje"];
    }
	
	public function toArray(){
		$datos = array();
		$datos["idImpuestoProducto"] = $this->idImpuestoProducto;
		$datos["idImpuesto"] = $this->idImpuesto;
		$datos["idProducto"] = $this->idProducto;
		$datos["importe"] = $this->importe;
		$datos["porcentaje"] = $this->porcentaje;
		return $datos;
	}
}

