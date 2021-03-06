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
					//print_r($costoUnitario);
					//Buscamos que el producto enlazado no se repita dentro del producto.
					$tablaProductoCom = $this->tablaProductoCompuesto;
					$select = $tablaProductoCom->select()->from($tablaProductoCom)->where("idProducto = ?",$datos[0]['idProducto'])->where("productoEnlazado = ?",$datos[0]['productoEnlazado']);
					$rowProductoCom = $tablaProductoCom->fetchRow($select);
					//print_r("$select");
					if(is_null($rowProductoCom)){
						//print_r("El producto enlazado, no esta dentro del producto terminado");
						$mProductoTer = array(
							'idProducto' =>$datos[0]['idProducto'],
							'productoEnlazado' => $datos[0]['productoEnlazado'],
							'cantidad' => $datos[0]['cantidad'],
							'descripcion' => $datos[0]['descripcion'],
							'presentacion' => $datos[0]['presentacion'],
							'costoUnitario' => $costoUnitario
						);
						print_r("<br />");
						//print_r($mProductoTer);
						$dbAdapter->insert("ProductoCompuesto", $mProductoTer);
					}else{
						echo "El producto ya existe" ;
					}
				}else{
					echo " No hay existencia del producto";
				}
			}//if multiplo
			
		}catch(Exception $ex){
			$dbAdapter->rollBack();
			print_r($ex->getMessage());
			
		}
	}
	
	public function obtenerIdProducto($idProdComp){
		$tablaProdComp = $this->tablaProductoCompuesto;
		$select = $tablaProdComp->select()->from($tablaProdComp)->where('idProductoCompuesto = ?',$idProdComp);
		$rowProdComp = $tablaProdComp->fetchRow($select);
		
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where('idProducto = ?',$rowProdComp->idProducto);
		$rowProducto = $tablaProducto->fetchRow($select);
		//print_r($select->__toString());
		if(is_null($rowProducto)){
			return null;
		}else{
			return $rowProducto->toArray();
		}
		
	}
	
	public function obtieneProductoTerminado($idPC){
		$tablaProdCom = $this->tablaProductoCompuesto;
		$select = $tablaProdCom->select()
		->setIntegrityCheck(false)
		->from($tablaProdCom, array('costoUnitario','cantidad','idProducto','idProductoCompuesto','productoEnlazado','descripcion'))
		->join('Producto','ProductoCompuesto.productoEnlazado = Producto.idProducto',array('claveProducto','producto'))
		->join('Unidad','ProductoCompuesto.presentacion = Unidad.idUnidad', array('abreviatura'))
		->where("ProductoCompuesto.idProductoCompuesto = ?", $idPC);
		//print_r($select->__toString());
		return $tablaProdCom->fetchRow($select)->toArray();
		
	}
	
	public function obtenerMultiploProdCom($idProdComp){
		$tablaProdComp = $this->tablaProductoCompuesto;
		$select = $tablaProdComp->select()->from($tablaProdComp)->where('idProductoCompuesto = ?',$idProdComp);
		$rowProdComp = $tablaProdComp->fetchRow($select);
		//print_r($select->__toString());
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where('idProducto = ?',$rowProdComp->productoEnlazado);
		$rowProducto = $tablaProducto->fetchRow($select);
		//print_r($select->__toString());
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()
		->setIntegrityCheck(false)
		->from($tablaMultiplos)
		->join('Unidad', 'Multiplos.idUnidad = Unidad.idUnidad')->where("Multiplos.idProducto = ?", $rowProdComp->productoEnlazado);
		//print_r($select->__toString());
		return $tablaMultiplos->fetchAll($select);
	}
	
	public function editarProdCom($idProdComp, array $productoComp){
		$tablaProdComp = $this->tablaProductoCompuesto;
		$select = $tablaProdComp->select()->from($tablaProdComp)->where('idProductoCompuesto = ?',$idProdComp);
		$rowProdComp = $tablaProdComp->fetchRow($select);
		print_r($select->__toString());
		
		$rowProdComp->cantidad = $productoComp["cantidad"];
		$rowProdComp->presentacion = $productoComp["presentacion"];
		
		$rowProdComp->save();
		
	}
	
	public function eliminarProdCom($idProdComp){
		$tablaProdComp = $this->tablaProductoCompuesto;
		$where = $tablaProdComp->getAdapter()->quoteInto("idProductoCompuesto = ?", $idProdComp);
		print_r("$where");
		$tablaProdComp->delete($where);
		
	}
	
	public function obtenerProductoTerminado($idProductoTerminado){
		$tablaProdCom = $this->tablaProductoCompuesto;
		$select = $tablaProdCom->select()
		->setIntegrityCheck(false)
		->from($tablaProdCom, array('cantidad','idProducto','idProductoCompuesto'))
		->join('Producto','ProductoCompuesto.productoEnlazado = Producto.idProducto',array('claveProducto','producto'))
		->join('Inventario','ProductoCompuesto.productoEnlazado = Inventario.idProducto','costoUnitario')
		->join('Unidad','ProductoCompuesto.presentacion = Unidad.idUnidad', array('abreviatura'))
		->where("ProductoCompuesto.idProducto = ?", $idProductoTerminado);
		//print_r($select->__toString());
		return $tablaProdCom->fetchAll($select)->toArray();
	}
}
