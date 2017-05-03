<?php

class Contabilidad_Model_BancosEmpresa 
{
	private $idEmpresa;

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
    
    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    private $idBanco;

    public function getIdBanco() {
        return $this->idBanco;
    }
    
    public function setIdBanco($idBanco) {
        $this->idBanco = $idBanco;
    }
    	
	public function __construct(array $datos)
	{
		if(array_key_exists("idEmpresa", $datos)) $this->idEmpresa = $datos["idEmpresa"];
		if(array_key_exists("idBanco", $datos)) $this->idBanco = $datos["idBanco"];
	}

    public function toArray()
    {
        $datos = array();
	
		$datos["idEmpresa"] = $this->idEmpresa;
		$datos["idBanco"] = $this->idBanco;
		
		
		return $datos;
    }

    

   

}

