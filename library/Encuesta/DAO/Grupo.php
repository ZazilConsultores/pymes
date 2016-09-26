<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Grupo implements Encuesta_Interfaces_IGrupo {
	
	private $tablaSeccionEncuesta;
	private $tablaGrupoSeccion;
	private $tablaPregunta;
	private $tablaOpcionCategoria;
		
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodencuesta');
		
		$this->tablaSeccionEncuesta = new Encuesta_Model_DbTable_SeccionEncuesta(array('db'=>$dbAdapter));
		$this->tablaGrupoSeccion = new Encuesta_Model_DbTable_GrupoSeccion(array('db'=>$dbAdapter));
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta(array('db'=>$dbAdapter));
		$this->tablaOpcionCategoria = new Encuesta_Model_DbTable_OpcionCategoria(array('db'=>$dbAdapter));
	}
	// =====================================================================================>>>   Buscar
	/*
	public function obtenerGrupo($idGrupo) {
		$tablaGrupo = $this->tablaGrupoEncuesta;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo = ?", $idGrupo);
		$rowGrupo = $tablaGrupo->fetchRow($select);
		
		$modelGrupo = new Encuesta_Model_Grupo($rowGrupo->toArray());
		
		return $modelGrupo;
	}
	*/
	
	public function obtenerPreguntas($idGrupo) {
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "G")->where("idOrigen = ?", $idGrupo);
		$rowsPreguntas = $tablaPregunta->fetchAll($select);
		$modelPreguntas = array();
		
		if(!is_null($rowsPreguntas)){
			foreach ($rowsPreguntas as $row) {
				$modelPregunta = new Encuesta_Model_Pregunta($row->toArray());
				$modelPreguntas[] = $modelPregunta;
			}
		}
		
		return $modelPreguntas;
	}
	/**
	 * Un grupo con preguntas de simple seleccion comparte las mismas opciones 
	 */
	public function obtenerValorMayorOpcion($idGrupo){
		$tablaGrupo = $this->tablaGrupoEncuesta;
		$select = $tablaGrupo->select()->where("idGrupo=?",$idGrupo);
		$grupo = $tablaGrupo->fetchRow($select);
		$tablaOpcion = $this->tablaOpcionCategoria;
		$ids = explode(",", $grupo->opciones);
		$select = $tablaOpcion->select()->from($tablaOpcion,array("idOpcion", "valor"=>"MAX(valorEntero)"))->where("idOpcion IN (?)",$ids);
		
		$row = $tablaOpcion->fetchRow($select);
		return $row->toArray();
	}
	
	public function obtenerValorMenorOpcion($idGrupo){
		
	}
	
	// =====================================================================================>>>   Crear
	/*
	public function crearGrupo($idSeccion, Encuesta_Model_Grupo $grupo) {
		$tablaGrupo = $this->tablaGrupoEncuesta;
		$tablaSeccion = $this->tablaSeccionEncuesta;
		
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccionEncuesta = ?", $idSeccion);
		
		$seccion = $tablaSeccion->fetchRow($select);
		$seccion->elementos++;
		
		$grupo->setOrden($seccion->elementos);
		
		try{
			$tablaGrupo->insert($grupo->toArray());
			$seccion->save();
			return $modelGrupo->getIdGrupo();
		}catch(Exception $ex){
			throw new Exception($ex->getMessage(), 1);
		}
	}
	*/
	// =====================================================================================>>>   Editar
	/*
	public function editarGrupo($idGrupo, array $grupo) {
		$tablaGrupo = $this->tablaGrupoEncuesta;
		$where = $tablaGrupo->getAdapter()->quoteInto("idGrupo = ?", $idGrupo);
		
		$tablaGrupo->update($grupo, $where);
	}
	*/
	// =====================================================================================>>>   Eliminar
	/*
	public function eliminarGrupo($idGrupo) {
		$tablaGrupo = $this->tablaGrupoEncuesta;
		$where = $tablaGrupo->getAdapter()->quoteInto("idGrupoEncuesta = ?", $idGrupo);
		
		$tablaGrupo->delete($where);
	}
	*/
	public function eliminarPreguntas($idGrupo){
		$tablaPregunta = $this->tablaPregunta;
		$where = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "G")->where("idOrigen = ?", $idGrupo);
		
		$tablaPregunta->delete($where);
	}
	
	// **************************************************************************************** IMPLEMENTANDO ESTANDAR DE NOMBRES
	/**
	 * 
	 */
	public function getGruposByIdSeccion($idSeccion){
		
	}
	
	/**
	 * function getGrupoById($id) - 
	 * @param $id - El id de grupo a consultar
	 * @return $modelGrupo | null - El model o null conseguido de la base de datos
	 */
	public function getGrupoById($id){
		$tablaGrupo = $this->tablaGrupoEncuesta;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupoSeccion = ?", $idGrupo);
		$rowGrupo = $tablaGrupo->fetchRow($select);
		
		if(is_null($rowGrupo)){
			return null;
		}else{
			$modelGrupo = new Encuesta_Models_Grupo($rowGrupo->toArray());
			return $modelGrupo;
		}
	}
	
	/**
	 * 
	 */
	public function addGrupoToSeccion(Encuesta_Models_Grupo $grupo){
		
	}
	
	/**
	 * 
	 */
	public function editGrupo($id, array $datos){
		
	}
}
