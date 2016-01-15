<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Opcion implements Encuesta_Interfaces_IOpcion {
	
	private $tablaCategoria;
	private $tablaOpcion;
	private $tablaOpcionesPregunta;
	
	public function __construct() {
		$this->tablaCategoria = new Encuesta_Model_DbTable_Categoria;
		$this->tablaOpcion = new Encuesta_Model_DbTable_Opcion;
		$this->tablaOpcionesPregunta = new Encuesta_Model_DbTable_OpcionesPregunta;
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
	
	public function obtenerOpcionesCategoria($idCategoria)
	{
		
	}
	
	public function obtenerOpcionesPregunta($idPregunta){
		$tablaOpciones = $this->tablaOpcionesPregunta;
		$select = $tablaOpciones->select()->from($tablaOpciones)->where("idPregunta = ?", $idPregunta);
		$rowOpciones = $tablaOpciones->fetchRow($select);
		
		$objOpciones = explode(",", $rowOpciones->opciones);
		$modelOpciones = array();
		
		foreach ($objOpciones as $idOpcion) {
			$modelOpcion = $this->obtenerOpcion($idOpcion);
			$modelOpciones[] = $modelOpcion;
		}
		
		/*
		$modelOpciones = array();
		
		foreach ($rowsOpciones as $rowOpcion) {
			$modelOpcion = new Encuesta_Model_Opcion($rowOpcion->toArray());
			
			$modelOpciones[] = $modelOpcion;
		}
		*/
		return $modelOpciones;
	}
	
	// =====================================================================================>>>   Insertar
	public function crearOpcion(Encuesta_Model_Opcion $opcion){
		$tablaOpcion = $this->tablaOpcion;
		$select = $tablaOpcion->select()->from($tablaOpcion)->where("idCategoria = ?", $opcion->getIdCategoria());
		$numero = count($tablaOpcion->fetchAll($select));
		$numero++;
		$opcion->setOrden($numero);
		
		$tablaOpcion->insert($opcion->toArray());
	}
	
	// =====================================================================================>>>   Actualizar
	public function editarOpcion($idOpcion, Encuesta_Model_Opcion $opcion){
		$tablaOpcion = $this->tablaOpcion;
		$where = $tablaOpcion->getAdapter()->quoteInto("idOpcion", $idOpcion);
		
		$tablaOpcion->update($opcion->toArray(), $where);
	}
	
	// =====================================================================================>>>   Eliminar
	public function eliminarOpcion($idOpcion){
		$tablaOpcion = $this->tablaOpcion;
		$where = $tablaOpcion->getAdapter()->quoteInto("idOpcion", $idOpcion);
		
		$tablaOpcion->update($opcion->toArray(), $where);
	}
}
