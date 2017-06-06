<?php
class Inventario_DAO_Productoterminado implements Inventario_Interfaces_IProductoterminado
{
	private $tablaProductoCompuesto;
	private $tablaProducto;
	private $tablaMultiplos;
	
	private $tablaInventario;
	
	public function __construct()
	{
		//$this->tablaProducto = new Inventario_Model_DbTable_Producto;
		//$this->tablaInventario = new Inventario_Model_DbTable_Inventario;
		
	}
	public function obtenerProducto()
	{
		/*$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->setIntegrityCheck(false)
		->from($tablaProducto, array('claveProducto','producto'))
		->join('Inventario','Producto.idProducto = Inventario.idProducto', array())
		->where('Inventario.idSucursal=2')
		->order('producto ASC');
		
		return $tablaProducto->fetchAll($select);*/
	}
	
	
	public function obtenerProductoTerminado()
	{
		/*$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where('claveProducto like?','PTVT%')
		->order("producto");
		$rowProductos = $tablaProducto->fetchAll($select);
		
		$modelProductos = array();
		
		foreach ($rowProductos as $rowProducto) {
			$modelProducto = new Inventario_Model_Producto($rowProducto->toArray());
			$modelProducto->setIdProducto($rowProducto->idProducto);
			
			$modelProductos[] = $modelProducto;
			
		}
		
		return $modelProductos;*/
	}
	
	
	public function crearProductoTerminado(array $datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		//$dbAdapter->beginTransaction();
		
		//$productoTer = $datos;
		try{
			$mProductoTer = array(
				'idProducto' =>$datos[0]['idProducto'],
				'productoEnlazado' => $datos[0]['productoEnlazado'],
				'cantidad' => $datos[0]['cantidad'],
				'descripcion' => $datos[0]['descripcion'],
				'presentacion' => $datos[0]['presentacion'],
				
			);
			$dbAdapter->insert("ProductoCompuesto", $mProductoTer);
		}catch(Exception $ex){
			$dbAdapter->rollBack();
			print_r($ex->getMessage());
			
		}
	}
}
