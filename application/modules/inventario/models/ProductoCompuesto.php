<?php

class Inventario_Model_ProductoCompuesto
{
	private $idProductoCompuesto;

    public function getIdProductoCompuesto() {
        return $this->idProductoCompuesto;
    }

    public function setIdProductoCompuesto($idProductoCompuesto) {
        $this->idProductoCompuesto = $idProductoCompuesto;
    }
	
	
	private $idProducto;

    public function getIdProducto() {
        return $this->idProducto;
    }
    
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }
	
	
	private $productoEnlazado;

    public function getProductoEnlazado() {
        return $this->productoEnlazado;
    }
    
    public function setProductoEnlazado($productoEnlazado) {
        $this->productoEnlazado = $productoEnlazado;
    }

	private $cantidad;

    public function getCantidad() {
        return $this->cantidad;
    }
    
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
	
	private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
	
	private $presentacion;

    public function getPresentacion() {
        return $this->presentacion;
    }
    
    public function setPresentacion($presentacion) {
        $this->presentacion = $presentacion;
    }
	
	private $costoUnitario;

    public function getCostoUnitario() {
        return $this->costoUnitario;
    }
    
    public function setCostoUnitario($costoUnitario) {
        $this->costoUnitario = $costoUnitario;
    }

	public function __construct(array $datos) {
	   	
	    if(array_key_exists("idProductoCompuesto", $datos)) $this->idProductoCompuesto = $datos["idProductoCompuesto"];
		if(array_key_exists("idProducto", $datos)) $this->idProducto = $datos["idProducto"];
		if(array_key_exists("productoEnlazado", $datos)) $this->productoEnlazado = $datos["productoEnlazado"];
		
		$this->cantidad = $datos["cantidad"];
		$this->descripcion = $datos["descripcion"];
		$this->presentacion = $datos["presentacion"];
		$this->costoUnitario = $datos["costoUnitario"];
	
    }
	
	public function toArray() {
		$datos = array();
		$datos["idProductoCompuesto"] = $this->idProductoCompuesto;
		$datos["idProducto"] = $this->idProducto;
		$datos["productoEnlazado"] = $this->productoEnlazado;
		$datos["cantidad"] = $this->cantidad;
		$datos["descripcion"] = $this->descripcion;
		$datos["presentacion"] = $this->presentacion;
		$datos["costoUnitario"] = $this->costoUnitario;
		
		return $datos;
	}


}

