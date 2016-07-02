<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Inventario implements Inventario_Interfaces_IInventario {
	
	private $tablaInventario;
	private $tablaProducto;
	
	public function __construct() {
		$this->tablaInventario = new Inventario_Model_DbTable_Inventario;
		$this->tablaProducto = new Inventario_Model_DbTable_Producto;
	}
	
	public function obtenerInventario(){
		$tablaInventario = $this->tablaInventario;
		$rowsInventario = $tablaInventario->fetchAll();
		
		$modelInventario = array();
		
		foreach($rowsInventario as $rowInventario){
			$modelInventario = new Inventario_Model_Inventario($rowInventario->toArray());
			$modelInventario->setIdInventario($rowInventario->idInventario);
			
			$modelsInventario [] = $modelInventario;
			
		}
		
		return $modelsInventario;
	}
	
public function obtenerIdProductoInventario(){ 
		$tablaProducto = $this->tablaProducto;
		$tablaInventario = $this->tablaInventario;
		
		$rowsInventario = $tablaInventario->fetchAll();
		//$inventario = $rowsInventario;
		
		$idProducto = array();
		
		foreach ($rowsInventario as $row){
			$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto = ?",$row->idProducto);
			$rowProducto= $tablaProducto->fetchRow($select);
			
			$idProducto[] = $rowProducto->idProducto;
		}
		return $idProducto;
	}
	
	public function obtenerProductoInventario($idInventario){
		$tablaInventario = $this->tablaInventario;
		$select = $tablaInventario->select()->from($tablaInventario)->where("idInventario = ?", $idInventario);
		$rowInventario = $tablaInventario->fetchRow($select);
		
		$inventarioModel = new Inventario_Model_Inventario($rowInventario->toArray());
		$inventarioModel->setIdInventario($rowInventario->idInventario);
		
		return $inventarioModel;
		
	}
	
	public function editarInventario($idInventario, array $inventario)
	{
		$tablaInventario = $this->tablaInventario;
		$where = $tablaInventario->getAdapter()->quoteInto("idInventario = ?", $idInventario);
		$tablaInventario->update($inventario, $where);
		
		//*******Edita
		$datos=array();
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		
		
		try{
		$tablaInventario = $this->tablaInventario;
		$select = $tablaInventario->select()->from($tablaInventario)->where("idInventario=?",$datos['idInventario']);
	
		$row = $tablaInventario->fetchRow($select); 
		
		if(!is_null($row)){
			$secuencial= $row->secuencial +1;
			print_r($secuencial);
		}else{
			$secuencial = 1;	
		
		print_r($secuencial);
		}
			
		$bd->commit();
		}catch(exception $ex){
			print_r("<br />");
			print_r("================");
			print_r("<br />");
			print_r("Excepcion Lanzada");
			print_r("<br />");
			print_r("================");
			print_r("<br />");
			print_r($ex->getMessage());
			print_r("<br />");
			print_r("<br />");
			$bd->rollBack();
		}
	
	
	}
	

}
