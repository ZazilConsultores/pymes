<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 * */
class Inventario_DAO_Multiplo implements Inventario_Interfaces_IMultiplo {
	private $tablaMultiplo;
	
	public function __construct()
	{
		$this->tablaMultiplo= new Inventario_Model_DbTable_Multiplos;
		
	}
	
	public function obtenerMultiplo($idMultiplos)
	{
		$tablaMultiplo = $this->tablaMultiplo;
		$select = $tablaMultiplo->select()->from($tablaMultiplo)->where("idMultiplos = ?",$idMultiplos);
		$rowMultiplo = $tablaMultiplo->fetchRow($select);
		
		$multiploModel = new Inventario_Model_Multiplos($rowMultiplo->toArray());
		$multiploModel->setIdMultiplos($rowMultiplo->idMultiplos);
		
		return $multiploModel;
	}
	
	public function obtenerMultiplos($idProducto)
	{
		$tablaMultiplo = $this->tablaMultiplo;
		$where = $tablaMultiplo->getAdapter()->quoteInto("idProducto = ?", $idProducto);
		$rowsMultiplo = $tablaMultiplo->fetchAll($where);
		
		$modelMultiplos = array();
		
		foreach ($rowsMultiplo as $rowMultiplo) {
			$modelMultiplo = new Inventario_Model_Multiplos ($rowMultiplo->toArray());
			
			$modelMultiplos[] = $modelMultiplo;
		}
		
		return $modelMultiplos;
		
	}
	
	public function crearMultiplos(Inventario_Model_Multiplos $idMultiplos)
	{
		$tablaMultiplo = $this->tablaMultiplo;
		$tablaMultiplo->insert($multiplo->toArray());
	}
	
	public function editarMultiplo($idMultiplos,Inventario_Model_Multiplos $multiplo)
	{
		$tablaMultiplo = $this->tablaMultiplo;
		$where = $tablaMultiplo->getAdapter()->quoteInto("idMultiplos= ?", $idMultiplos);
		
	}
	
	public function eliminarMultiplo($idMultiplos)
	{
		$tablaMultiplo = $this->tablaMultiplo;
		$where = $tablaMultiplo->getAdapter()->quoteInto("idMultiplos = ?", $idMultiplos);		
		$tablaMultiplo->delete($where);
	}
}