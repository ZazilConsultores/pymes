<?php
/**
 * Clase que opera sobre materias en la biblioteca
 * @author Alizon Fernanda Díaz
 * @copyright 2016
 * @version 1.0.0
 */
class Biblioteca_DAO_Materia implements Biblioteca_Interfaces_IMateria {
	
	private $tablaMateria;
	
	function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		
		$this->tablaMateria = new Biblioteca_Model_DbTable_Materia(array('db'=>$dbAdapter));
	}
	
	/**
	 * Función que agrega una materia al catalogo de libros
	 * @param $materia materia a agregar
	 */
	public function agregarMateria(Biblioteca_Model_Materia $materia){//firma de la función
		
		$tablaMateria = $this->tablaMateria;
		$tablaMateria->insert($materia->toArray());
		
	}
	
	/**
	 * Función que obtiene un registro de la tabla materia, mediante el idMateria
	 * @param $idMateria
	 * @return array | null
	 */
	
	public function obtenerMateriaB($idMateria)
	{
		$tablaMateria = $this->tablaMateria;
		$rowMaterias = $tablaMateria->fetchAll();
		
		$modelMaterias = array();
		
		foreach ($rowMaterias as $rowMateria) {
			$modelMateria = new Biblioteca_Model_Materia($rowMateria->toArray());
			$modelMateria->setIdMateria($rowMateria->idMateria);
			
			$modelMaterias[] = $modelMateria;
		}
		
		return $modelMaterias;
	}
	
	public function obtenerMateriasB(Biblioteca_Model_Materia $materia)
	{
		$tablaMateria = $this->tablaMateria;
		$tablaMateria->select($materia->toArray());
	}
	
	
	
	

}
