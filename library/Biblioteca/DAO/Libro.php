<?php
/**
 * Clase que opera sobre libros en la biblioteca
 * @author Alizon Fernanda Díaz
 * @copyright 2016
 * @version 1.0.0
 */
class Biblioteca_DAO_Libro implements Biblioteca_Interfaces_ILibro {
	
	private $tablaLibro;
	
	function __construct() {
		$this->tablaLibro = new Biblioteca_Model_DbTable_Libro;
		
	}
	
	/**
	 * Función que agrega un libro al catalogo de libros
	 * @param $libro libro a agregar
	 */
	public function agregarLibro(Biblioteca_Model_Libro $libro){//firma de la función
		
		$tablaLibro = $this->tablaLibro;
		$tablaLibro->insert($libro->toArray());
		
	}
	
	/**
	 * Función que obtiene un registro de la tabla materia, mediante el idMateria
	 * @param $idMateria
	 * @return array | null
	 */
	public function obtenerLibro($idLibro) {
		$tablaLibro = $this->tablaLibro;
		$where = $tablaLibro->getAdapter()->quoteInto("idMateria = ?", $idMateria);
		$rowLibro = $tablaLibro->fetchAll($where);
		
		$modelLibros = array();
		
		foreach ($rowLibros as $rowLibro) {
			$modelLibro = new Biblioteca_Model_Libro($rowLibro->toArray());
			$modelLibros[] = $modelLibro;
		}
		
		return $modelLibros;
	}
	
	

	
	public function prestamoLibro($libro,$registro) {}
	public function devolverLibro($libro,$registro) {}
	public function liberarLibro($libro,$causa,$destino) {}
}
