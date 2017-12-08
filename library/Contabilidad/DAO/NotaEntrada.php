<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_NotaEntrada implements Contabilidad_Interfaces_INotaEntrada{
	
	private $tablaMovimiento;
	private $tablaInventario;
	private $tablaCapas;
	private $tablaMultiplos;
	private $tablaEmpresa;
	private $tablaProductoCompuesto;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas(array('db'=>$dbAdapter));
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario(array('db'=>$dbAdapter));
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos(array('db'=>$dbAdapter));
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
		$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
		$this->tablaProductoCompuesto = new Inventario_Model_DbTable_ProductoCompuesto(array('db'=>$dbAdapter));
	}

	public function obtenerProveedores(){
		$tablaEmpresa = $this->tablaEmpresa;
		$select= $tablaEmpresa->select()
		->setIntegrityCheck(false)
		->from($tablaEmpresa, array('idEmpresa'))
		->join('Fiscales', 'Empresa.idFiscales = Fiscales.idFiscales', array('razonSocial'))
		->join('Proveedores','Empresa.idEmpresa = Proveedores.idEmpresa')
		->order('razonSocial ASC');
		//print_r("$select");
		return $tablaEmpresa->fetchAll($select);
			
	}
	
	
	public function agregarProducto(array $encabezado, $productos){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
		$dbAdapter->beginTransaction();
		$dateIni = new  Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
		try{
			foreach ($productos as $producto) {
				$secuencial=0;	
				$tablaMovimiento = $this->tablaMovimiento;
				$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
				->where("idCoP=?",$encabezado['idCoP'])->where("idSucursal=?",$encabezado['idSucursal'])
				->where("numeroFolio=?",$encabezado['numFolio'])->where("fecha=?", $stringIni)->order("secuencial DESC");
				$rowMovimiento = $tablaMovimiento->fetchRow($select); 
				if(!is_null($rowMovimiento)){
					$secuencial= $rowMovimiento->secuencial +1;
				}else{
					$secuencial = 1;	
				}
				//=================Selecciona producto y unidad=======================================
				$tablaMultiplos = $this->tablaMultiplos;
				$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
				$rowMultiplo = $tablaMultiplos->fetchRow($select); 
				//print_r("$select");
				if(!is_null($rowMultiplo)){
					//====================Operaciones para convertir unidad minima====================================================== 
					$cantidad = $producto['cantidad'] * $rowMultiplo->cantidad;
					$precioUnitario = $producto['precioUnitario'] / $rowMultiplo->cantidad;
				
					$mMovtos = array(
						'idProducto' => $producto['descripcion'],
						'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
						'idEmpresas'=>$encabezado['idEmpresas'],
						'idSucursal'=>$encabezado['idSucursal'],
						'idCoP'=>$encabezado['idCoP'],
						//'idProyecto'=>$encabezado['idProyecto'],
						'numeroFolio'=>$encabezado['numFolio'],
						//'idFactura'=>0,
						'cantidad'=>$cantidad,
						'fecha'=>$stringIni,
						'estatus'=>"A",
						'secuencial'=> $secuencial,
						'costoUnitario'=>$precioUnitario,
						'totalImporte'=>$producto['importe']
					);
					//print_r($mMovtos);
					$dbAdapter->insert("Movimientos",$mMovtos);
				}
				
			}
			$dbAdapter->commit();
		}catch(exception $ex){
			$dbAdapter->rollBack();
			print_r($ex->getMessage());
			throw new Util_Exception_BussinessException("Error");	
		}
	}
	
	public function actulizaProducto(array $encabezado, $productos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();	
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
		$stringIni = $fechaInicio->toString('YY-mm-dd');
		try{
			foreach ($productos as $producto) {
			//Seleccionamos el producto para su clasificacion, Ver si la validación del producto se puede hacer desde jquery
			$tablaProducto = $this->tablaProducto;
			$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?",$producto["descripcion"]);
			$rowProducto = $tablaProducto->fetchRow($select);
			//Convertimos la unidad del producto
			$tablaMultiplos = $this->tablaMultiplos;
			$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
			$rowMultiplo = $tablaMultiplos->fetchRow($select); 
			$cantidad = $producto['cantidad'] * $rowMultiplo["cantidad"];
			$precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
		
			print_r("<br />");
			if(!is_null($rowProducto && !is_null($rowMultiplo))){
				$claveProducto = substr($rowProducto->claveProducto, 0,2);
				//print_r($claveProducto);
				print_r("<br />");
				switch($claveProducto){
					case 'PT':
					//print_r("<br />");
					$tablaCapas = $this->tablaCapas;
					$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['descripcion']);
					$rowCapas = $tablaCapas->fetchRow($select);
					if(is_null($rowCapas)){
						$mCapas = array(
								'idSucursal'=>$encabezado['idSucursal'],
								'numeroFolio'=>$encabezado["numFolio"],
								'idProducto'=>$producto['descripcion'],
								'idDivisa'=>$cantidad,
								'secuencial'=>1,
								'cantidad'=>$cantidad,
								'fechaEntrada'=>$stringIni,
								'costoUnitario'=>$precioUnitario
						);
						$dbAdapter->insert("Capas",$mCapas);
					}else{
						//Actuliza, costoUnitario, fecha
						$rowCapas->costoUnitario = $precioUnitario;
						$rowCapas->fechaEntrada = date('Y-m-d h:i:s', time());
						$rowCapas->save();
					}
					$tablaInventario = $this->tablaInventario;
					$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
					$rowInventario = $tablaInventario->fetchRow($select);
					$costoCliente = $precioUnitario * ($rowInventario["porcentajeGanancia"] / 100) + $precioUnitario;
					print_r("<br />");
					//print_r($costoCliente);
					if(is_null($rowInventario)){
						$mInventario = array(
							'idProducto'=>$producto['descripcion'],
							'idDivisa'=>1,
							'idSucursal'=>$encabezado['idSucursal'],
							'existencia'=>$cantidad,
							'apartado'=>'0',
							'existenciaReal'=>$cantidad,
							'maximo'=>'0',
							'minimo'=>'0',
							'fecha'=>$stringIni,
							'costoUnitario'=>$precioUnitario,
							'porcentajeGanancia'=>'0',
							'cantidadGanancia'=>'0',
							'costoCliente'=> $costoCliente
						);
						print_r($mInventario);
						$dbAdapter->insert("Inventario",$mInventario);
					}else{
						//Actuliza, fecha, costoUnitrio, costoCliente
						$rowInventario->cantidad = $cantidad;
						$rowInventario->fecha = date('Y-m-d h:i:s', time());
						$rowInventario->costoUnitario = $precioUnitario;
						$rowInventario->costoCliente = $costoCliente;
						$rowInventario->save();
					}
						
							
				break;
				case 'VS':
					//No registramos  en Capas, si no existe en Inventario lo registra solo una vez, pero nunca actuliaza  
					print_r("<br />");
					//print_r("Varios Servicios");
					$tablaInventario = $this->tablaInventario;
					$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
					$rowInventario = $tablaInventario->fetchRow($select);
					$costoCliente = $precioUnitario * ($rowInventario["porcentajeGanancia"] / 100) + $precioUnitario;
					print_r("<br />");
					//print_r("$select");
					if(is_null($rowInventario)){
						$mInventario = array(
								'idProducto'=>$producto['descripcion'],
								'idDivisa'=>$formaPago["idDivisa"],
								'idSucursal'=>$encabezado['idSucursal'],
								'existencia'=>$cantidad,
								'apartado'=>'0',
								'existenciaReal'=>$cantidad,
								'maximo'=>'0',
								'minimo'=>'0',
								'fecha'=>$stringIni,
								'costoUnitario'=>$precioUnitario,
								'porcentajeGanancia'=>'0',
								'cantidadGanancia'=>'0',
								'costoCliente'=> $costoCliente
							);
							$dbAdapter->insert("Inventario",$mInventario);
					}
				break;
				case 'SV':
					//No registramos  en Capas, si no existe en Inventario lo registra, si ya existe actualiza la fecha y costos   
					print_r("<br />");
					print_r("Servicio");
					print_r("<br />");
					//print_r("Varios Servicios");
					$tablaInventario = $this->tablaInventario;
					$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
					$rowInventario = $tablaInventario->fetchRow($select);
					$costoCliente = $precioUnitario * ($rowInventario["porcentajeGanancia"] / 100) + $precioUnitario;
					print_r("<br />");
					//print_r("$select");
					if(is_null($rowInventario)){
						$mInventario = array(
								'idProducto'=>$producto['descripcion'],
								'idDivisa'=>$formaPago["idDivisa"],
								'idSucursal'=>$encabezado['idSucursal'],
								'existencia'=>$cantidad,
								'apartado'=>'0',
								'existenciaReal'=>$cantidad,
								'maximo'=>'0',
								'minimo'=>'0',
								'fecha'=>$stringIni,
								'costoUnitario'=>$precioUnitario,
								'porcentajeGanancia'=>'0',
								'cantidadGanancia'=>'0',
								'costoCliente'=> $costoCliente
							);
							$dbAdapter->insert("Inventario",$mInventario);
					}else{
						$rowInventario->existencia = $cantidad;
						$rowInventario->existenciaReal = $cantidad;
						$rowInventario->fecha = date('Y-m-d h:i:s', time());
						$rowInventario->costoUnitario = $precioUnitario;
						$rowInventario->costoCliente = $costoCliente;
						$rowInventario->save();
					}
				break;
				default:
					print_r("<br />");
					//Creamos o actualizamos Capas y Inventario
					$tablaCapas = $this->tablaCapas;
					$select = $tablaCapas->select()->from($tablaCapas)->where("numeroFolio=?",$encabezado['numFolio'])->where("fechaEntrada=?", $stringIni)->order("secuencial DESC");
					//print_r("$select");
					$precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
					$rowCapas = $tablaCapas->fetchRow($select); 
					if(!is_null($rowCapas)){
						$secuencial= $rowCapas->secuencial +1;
					}else{
						$secuencial = 1;	
					}
					
					$mCapas = array(
							'idProducto' => $producto['descripcion'],
							'idDivisa'=>1,
							'idSucursal'=>$encabezado['idSucursal'],
							'numeroFolio'=>$encabezado['numFolio'],
							'secuencial'=>$secuencial,
							'cantidad'=>$cantidad,
							'fechaEntrada'=>$stringIni,
							'costoUnitario'=>$precioUnitario
						);
		 			
						
						//print_r($mCapas);
						$dbAdapter->insert("Capas", $mCapas);
						//Movimiento en Inventario
						$tablaInventario = $this->tablaInventario;
						$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
						$rowInventario = $tablaInventario->fetchRow($select);
						$cantidadI = $rowInventario["existencia"] + $cantidad;
						$costoCliente = $precioUnitario * ($rowInventario["porcentajeGanancia"] / 100) + $precioUnitario;
						print_r("<br />");
						//print_r("$select");
						if(!is_null($rowInventario)){
							//Sumamos en existencia y existenciaReal
							$fecha = date('Y-m-d h:i:s', time());
							$rowInventario->existencia = $cantidadI;
							$rowInventario->existenciaReal = $cantidadI;
							$rowInventario->fecha = $fecha;
							$rowInventario->costoUnitario = $precioUnitario;
							$rowInventario->costoCliente = $costoCliente;
							$rowInventario->save();
						}else{
							//Agregamos el registro
							$mInventario = array(
								'idProducto'=>$producto['descripcion'],
								'idDivisa'=>1,
								'idSucursal'=>$encabezado['idSucursal'],
								'existencia'=>$cantidadI,
								'apartado'=>'0',
								'existenciaReal'=>$cantidadI,
								'maximo'=>'0',
								'minimo'=>'0',
								'fecha'=>$stringIni,
								'costoUnitario'=>$precioUnitario,
								'porcentajeGanancia'=>'0',
								'cantidadGanancia'=>'0',
								'costoCliente'=> $costoCliente
							);
							$dbAdapter->insert("Inventario",$mInventario);
						}
						//Actulizamos el costo en ProductoTerminado
							$tablaProdComp = $this->tablaProductoCompuesto;
							$select = $tablaProdComp->select()->from($tablaProdComp)->where("productoEnlazado=?",$producto["descripcion"]);
							$rowsProductosComp = $tablaProdComp->fetchRow($select);
							print_r("<br />");
							//print_r("$select");
							print_r("<br />");
							if(!is_null($rowsProductosComp)){
								$rowsProductosComp["costoUnitario"] = $precioUnitario;
								$rowsProductosComp->save();
							}//RowProductoCompuesto	
					}//Existencia de Multiplo	
			}
		}	
		$dbAdapter->commit();
		
		}catch(exception $ex){
			$dbAdapter->rollBack();
			print_r($ex->getMessage());
			throw new Util_Exception_BussinessException("Error");
		}
	}
	
	public function actulizaCostoProducto(array $encabezado, $productos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();	
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
		$stringIni = $fechaInicio->toString('YY-mm-dd');
		
		try{
			foreach ($productos as $producto) {
				$tablaProducto = $this->tablaProducto;
				$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?",$producto["descripcion"]);
				$rowProducto = $tablaProducto->fetchRow($select);
				
				$tablaMultiplos = $this->tablaMultiplos;
				$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto["descripcion"])->where("idUnidad=?",$producto['unidad']);
				$rowMultiplo = $tablaMultiplos->fetchRow($select); 
				
				$cantidad = $producto['cantidad'] * $rowMultiplo["cantidad"];
				$precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
				
				if(!is_null($rowProducto && !is_null($rowMultiplo))){
					$claveProducto = substr($rowProducto->claveProducto, 0,2);
					if($claveProducto <> 'PT' || $claveProducto <> 'VS' || $claveProducto <> 'SV' ){
						print_r("Busca el producto en ProductoCompuesto");
						$tablaProdComp = $this->tablaProductoCompuesto;
						$select = $tablaProdComp->select()->from($tablaProdComp)->where("productoEnlazado=?",$producto["descripcion"]);
						$rowsProductosComp = $tablaProdComp->fetchAll($select);
						print_r("<br />");
						print_r("$select");
						print_r("<br />");
						if(!is_null($rowsProductosComp)){
							foreach($rowsProductosComp as $rowProductoComp){
								//Actualizamos costo en Capas y Inventario.
								$tablaProdComp = $this->tablaProductoCompuesto;
								$select = $tablaProdComp->select()->from($tablaProdComp, new Zend_Db_Expr('sum(cantidad * costoUnitario) as total'))->where("idProducto=?",$rowProductoComp["idProducto"]);
								$rowsProductosCompxp = $tablaProdComp->fetchRow($select);
								print_r("<br />");
								$total = $rowsProductosCompxp['total'] ;
								
								$tablaCapas = $this->tablaCapas;
								$where = $tablaCapas->getAdapter()->quoteInto("idProducto = ?", $rowProductoComp["idProducto"]);
								$tablaCapas->update(array("costoUnitario"=>$total), $where);
					
								$tablaInventario = $this->tablaInventario;
								$where = $tablaInventario->getAdapter()->quoteInto("idProducto = ?", $rowProductoComp["idProducto"]);
								$tablaInventario->update(array("costoUnitario"=>$total, "costoCliente"=>$total), $where);
								
								//Busca el producto donde sea enlazado para otros productos
								$tablaProdComEnl = $this->tablaProductoCompuesto;
								$select = $tablaProdComEnl->select()->from($tablaProdComEnl)->where("productoEnlazado=?",$rowProductoComp["idProducto"]);
								$rowsProductosCompxEnl = $tablaProdComEnl->fetchAll($select);
								print_r("<br />");
								print_r("$select");
								print_r("<br />");
								if(!is_null($rowsProductosCompxEnl)){
									foreach($rowsProductosCompxEnl as $rowProductoCompxEnl){
										//Actulizamos el nuevo costo
										$rowProductoCompxEnl->costoUnitario = $total;
										$rowProductoCompxEnl->save();
										//Sumamos el nuevo costo
										$tablaProdComp = $this->tablaProductoCompuesto;
										$select = $tablaProdComp->select()->from( $tablaProdComp,new Zend_Db_Expr('sum(cantidad * costoUnitario) as total'))->where("idProducto=?",$rowProductoCompxEnl["idProducto"]);
										$rowsProductosCompEnl = $tablaProdComp->fetchRow($select);
										print_r("$select");
										$totalEnl = $rowsProductosCompEnl['total'] ;
										//Actualiza Capa
										$tablaCapas = $this->tablaCapas;
										//$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowProductoComp["idProducto"]);
										$where = $tablaCapas->getAdapter()->quoteInto("idProducto = ?", $rowProductoCompxEnl["idProducto"]);
										$tablaCapas->update(array("costoUnitario"=>$totalEnl), $where);
										
										$tablaInventario = $this->tablaInventario;
										$where = $tablaInventario->getAdapter()->quoteInto("idProducto = ?", $rowProductoCompxEnl["idProducto"]);
										$tablaInventario->update(array("costoUnitario"=>$totalEnl, "costoCliente"=>$totalEnl), $where);
									}
								}	
							}
						}//if $rowsProductosComp
					}//Producto diferente de Servicio .
				}//rowProducto y multiplo
			}
			$dbAdapter->commit();
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
			$dbAdapter->rollBack();
		}
	}
}
