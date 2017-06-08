<?php
class Inventario_DAO_Productoterminado implements Inventario_Interfaces_IProductoterminado
{
	private $tablaProductoCompuesto;
	private $tablaProducto;
	private $tablaMultiplos;
	private $tablaInventario;
	
	
	public function __construct()
	{
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaProductoCompuesto = new Inventario_Model_DbTable_ProductoCompuesto(array('db'=>$dbAdapter));
		$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos(array('db'=>$dbAdapter));
		$this->tablaInventario = new Inventario_Model_DbTable_Inventario(array('db'=>$dbAdapter));
		
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
	
	
	public function obtenerProductosTerminados()
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where('claveProducto like?','PTVT%')
		->order("producto");
		$rowProductos = $tablaProducto->fetchAll($select);
		
		$modelProductos = array();
		
		foreach ($rowProductos as $rowProducto) {
			$modelProducto = new Inventario_Model_Producto($rowProducto->toArray());
			$modelProducto->setIdProducto($rowProducto->idProducto);
			
			$modelProductos[] = $modelProducto;
			
		}
		
		return $modelProductos;
	}
	public function obtenerProductoTerminado($idProductoTerminado){
		
		$tablaProdCom = $this->tablaProductoCompuesto;
		$select = $tablaProdCom->select()->from($tablaProdCom)->where("idProducto = ?", $idProductoTerminado);
		$rowProductoComp = $tablaProdCom->fetchAll($select);
		
		if(is_null($rowProductoComp)){
			return null;
		}else{
			return $rowProductoComp->toArray();
		}
	}
	
	
	public function crearProductoTerminado(array $datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		//$dbAdapter->beginTransaction();
		
		try{
			//Realiza costoUnitatio por producto
			$tablaMuliplos = $this->tablaMultiplos;
			$select = $tablaMuliplos->select()->from($tablaMuliplos)->where("idProducto = ?",$datos[0]['productoEnlazado'])->where("idUnidad=?",$datos[0]['presentacion']);
			$rowMultiplo = $tablaMuliplos->fetchRow($select);
			//print_r("$select");
			if(!is_null($rowMultiplo)){
				$tablaInventario = $this->tablaInventario;
				$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto = ?",$datos[0]['productoEnlazado']);
				$rowInventario = $tablaInventario->fetchRow($select);
				print_r("$select");
				if(!is_null($rowInventario)){
					//print_r("Existe producto en inventario");
					$costoUnitario = $rowInventario->costoUnitario * $rowMultiplo->cantidad;
					print_r("<br />");
					print_r($costoUnitario);
					//Buscamos que el producto enlazado no se repita dentro del producto.
					$tablaProductoCom = $this->tablaProductoCompuesto;
					$select = $tablaProductoCom->select()->from($tablaProductoCom)->where("idProducto = ?",$datos[0]['idProducto'])->where("productoEnlazado = ?",$datos[0]['productoEnlazado']);
					$rowProductoCom = $tablaProductoCom->fetchRow($select);
					print_r("$select");
					if(is_null($rowProductoCom)){
						print_r("El producto enlazado, no esta dentro del producto terminado");
						$mProductoTer = array(
							'idProducto' =>$datos[0]['idProducto'],
							'productoEnlazado' => $datos[0]['productoEnlazado'],
							'cantidad' => $datos[0]['cantidad'],
							'descripcion' => $datos[0]['descripcion'],
							'presentacion' => $datos[0]['presentacion'],
							'costoUnitario' => $costoUnitario
						);
						$dbAdapter->insert("ProductoCompuesto", $mProductoTer);
					}else{
						echo "El producto " .$datos['productoEnlazado'] ."ya existe" ;
					}
				}else{
					echo "El producto no esta en inventario";
				}
			}//if multiplo
			
		}catch(Exception $ex){
			$dbAdapter->rollBack();
			print_r($ex->getMessage());
			
		}
	}
}
