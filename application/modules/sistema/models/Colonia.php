<?php

class Sistema_Model_Colonia
{
    private $idColonia;
    
    public function getIdColonia() {
        return $this->idColonia;
    }
        
    public function setIdColonia($idColonia) {
        $this->idColonia = $idColonia;
    }
        
    private $idMunicipio;
        
    public function getIdMunicipio() {
        return $this->idMunicipio;
    }
        
    public function setIdMunicipio($idMunicipio) {
        $this->idMunicipio = $idMunicipio;
    }
    
    private $colonia;
        
    public function getColonia() {
        return $this->colonia;
    }
        
    public function setColonia($colonia) {
        $this->colonia = $colonia;
    }
        
    private $CP;
        
    public function getCP() {
        return $this->CP;
    }
        
    public function setCP($CP) {
        $this->CP = $CP;
    }
        
    public function __construct(array $datos)
    {
        if(array_key_exists("idColonia", $datos)) $this->idColonia = $datos["idColonia"];
        if(array_key_exists("idMunicipio", $datos)) $this->idMunicipio = $datos["idMunicipio"];
        $this->colonia = $datos["colonia"];
        $this->CP = $datos["CP"];
    }
        
    public function toArray()
    {
        $datos = array();
        
        $datos["idColonia"] = $this->idColonia;
        $datos["idMunicipio"] = $this->idMunicipio;
        $datos["colonia"] = $this->colonia;
        $datos["cp"] = $this->cp;
            
        return $datos;
    }
        
}

