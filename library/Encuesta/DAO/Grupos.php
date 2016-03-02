<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Grupos implements Encuesta_Interfaces_IGrupos {
	
	private $tablaGrupo;
	private $tablaCiclo;
	
	function __construct() {
		$this->tablaGrupo = new Encuesta_Model_DbTable_GrupoE;
		$this->tablaCiclo = new Encuesta_Model_DbTable_CicloE;
	}
	
	public function obtenerGrupos($idGrado,$idCiclo){
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrado = ?",$idGrado)->where("idCiclo = ?",$idCiclo);
		$grupos = $tablaGrupo->fetchAll($select);
		
		$modelGrupos = array();
		
		foreach ($grupos as $grupo) {
			$modelGrupo = new Encuesta_Model_Grupoe($grupo->toArray());
			$modelGrupos[] = $modelGrupo;
		}
		
		return $modelGrupos;
	}
	
	public function obtenerGrupo($idGrupo){
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo = ?",$idGrupo);
		$rowGrupo = $tablaGrupo->fetchRow($select);
		
		$modelGrupo = new Encuesta_Model_Grupoe($rowGrupo->toArray());
		
		return $modelGrupo;
	}
	
	public function crearGrupo($idGrado,$idCiclo,Encuesta_Model_Grupoe $grupo){
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrado = ?",$idGrado)->where("idCiclo = ?",$idCiclo)->where("grupo = ?",$grupo->getGrupo());
		$grupoe = $tablaGrupo->fetchRow($select);
		
		$grupo->setIdCiclo($idCiclo);
		$grupo->setIdGrado($idGrado);
		$grupo->setHash($grupo->getHash());
		
		if(!is_null($grupoe))throw new Util_Exception_BussinessException("Error Grupo: <strong>".$grupo->getGrupo()."</strong> duplicado en el sistema");
		
		try{
			$tablaGrupo->insert($grupo->toArray());
		}catch(Exception $ex){
			throw new Util_Exception_BussinessException("Error al Insertar el Grupo: " . $grupo->getGrupo());			
		}
		
	}
	
}
