<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Categoria implements Zazil_Interfaces_ICategoria {
	
	private $tablaCategoria;
	private $tablaOpcion;
	
	function __construct() {
		$this->tablaCategoria = new Encuesta_Model_DbTable_Categoria;
		$this->tablaOpcion = new Encuesta_Model_DbTable_Opcion;
	}
	
	// =====================================================================================>>>   Buscar
	public function obtenerCategoriaId($idCategoria){
		$tablaCategoria = $this->tablaCategoria;
		$select = $tablaCategoria->select()->from($tablaCategoria)->where("idCategoria = ?", $idCategoria);
		$categoria = $tablaCategoria->fetchRow($select);
		
		//$categoriaM = new Zazil_Model_Categoria($categoria->toArray());
		$categoriaM = new Encuesta_Model_Categoria($categoria->toArray());
		//$categoriaM->setIdCategoria($categoria->idCategoria);
		
		return $categoriaM;
	}
	//@TODO
	public function obtenerOpciones($idCategoria){
		$tablaOpcion = $this->tablaOpcion;
		$select = $tablaOpcion->select()->from($tablaOpcion)->where("idCategoria = ?", $idCategoria);
		$opciones = $tablaOpcion->fetchAll($select);
		//return $opciones;
	}
	
	public function obtenerCategorias() {
		$tablaCategoria = $this->tablaCategoria;
		$categorias = $tablaCategoria->fetchAll();
		$categoriasM = array();
		foreach ($categorias as $categoria) {
			$elemento = new Zazil_Model_Categoria($categoria->toArray());
			$categoriasM[] = $elemento;
		}
		return $categoriasM;
	}
	
	// =====================================================================================>>>   Insertar
	public function crearCategoria(Zazil_Model_Categoria $categoria){
		$this->tablaCategoria->insert($categoria->toArray());
	}
	// =====================================================================================>>>   Actualizar
	public function editarCategoria($idCategoria, Zazil_Model_Categoria $categoria){
		$tablaCategoria = $this->tablaCategoria;
		$select = $tablaCategoria->select()->from($tablaCategoria)->where("idCategoria = ?", $idCategoria);
		$tablaCategoria->update($categoria->toArray(), $select);
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarCategoria($idCategoria){
		
	}
	
	
	
}
