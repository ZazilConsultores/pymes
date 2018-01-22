<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_Model_Municipio
{
	private $idMunicipio;

    public function getIdMunicipio() {
        return $this->idMunicipio;
    }
    
    public function setIdMunicipio($idMunicipio) {
        $this->idMunicipio = $idMunicipio;
    }

    private $idEstado;

    public function getIdEstado() {
        return $this->idEstado;
    }
    
    public function setIdEstado($idEstado) {
        $this->idEstado = $idEstado;
    }
    private $claveMunicipio;
    
    public function getClaveMunicipio() {
        return $this->claveMunicipio;
    }
    
    public function setClaveMunicipio($claveMunicipio) {
        $this->claveMunicipio = $claveMunicipio;
    }

    private $municipio;

    public function getMunicipio() {
        return $this->municipio;
    }
    
    public function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }
    
    public function __construct(array $datos)
    {
    	if(array_key_exists("idMunicipio", $datos)) $this->idMunicipio = $datos["idMunicipio"];
		if(array_key_exists("idEstado", $datos)) $this->idEstado = $datos["idEstado"];
		$this->claveMunicipio = $datos["claveMunicipio"];
        $this->municipio = $datos["municipio"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idMunicipio"] = $this->idMunicipio;
		$datos["idEstado"] = $this->idEstado; 
		$datos["claveMunicipio"] = $this->claveMunicipio; 
		$datos["municipio"] = $this->municipio;
				
		return $datos;
	}

}

