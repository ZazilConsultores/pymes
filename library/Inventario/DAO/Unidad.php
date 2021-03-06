<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Unidad implements Inventario_Interfaces_IUnidad {
	private $tablaUnidad;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		
		$this->tablaUnidad = new Inventario_Model_DbTable_Unidad(array('db'=>$dbAdapter));
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos(array('db'=>$dbAdapter));
		
	}
	
	public function obtenerUnidad($idUnidad)
	{
		$tablaUnidad = $this->tablaUnidad;
		$select = $tablaUnidad->select()->from($tablaUnidad)->where("idUnidad = ?",$idUnidad);
		$rowUnidad = $tablaUnidad->fetchRow($select);
		
		$unidadModel = new Inventario_Model_Unidad($rowUnidad->toArray());
		$unidadModel->setIdUnidad($rowUnidad->idUnidad);
		
		return $unidadModel;
	}
	
	
	public function obtenerUnidades()
	{
		$tablaUnidad = $this->tablaUnidad;
		$rowUnidades = $tablaUnidad->fetchAll();
		$modelUnidades = array();
		
		foreach ($rowUnidades as $rowUnidad) {
			$modelUnidad = new Inventario_Model_Unidad($rowUnidad->toArray());
			$modelUnidad->setIdUnidad($rowUnidad->idUnidad);
			
			$modelUnidades[] = $modelUnidad;
		}
		
		return $modelUnidades;	
	}
	
	public function crearUnidad( Inventario_Model_Unidad $unidad)
	{
		$tablaUnidad = $this->tablaUnidad;
		$select = $tablaUnidad->select()->from($tablaUnidad);
		$rowUnidad = $tablaUnidad->fetchRow($select);
		
		$tablaUnidad->insert($unidad->toArray());
	
	}
	

	public function editarUnidad($idUnidad, array $unidad)
	{							
		$tablaUnidad = $this->tablaUnidad;
		$where = $tablaUnidad->getAdapter()->quoteInto("idUnidad = ?", $idUnidad);
		$tablaUnidad->update($unidad, $where);
		
		
	}
		
	public function eliminarUnidad($idUnidad)
	{
		$tablaUnidad = $this->tablaUnidad;
		$where = $tablaUnidad->getAdapter()->quoteInto("idUnidad = ?", $idUnidad);		
		$tablaUnidad->delete($where);
	}
	
	public function obtenerMultiplos($idProducto)
	{
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()
		->setIntegrityCheck(false)
		->from($tablaMultiplos)
		->join('Unidad', 'Multiplos.idUnidad = Unidad.idUnidad')->where("Multiplos.idProducto = ?", $idProducto);
		//print_r($select->__toString());
		return $tablaMultiplos->fetchAll($select);
	}
	
	
}