<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Grupos implements Encuesta_Interfaces_IGrupos {
	
	private $tablaGrupo;
	private $tablaProfesoresGrupo;
	private $tablaCiclo;
	private $tablaAsignacionGrupo;
	
	function __construct() {
		$this->tablaGrupo = new Encuesta_Model_DbTable_GrupoE;
		$this->tablaCiclo = new Encuesta_Model_DbTable_CicloE;
		$this->tablaProfesoresGrupo = new Encuesta_Model_DbTable_ProfesoresGrupo;
		$this->tablaAsignacionGrupo = new Encuesta_Model_DbTable_AsignacionGrupo;
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
	
	public function obtenerAsignacion($idAsignacion){
		$tablaAsignacion = $this->tablaAsignacionGrupo;
		$select = $tablaAsignacion->select()->from($tablaAsignacion)->where("idAsignacion=?",$idAsignacion);
		$asignacion = $tablaAsignacion->fetchRow($select);
		if(is_null($asignacion)) throw new Util_Exception_BussinessException("Error: No hay asignacion de Docente-Materia con el id:<strong>".$idAsignacion."</strong>", 1);
		
		return $asignacion->toArray();
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
	
	public function obtenerDocentes($idGrupo){
		//$tablaProfesoresGrupo = $this->tablaProfesoresGrupo;
		$tablaAsignacion = $this->tablaAsignacionGrupo;
		$select = $tablaAsignacion->select()->from($tablaAsignacion)->where("idGrupo=?",$idGrupo);
		$profesores = $tablaAsignacion->fetchAll($select);
		$profesoresGrupo = array();
		
		if(!is_null($profesores)){
			$materiaDAO = new Encuesta_DAO_Materia;
			$registroDAO = new Encuesta_DAO_Registro;
			
			foreach ($profesores as $profesor) {
				$obj = $profesor->toArray();
				$obj["materia"] = $materiaDAO->obtenerMateria($obj["idMateria"]); //Objeto Encuesta_Model_Materia;
				$obj["profesor"] = $registroDAO->obtenerRegistro($profesor->idRegistro); //Objeto Encuesta_Model_Profesor
				
				$profesoresGrupo[$obj["idMateria"]] = $obj;
			}
		}
		
		
		return $profesoresGrupo;
	}
	
	public function agregarDocenteGrupo(array $registro){
		$tablaAsignacion = $this->tablaAsignacionGrupo;
		//Si ya hay un registro de esta materia
		$select = $tablaAsignacion->select()->from($tablaAsignacion)->where("idGrupo=?",$registro["idGrupo"])->where("idMateria=?",$registro["idMateria"]);
		$row = $tablaAsignacion->fetchRow($select);
		
		if(!is_null($row)){
			throw new Util_Exception_BussinessException("Error: <strong>Docente</strong> ya registrado en la <strong>Materia</strong> seleccionada");
		}else{
			try{
				$tablaAsignacion->insert($registro);
			}catch(Exception $ex){
				throw new Util_Exception_BussinessException("Error: <strong>". $ex->getMessage()."</strong>");
				
			}
			
		}
	}
	
}
