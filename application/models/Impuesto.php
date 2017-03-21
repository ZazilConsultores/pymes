<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Impuesto
{
	private $idImpuesto;

    public function getIdImpuesto() {
        return $this->idImpuesto;
    }
    
    public function setIdImpuesto($idImpuesto) {
        $this->idImpuesto = $idImpuesto;
    }

    private $impuesto;

    public function getImpuesto() {
        return $this->impuesto;
    }
    
    public function setImpuesto($impuesto) {
        $this->impuesto = $impuesto;
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
	
	private $porcentaje;

    public function getPorcentaje() {
        return $this->porcentaje;
    }
    
    public function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }
	
	private $estatus;

    public function getEstatus() {
        return $this->estatus;
    }
    
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }
	
	private $fechaPublicacion;

    public function getFechaPublicacion() {
        return $this->fechaPublicacion;
    }
    
    public function setFechaPublicacion($fechaPublicacion) {
        $this->fechaPublicacion = $fechaPublicacion;
    }
	
	public function __construct(array $datos)
    {
    	$this->impuesto= $datos["impuesto"];
    	$this->abreviatura = $datos["abreviatura"];
		$this->descripcion = $datos["descripcion"];
		$this->porcentaje = $datos["porcentaje"];
		$this->estatus = $datos["estatus"];
	    $this->fechaPublicacion= $datos["fechaPublicacion"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idImpuesto"] = $this->idImpuesto;
		$datos["impuesto"] = $this->impuesto; 
		$datos["abreviatura"] = $this->abreviatura;
		$datos["descripcion"] = $this->descripcion;
		$datos["porcentaje"] = $this->porcentaje;
		$datos["estatus"] = $this->estatus;
		$datos["fechaPublicacion"] = $this->fechaPublicacion;
		
		return $datos;
	}
	

}

