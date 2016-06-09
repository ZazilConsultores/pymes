<?php

class Inventario_Model_Producto
{
	private $idProducto;

    public function getIdProducto() {
        return $this->idProducto;
    }
    
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }
	
	private $producto;

    public function getProducto() {
        return $this->producto;
    }
    
    public function setProducto($producto) {
        $this->producto = $producto;
    }

    private $claveProducto;

    public function getClaveProducto() {
        return $this->claveProducto;
    }
    
    public function setClaveProducto($claveProducto) {
        $this->claveProducto = $claveProducto;
    }

    private $codigoBarras;

    public function getCodigoBarras() {
        return $this->codigoBarras;
    }
    
    public function setCodigoBarras($codigoBarras) {
        $this->codigoBarras = $codigoBarras;
    }
	
	private $idsSubparametros;

    public function getIdsSubparametros() {
        return $this->idsSubparametro;
    }
    
    public function setIdsSubparametros($idsSubparametro) {
        $this->idsSubparametro = $idsSubparametro;
    }
	
	public function __construct(array $datos)
	{
		if(array_key_exists("idProducto", $datos)) $this->idProducto = $datos["idProducto"];
	
		$this->producto = $datos["producto"];
		$this->claveProducto = $datos["claveProducto"];
		$this->codigoBarras = $datos["codigoBarras"];
		$this->idsSubparametros = $datos["idsSubparametros"];

	}
	
	public function toArray()
	{
		$datos = Array();
		
		$datos["idProducto"] = $this->idProducto;
		$datos["producto"] = $this->producto;
		$datos["claveProducto"] = $this->claveProducto;
		$datos["codigoBarras"] = $this->codigoBarras;
		$datos["idsSubparametros"]=$this->idsSubparametros;
		
		return $datos;
			 
	}
}

