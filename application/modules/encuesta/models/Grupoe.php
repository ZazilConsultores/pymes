<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Grupoe
{
	private $idGrupo;

    public function getIdGrupo() {
        return $this->idGrupo;
    }
    
    public function setIdGrupo($idGrupo) {
        $this->idGrupo = $idGrupo;
    }

    private $idGrado;

    public function getIdGrado() {
        return $this->idGrado;
    }
    
    public function setIdGrado($idGrado) {
        $this->idGrado = $idGrado;
    }

    private $idCiclo;

    public function getIdCiclo() {
        return $this->idCiclo;
    }
    
    public function setIdCiclo($idCiclo) {
        $this->idCiclo = $idCiclo;
    }

    private $grupo;

    public function getGrupo() {
        return $this->grupo;
    }
    
    public function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

    private $hash;

    public function getHash() {
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos)
    {
        if(array_key_exists("idGrupo", $datos)) $this->idGrupo = $datos["idGrupo"];
		if(array_key_exists("idGrado", $datos)) $this->idGrado = $datos["idGrado"];
		if(array_key_exists("idCiclo", $datos)) $this->idCiclo = $datos["idCiclo"];
		$this->grupo = $datos["grupo"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idGrupo"] = $this->idGrupo;
		$datos["idGrado"] = $this->idGrado;
		$datos["idCiclo"] = $this->idCiclo;
		$datos["grupo"] = $this->grupo;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

