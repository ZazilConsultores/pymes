<?php

class Application_Model_TipoProveedor
{
	private $idTipoProveedor;

    public function getIdTipoProveedor() {
        return $this->idTipoProveedor;
    }
    
    public function setIdTipoProveedor($idTipoProveedor) {
        $this->idTipoProveedor = $idTipoProveedor;
    }
	
	private $clave;

    public function getClave() {
        return $this->clave;
    }
    
    public function setClave($clave) {
        $this->clave = $clave;
    }

    
	private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

public function __construct(array $datos)
    {
    	$this->clave= $datos["clave"];
    	$this->descripcion = $datos["descripcion"];
		
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idTipoProveedor"] = $this->idTipoProveedor;
		$datos["clave"] = $this->clave; 
		$datos["descripcion"] = $this->descripcion;
		
		return $datos;
	}

}

