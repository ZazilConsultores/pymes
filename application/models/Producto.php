<?php
/*
 @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */

class Application_Model_Producto
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
	
	public function __construct(array $datos)
    {
    	$this->producto= $datos["producto"];
    	$this->claveProducto = $datos["claveProducto"];
		$this->codigoBarras = $datos["codigoBarras"];
		

    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idProducto"] = $this->idProducto;
		$datos["producto"] = $this->producto;
		$datos["claveProducto"] = $this->claveProducto; 
		$datos["odigoBarras"] = $this->codigoBarras;
	
		return $datos;
	}


}

