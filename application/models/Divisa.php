<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Divisa
{
	private $idDivisa;

    public function getIdDivisa() {
        return $this->idDivisa;
    }
    
    public function setIdDivisa($idDivisa) {
        $this->idDivisa = $idDivisa;
    }

    private $divisa;

    public function getDivisa() {
        return $this->divisa;
    }
    
    public function setDivisa($divisa) {
        $this->divisa = $divisa;
    }

    private $claveDivisa;

    public function getClaveDivisa() {
        return $this->claveDivisa;
    }
    
    public function setClaveDivisa($claveDivisa) {
        $this->claveDivisa = $claveDivisa;
    }

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    private $tipoCambio;

    public function getTipoCambio() {
        return $this->tipoCambio;
    }
    
    public function setTipoCambio($tipoCambio) {
        $this->tipoCambio = $tipoCambio;
    }

    public function __construct(array $datos)
    {
        $this->divisa = $datos["divisa"];
		$this->claveDivisa = $datos["claveDivisa"];
		$this->descripcion = $datos["descripcion"];
		$this->tipoCambio = $datos["tipoCambio"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idDivisa"] = $this->idDivisa;
		$datos["divisa"] = $this->divisa;
		$datos["claveDivisa"] = $this->claveDivisa;
		$datos["descripcion"] = $this->descripcion;
		$datos["tipoCambio"] = $this->tipoCambio;
		
		return $datos;
	}

}

