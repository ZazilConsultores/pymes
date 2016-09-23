<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Categoria implements Encuesta_Interfaces_ICategoria {
	
	private $tablaCategoria;
	private $tablaOpcion;
	
	function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodencuesta');
		
		$this->tablaCategoria = new Encuesta_Model_DbTable_CategoriasRespuesta(array('db'=>$dbAdapter));
		
		$this->tablaOpcion = new Encuesta_Model_DbTable_OpcionCategoria(array('db'=>$dbAdapter));
		
	}
	
	// =====================================================================================>>>   Buscar
	public function obtenerCategoria($idCategoria){
		$tablaCategoria = $this->tablaCategoria;
		$select = $tablaCategoria->select()->from($tablaCategoria)->where("idCategoria = ?", $idCategoria);
		$rowCategoria = $tablaCategoria->fetchRow($select);
		
		$modelCategoria = new Encuesta_Model_Categoria($rowCategoria->toArray());
		
		return $modelCategoria;
	}

	public function obtenerOpciones($idCategoria){
		$tablaOpcion = $this->tablaOpcion;
		$select = $tablaOpcion->select()->from($tablaOpcion)->where("idCategoria = ?", $idCategoria);
		$rowOpciones = $tablaOpcion->fetchAll($select);
		
		$opcionesModel = array();
		foreach ($rowOpciones as $rowOpcion) {
			$opcionModel = new Encuesta_Model_Opcion($rowOpcion->toArray());
			
			$opcionesModel[] = $opcionModel;
		}
		
		return $opcionesModel;
	}
	
	public function obtenerCategorias() {
		$tablaCategoria = $this->tablaCategoria;
		$rowCategorias = $tablaCategoria->fetchAll();
		
		$modelCategorias = array();
		
		foreach ($rowCategorias as $rowCategoria) {
			$modelCategoria = new Encuesta_Model_Categoria($rowCategoria->toArray());
			
			$modelCategorias[] = $modelCategoria;
		}
		
		return $modelCategorias;
	}
	
	// =====================================================================================>>>   Insertar
	public function crearCategoria(Encuesta_Model_Categoria $categoria){
		$tablaCategoria = $this->tablaCategoria; 
		$tablaCategoria->insert($categoria->toArray());
	}
	// =====================================================================================>>>   Actualizar
	public function editarCategoria($idCategoria, Encuesta_Model_Categoria $categoria) {
		$tablaCategoria = $this->tablaCategoria;
		$where = $tablaCategoria->getAdapter()->quoteInto("idCategoria = ?", $idCategoria);
		
		$tablaCategoria->update($categoria->toArray(), $where);
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarCategoria($idCategoria){
		$tablaCategoria = $this->tablaCategoria;
		$where = $tablaCategoria->getAdapter()->quoteInto("idCategoria = ?", $idCategoria);
		
		$tablaCategoria->delete($where);
	}
	
	public function eliminarOpciones($idCategoria){
		$tablaOpcion = $this->tablaOpcion;
		$select = $tablaOpcion->select()->where("idCategoria = ?", $idCategoria);
		
		$tablaOpcion->delete($select);
	}
}
