<?php
/**
 * 
 */
class Encuesta_Model_Materia
{
	private $idMateria;

    public function getIdMateria() {
        return $this->idMateria;
    }
    
    public function setIdMateria($idMateria) {
        $this->idMateria = $idMateria;
    }

    private $idCiclo;

    public function getIdCiclo() {
        return $this->idCiclo;
    }
    
    public function setIdCiclo($idCiclo) {
        $this->idCiclo = $idCiclo;
    }

    private $idGrado;

    public function getIdGrado() {
        return $this->idGrado;
    }
    
    public function setIdGrado($idGrado) {
        $this->idGrado = $idGrado;
    }

    private $materia;

    public function getMateria() {
        return $this->materia;
    }
    
    public function setMateria($materia) {
        $this->materia = $materia;
    }

    private $creditos;

    public function getCreditos() {
        return $this->creditos;
    }
    
    public function setCreditos($creditos) {
        $this->creditos = $creditos;
    }

    private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->hash = Util_Secure::generateKey(array("idCiclo"=>$this->idCiclo,"idGrado"=>$this->idGrado,"materia"=>strtolower($this->materia)));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos) {
		if(array_key_exists("idMateria", $datos)) $this->idMateria = $datos["idMateria"];
		if(array_key_exists("idCiclo", $datos)) $this->idCiclo = $datos["idCiclo"];
		if(array_key_exists("idGrado", $datos)) $this->idGrado = $datos["idGrado"];
		$this->materia = $datos["materia"];
		$this->creditos = $datos["creditos"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idMateria"] = $this->idMateria;
		$datos["idCiclo"] = $this->idCiclo;
		$datos["idGrado"] = $this->idGrado;
		$datos["materia"] = $this->materia;
		$datos["creditos"] = $this->creditos;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

