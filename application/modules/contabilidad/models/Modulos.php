<?php

class Contabilidad_Model_Modulos
{
	protected $_name = 'Modulos';
	
	private $idModulo;
    public function getIdModulo() {
        return $this->idModulo;
    }
    
    public function setIdModulod($idModulo) {
        $this->idModulo = $idModulo;
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
		if(array_key_exists("idModulo", $datos)) $this->idModulo = $datos["idModulo"];
		$this->descripcion = $datos["descripcion"];
	}

    public function toArray()
    {
        $datos = array();
		
		$datos["idModulo"] = $this->idModulo;
		$datos["descripcion"] = $this->descripcion;
		return $datos;
    }
	

    
}

