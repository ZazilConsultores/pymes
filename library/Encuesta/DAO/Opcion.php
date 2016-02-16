<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Opcion implements Encuesta_Interfaces_IOpcion {
	
	private $tablaCategoria;
	private $tablaOpcion;
	private $tablaPregunta;
	private $tablaGrupo;
	
	public function __construct() {
		$this->tablaCategoria = new Encuesta_Model_DbTable_Categoria;
		$this->tablaOpcion = new Encuesta_Model_DbTable_Opcion;
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
		$this->tablaGrupo = new Encuesta_Model_DbTable_Grupo;
	}
	
	// =====================================================================================>>>   Buscar
	public function obtenerOpcion($idOpcion){
		$tablaOpcion = $this->tablaOpcion;
		$select = $tablaOpcion->select()->from($tablaOpcion)->where("idOpcion = ?", $idOpcion);
		$rowOpcion = $tablaOpcion->fetchRow($select);
		
		$modelOpcion = new Encuesta_Model_Opcion($rowOpcion->toArray());
		
		return $modelOpcion;
	}
	
	public function obtenerOpcionHash($hash){
		$tablaOpcion = $this->tablaOpcion;
		$select = $tablaOpcion->select()->from($tablaOpcion)->where("hash = ?", $hash);
		$rowOpcion = $tablaOpcion->fetchRow($select);
		
		$modelOpcion = new Encuesta_Model_Opcion($rowOpcion->toArray());
		
		return $modelOpcion;
	}
	
	public function obtenerOpcionesCategoria($idCategoria) {
		$tablaOpcion = $this->tablaOpcion;
		$select = $tablaOpcion->select()->from($tablaOpcion)->where("idCategoria = ?", $idCategoria);
		$rowsCategoria = $tablaOpcion->fetchAll($tablaOpcion);
		$modelOpciones = array();
		
		if(!is_null($rowsCategoria)){
			foreach ($rowsCategoria as $row) {
				$modelOpcion = new Encuesta_Model_Opcion($row->toArray());
				$modelOpciones[] = $modelOpcion;
			}
		}
		
		return $modelOpciones;
	}
	
	public function obtenerOpcionesPregunta($idPregunta){
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("idPregunta = ?", $idPregunta);
		$rowOpciones = $tablaPregunta->fetchRow($select);
		$modelOpciones = array();
		//Si no es nulo traemos las opciones
		if(!is_null($rowOpciones)){
			$opciones = explode(",", $rowOpciones->opciones);
			
			foreach ($opciones as $opcion) {
				$modelOpcion = $this->obtenerOpcion($opcion);
				$modelOpciones[] = $modelOpcion;
			}
		}
		
		return $modelOpciones;
	}
	
	public function obtenerOpcionesGrupo($idGrupo){
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo = ?", $idGrupo);
		$rowGrupo = $tablaGrupo->fetchRow($select);
		$opciones = explode(",", $rowGrupo->opciones);
		$modelOpciones = array();
		
		foreach ($opciones as $opcion) {
			$modelOpcion = $this->obtenerOpcion($opcion);
			$modelOpciones[] = $modelOpcion;
		}
		
		return $modelOpciones;
	}
	// =====================================================================================>>>   Insertar
	public function crearOpcion($idCategoria, Encuesta_Model_Opcion $opcion){
		$tablaOpcion = $this->tablaOpcion;
		$select = $tablaOpcion->select()->from($tablaOpcion)->where("idCategoria = ?", $idCategoria);
		$orden = count($tablaOpcion->fetchAll($select));
		$orden++;
		$opcion->setOrden($orden);
		$opcion->setHash($opcion->getHash());
		$opcion->setFecha(date("Y-m-d H:i:s", time()));
		//print_r($opcion->toArray());
		$tablaOpcion->insert($opcion->toArray());
	}
	
	// =====================================================================================>>>   Actualizar
	public function editarOpcion($idOpcion, array $opcion){
		$tablaOpcion = $this->tablaOpcion;
		$where = $tablaOpcion->getAdapter()->quoteInto("idOpcion", $idOpcion);
		
		$tablaOpcion->update($opcion, $where);
	}
	
	// =====================================================================================>>>   Eliminar
	public function eliminarOpcion($idOpcion){
		$tablaOpcion = $this->tablaOpcion;
		$where = $tablaOpcion->getAdapter()->quoteInto("idOpcion", $idOpcion);
		
		$tablaOpcion->update($opcion->toArray(), $where);
	}
	// =====================================================================================>>>   Asociar
	public function asociarOpcionesPregunta($idPregunta, array $opciones){
		$tablaPregunta = $this->tablaPregunta;
		$where = $tablaPregunta->getAdapter()->quoteInto("idPregunta = ?", $idPregunta);
		
		$vector = implode(",", $opciones);
		
		$data = array();
		$data["opciones"] = $vector;
		
		$tablaPregunta->update($data, $where);
	}
	
	public function asociarOpcionesGrupo($idGrupo, array $opciones) {
		$tablaGrupo = $this->tablaGrupo;
		$where = $tablaGrupo->getAdapter()->quoteInto("idGrupo = ?", $idGrupo);
		$vector = implode(",", $opciones);
		
		$data = array();
		$data["opciones"] = $vector;
		
		$tablaGrupo->update($data, $where);
	}
}
