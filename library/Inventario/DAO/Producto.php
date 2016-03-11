<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Producto implements Inventario_Interfaces_IProducto{
	
	private $tablaProducto;
	private $tablaSubparametro;
	
	public function __construct() {
		$this->tablaProducto = new Inventario_Model_DbTable_Producto;
	}
	
	public function obtenerClaveProducto()
	{
		$tablaSubparametro = $this->tablaSubparametro;
		$claveProducto = "";
		
		foreach($clave as $idParametro=>$idSubparametro){
			$sub = $this->obtenerProducto($idProducto);
		
		}
		
	}
	
	public function obtenerProducto($idProducto){
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto = ?", $idProducto);
		$rowProducto = $tablaProducto->fetchRow($select);
		
		$productoModel = new Inventario_Model_Producto($rowProducto->toArray());
		$productoModel->setIdProducto($rowProducto->idProducto);
		
		return $productoModel;
		
	}
	
	public function obtenerProductos(){
		$tablaProducto = $this->tablaProducto;
		$rowProductos = $tablaProducto->fetchAll();
		
		$modelProductos = array();
		
		foreach ($rowProductos as $rowProducto) {
			$modelProducto = new Inventario_Model_Producto($rowProducto->toArray());
			$modelProducto->setIdProducto($rowProducto->idProducto);
			
			$modelProductos[] = $modelProducto;
			
		}
		
		return $modelProductos;
		
	}
	
	public function crearProducto(Inventario_Model_Producto $producto){
					
		$tablaProducto = $this->tablaProducto;
		
		$subparametroDAO = new Sistema_DAO_Subparametro;
		
			
		//$subparametro->setHash($subparametro->getHash());
		
	    
		$tablaProducto->insert($producto->toArray());
				
	}
	
	public function editarProducto($idProducto, array $producto)
	{
		$tablaProducto = $this->tablaProducto;
		$where = $tablaProducto->getAdapter()->quoteInto("idProducto = ?", $idProducto);
		$tablaProducto->update($producto, $where);
	}
	
	
	
	public function eliminarProducto($idProducto){
		$tablaProducto = $this->tablaProducto;
		$where = $tablaProducto->getAdapter()->quoteInto("idProducto = ?", $idProducto);
		
		$tablaProducto->delete($where);
	}
}
