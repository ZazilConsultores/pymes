<?php
/*
 @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Parametro
{
	private $idParametro;

    public function getIdParametro() {
        return $this->idParametro;
    }
    
    public function setIdParametro($idParametro) {
        $this->idParametro = $idParametro;
    }
	
	/*private $idEmpresas;

    public function getIdEmpresas() {
        return $this->idEmpresas;
    }
    
    public function setIdEmpresas($idEmpresas) {
        $this->idEmpresas = $idEmpresas;
    }*/
	private $parametro;

    public function getParametro() {
        return $this->parametro;
    }
    
    public function setParametro($parametro) {
        $this->parametro = $parametro;
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
    	$this->parametro= $datos["parametro"];
    	$this->descripcion = $datos["descripcion"];

    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idParametro"] = $this->idParametro;
		$datos["parametro"] = $this->parametro; 
		$datos["descripcion"] = $this->descripcion;
	
		return $datos;
	}


}

