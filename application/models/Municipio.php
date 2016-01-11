<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Municipio
{
	private $idMunicipio;

    public function getIdMunicipio() {
        return $this->idMunicipio;
    }
    
    public function setIdMunicipio($idMunicipio) {
        $this->idMunicipio = $idMunicipio;
    }

	/*private $idEstado;

    public function getIdEstado() {
        return $this->idEstado;
    }
    
    public function setIdEstado($idEstado) {
        $this->idEstado = $idEstado;
    }*/
    
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
        $this->claveMunicipio = $datos["claveMunicipio"];
		$this->estado = $datos["municipio"];
	
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idMunicipio"] = $this->idMunicipio;
		$datos["claveMunicipio"] = $this->claveMunicipio; 
		$datos["municipio"] = $this->municipio;
				
		return $datos;
	}
	

 
}

