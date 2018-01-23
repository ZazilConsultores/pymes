<?php

class Contabilidad_Model_Impuesto
{
	private $idImpuesto;

    public function getIdImpuesto() {
        return $this->idImpuesto;
    }
    
    public function setIdImpuesto($idImpuesto) {
        $this->idImpuesto = $idImpuesto;
    }
	
	private $abreviatura;

    public function getAbreviatura() {
        return $this->abreviatura;
    }
    
    public function setAbreviatura($abreviatura) {
        $this->abreviatura = $abreviatura;
    }

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
	
    private $estatus;

    public function getEstatus() {
        return $this->estatus;
    }
    
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }
    
    private $sat3;
    
    
    public function getSat3() {
        return $this->sat3;
    }
    
    public function setSat3($sat3) {
        $this->sat3 = $sat3;
    }

   
    private $fechaPublicacion;

    public function getFechaPublicacion() {
        return $this->fechaPublicacion;
    }
    
    public function setFechaPublicacion($fechaPublicacion) {
        $this->fechaPublicacion = $fechaPublicacion;
    }
    
    public function __construct(array $datos){
    	if (array_key_exists("idImpuesto", $datos)) $this->idImpuesto = $datos["idImpuesto"];
		if (array_key_exists("abrevitura", $datos)) $this->abreviatura = $datos["abrevitura"];
    	$this->abreviatura = $datos["abreviatura"];
		$this->descripcion = $datos["descripcion"];
		
		if(array_key_exists("estatus", $datos)) $this->estatus = $datos["estatus"];
		$this->sat3 = $datos["sat3"];
		if(array_key_exists("fechaPublicacion", $datos)) $this->fechaPublicacion = $datos["fechaPublicacion"];
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idImpuesto"] = $this->idImpuesto;
		$datos["abreviatura"] = $this->abreviatura;
		$datos["descripcion"] = $this->descripcion;	
		$datos["estatus"] = $this->estatus;
		$datos["sat3"] = $this->sat3;
		$datos["fechaPublicacion"]=$this->fechaPublicacion;
		
		return $datos;		
		
	}

}

