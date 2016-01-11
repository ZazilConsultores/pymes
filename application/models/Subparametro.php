<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */

class Application_Model_Subparametro
{
	private $idSubparametro;

    public function getIdSubparametro() {
        return $this->idSubparametro;
    }
    
    public function setIdSubparametro($idSubparametro) {
        $this->idSubparametro = $idSubparametro;
    }
	
	private $idParametro;

    public function getIdParametro() {
        return $this->idParametro;
    }
    
    public function setIdParametro($idParametro) {
        $this->idParametro = $idParametro;
    }
	
	private $subParametro;

    public function getSubParametro() {
        return $this->subParametro;
    }
    
    public function setSubParametro($subParametro) {
        $this->subParametro = $subParametro;
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
    	$this->subParametro= $datos["subParametro"];
    	$this->descripcion = $datos["descripcion"];

    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idSubParametro"] = $this->idSubparametro;
		/*$datos["idParametro"] = $this->idParametro; */
		$datos["subParametro"] = $this->subParametro;
		$datos["descripcion"] = $this->descripcion;
		
		return $datos;
	}

}

