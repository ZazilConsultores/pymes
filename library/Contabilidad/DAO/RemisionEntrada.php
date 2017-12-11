<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_RemisionEntrada implements Contabilidad_Interfaces_IRemisionEntrada{	
	private $tablaMovimiento;
	private $tablaInventario;
	private $tablaCapas;
	private $tablaMultiplos;
	private $tablaEmpresa;
	private $tablaBanco;
	private $tablaCuentasxp;
	private $tablaProductoCompuesto;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario(array('db'=>$dbAdapter));
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas(array('db'=>$dbAdapter));
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos(array('db'=>$dbAdapter));
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
		$this->tablaBanco = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
		$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp(array('db'=>$dbAdapter));
		$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
		$this->tablaProductoCompuesto = new Inventario_Model_DbTable_ProductoCompuesto(array('db'=>$dbAdapter));	
	}
	
	public function obtenerProveedores(){
		$tablaEmpresa = $this->tablaEmpresa;
		$select=$tablaEmpresa->select()
		->setIntegrityCheck(false)
		->from($tablaEmpresa, array('idEmpresa'))
		->join('fiscales', 'Empresa.idFiscales = fiscales.idFiscales', array('razonSocial'))
		->join('Proveedores','Empresa.idEmpresa = Proveedores.idEmpresa');
		return $tablaEmpresa->fetchAll($select);	
	}
	
	public function agregarProducto(array $encabezado, $producto, $formaPago){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
		//$dbAdapter->beginTransaction();
		$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
		try{	
			$secuencial=0;	
			$tablaMovimiento = $this->tablaMovimiento;
			$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
			->where("idCoP=?",$encabezado['idCoP'])->where("idSucursal=?",$encabezado['idSucursal'])
			->where("fecha=?", $stringIni)->order("secuencial DESC");
			$rowMovimiento = $tablaMovimiento->fetchRow($select); 
		
			if(!is_null($rowMovimiento)){
				$secuencial= $rowMovimiento->secuencial +1;
			}else{
				$secuencial = 1;	
			}
			
			$tablaMultiplos = $this->tablaMultiplos;
			$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
			$rowMultiplo = $tablaMultiplos->fetchRow($select);
			//print_r("$select");	 
			
			if(!is_null($rowMultiplo)){
				//====================Operaciones para convertir unidad minima====================================================== 
				$cantidad = $producto['cantidad'] * $rowMultiplo->cantidad;
				$precioUnitario = $producto['precioUnitario'] / $rowMultiplo->cantidad;
				//print_r($precioUnitario);
				
				$mMovtos = array(
					'idProducto' => $producto['descripcion'],
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idEmpresas'=>$encabezado['idEmpresas'],
					'idSucursal'=>$encabezado['idSucursal'],
					'idCoP'=>$encabezado['idCoP'],
					'idProyecto'=>$encabezado['idProyecto'],
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
			}else{
				echo "Multiplo Incorrecto";
			}
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
	
	public function guardaPago (array $encabezado, $formaPago,$productos){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
		$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
		try{
			$secuencial=0;	
			$tablaCuentasxp = $this->tablaCuentasxp;
			$select = $tablaCuentasxp->select()->from($tablaCuentasxp)->where("numeroFolio=?",$encabezado['numFolio'])
			->where("idCoP=?",$encabezado['idCoP'])->where("idSucursal=?",$encabezado['idSucursal'])->where("fechaPago=?", $stringIni)->order("secuencial DESC");
			$rowCuentasxp = $tablaCuentasxp->fetchRow($select); 
			if(!is_null($rowCuentasxp)){
				$secuencial= $rowCuentasxp->secuencial +1;
			}else{
				$secuencial = 1;	
			}
			$mCuentasxp = array(
				'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
				'idSucursal'=>$encabezado['idSucursal'],
				'idCoP'=>$encabezado['idCoP'],
				//'idFactura'=>$encabezado['idFactura'],
				'idBanco'=>$formaPago['idBanco'],
				'idDivisa'=>$formaPago['idDivisa'],
				'numeroFolio'=>$encabezado['numFolio'],
				'numeroReferencia'=>"",
				'secuencial'=>$secuencial,
				'estatus'=>"A",
				'fechaPago'=>$stringIni,
				'fecha'=>date('Y-m-d h:i:s', time()),
				'formaLiquidar'=>$formaPago['formaLiquidar'],
				'conceptoPago'=>$formaPago['conceptoPago'],
				'subTotal'=>0,
				'total'=>$formaPago['importePago']
			);   
			//print_r($mCuentasxp);
			$dbAdapter->insert("Cuentasxp",$mCuentasxp);
		}catch(exception $ex){
			print_r("================");
			print_r("<br />");
			print_r("Excepcion Lanzada");
			print_r("<br />");
			print_r("================");
			print_r("<br />");
			print_r($ex->getMessage());
			print_r("<br />");
			$dbAdapter->rollBack();
		}	
	}

	public function actulizaProducto(array $encabezado, $formaPago, $producto){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();	
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
		$stringIni = $fechaInicio->toString('YY-mm-dd');
		try{
			$tablaProducto = $this->tablaProducto;
			$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?",$producto["descripcion"]);
			$rowProducto = $tablaProducto->fetchRow($select);
			//Convertimos la unidad del producto
			$tablaMultiplos = $this->tablaMultiplos;
			$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
			$rowMultiplo = $tablaMultiplos->fetchRow($select); 
			$cantidad = $producto['cantidad'] * $rowMultiplo["cantidad"];
			$precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
			if(!is_null($rowProducto && !is_null($rowMultiplo))){
				$claveProducto = substr($rowProducto->claveProducto, 0,2);
				//print_r($claveProducto);print_r("<br />");
				switch($claveProducto){
					case 'PT':
						$tablaCapas = $this->tablaCapas;
						$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['descripcion']);
						$rowCapas = $tablaCapas->fetchRow($select);
						if(is_null($rowCapas)){
							$mCapas = array(
								'idSucursal'=>$encabezado['idSucursal'],
								'numeroFolio'=>$formaPago["idDivisa"],
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
						//print_r("<br />");print_r($costoCliente);
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
							//Actuliza, fecha, costoUnitrio, costoCliente
							$rowInventario->fecha = date('Y-m-d h:i:s', time());
							$rowInventario->costoUnitario = $precioUnitario;
							$rowInventario->costoCliente = $costoCliente;
							$rowInventario->save();
						}		
					break;
					case 'VS':
						//No registramos  en Capas, si no existe en Inventario lo registra solo una vez, pero nunca actuliaza  
						$tablaInventario = $this->tablaInventario;
						$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
						$rowInventario = $tablaInventario->fetchRow($select);
						$costoCliente = $precioUnitario * ($rowInventario["porcentajeGanancia"] / 100) + $precioUnitario;
						print_r("<br />");print_r("$select");
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
						$tablaInventario = $this->tablaInventario;
						$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
						$rowInventario = $tablaInventario->fetchRow($select);
						$costoCliente = $precioUnitario * ($rowInventario["porcentajeGanancia"] / 100) + $precioUnitario;
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
						//Creamos o actualizamos Capas y Inventario
						$tablaCapas = $this->tablaCapas;
						$select = $tablaCapas->select()->from($tablaCapas)->where("numeroFolio=?",$encabezado['numFolio'])->where("fechaEntrada=?", $stringIni)->order("secuencial DESC");
						$precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
						$rowCapas = $tablaCapas->fetchRow($select); 
						if(!is_null($rowCapas)){
							$secuencial= $rowCapas->secuencial +1;
						}else{
							$secuencial = 1;	
						}
						$mCapas = array(
							'idProducto' => $producto['descripcion'],
							'idDivisa'=>$formaPago["idDivisa"],
							'idSucursal'=>$encabezado['idSucursal'],
							'numeroFolio'=>$encabezado['numFolio'],
							'secuencial'=>$secuencial,
							'cantidad'=>$cantidad,
							'fechaEntrada'=>$stringIni,
							'costoUnitario'=>$precioUnitario
						);
		 				$dbAdapter->insert("Capas", $mCapas);
						//Movimiento en Inventario
						$tablaInventario = $this->tablaInventario;
						$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
						$rowInventario = $tablaInventario->fetchRow($select);
						$cantidadI = $rowInventario["existencia"] + $cantidad;
						$costoCliente = $precioUnitario * ($rowInventario["porcentajeGanancia"] / 100) + $precioUnitario;
						//print_r("<br />");print_r("$select");
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
								'idDivisa'=>$formaPago["idDivisa"],
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
						$rowsProductosComp = $tablaProdComp->fetchAll($select);
						//print_r("Actualiza en Producto Terminado");print_r("$select");print_r("<br />");
						if(!is_null($rowsProductosComp)){
							foreach ($rowsProductosComp as $rowProductosComp) {
								$rowProductosComp['costoUnitario']  = $precioUnitario;
								$rowProductosComp->save();
								$tablaProdEnl = $this->tablaProductoCompuesto;
								$select = $tablaProdEnl->select()->from($tablaProdEnl)->where("idProducto=?",$rowProductosComp["idProducto"]);
								$rowsProductosEnl = $tablaProdEnl->fetchAll($select);
								//print_r("<br />");print_r("$select");print_r("<br />");
							}
						}
					}//sw	
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

	public function saldoBanco($formaPago ,$productos){
		$tablaBanco = $this->tablaBanco;
		$where = $tablaBanco->getAdapter()->quoteInto("idBanco = ?", $formaPago['idBanco']);
		$rowBanco = $tablaBanco->fetchRow($where);
		$importePago = $rowBanco->saldo - $productos[0]['importe'];
		$tablaBanco->update(array('saldo'=> $importePago), $where);	
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
				//print_r($cantidad); print_r($precioUnitario);
				if(!is_null($rowProducto && !is_null($rowMultiplo))){
					$claveProducto = substr($rowProducto->claveProducto, 0,2);
					if($claveProducto <> 'PT' || $claveProducto <> 'VS' || $claveProducto <> 'SV' ){
						$tablaProdComp = $this->tablaProductoCompuesto;
						$select = $tablaProdComp->select()->from($tablaProdComp)->where("productoEnlazado=?",$producto["descripcion"]);
						$rowsProductosComp = $tablaProdComp->fetchAll($select);
						//print_r("$select");print_r("<br />");
						if(!is_null($rowsProductosComp)){
							foreach($rowsProductosComp as $rowProductoComp){
								//Actualizamos costo en Capas y Inventario.
								$tablaProdComp = $this->tablaProductoCompuesto;
								$select = $tablaProdComp->select()->from($tablaProdComp, new Zend_Db_Expr('sum(cantidad * costoUnitario) as total'))->where("idProducto=?",$rowProductoComp["idProducto"]);
								$rowsProductosCompxp = $tablaProdComp->fetchRow($select);
								//print_r("<br />");print_r("El total del producto terminado");print_r("<br />");print_r("$select");
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
								//print_r("<br />");print_r("$select");print_r("<br />");
								if(!is_null($rowsProductosCompxEnl)){
									foreach($rowsProductosCompxEnl as $rowProductoCompxEnl){
										//Actulizamos el nuevo costo
										$rowProductoCompxEnl->costoUnitario = $total;
										$rowProductoCompxEnl->save();
										//Sumamos el nuevo costo
										$tablaProdComp = $this->tablaProductoCompuesto;
										$select = $tablaProdComp->select()->from( $tablaProdComp,new Zend_Db_Expr('sum(cantidad * costoUnitario) as total'))->where("idProducto=?",$rowProductoCompxEnl["idProducto"]);
										$rowsProductosCompEnl = $tablaProdComp->fetchRow($select);
										//print_r("$select");
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
				}//rowProducto y multiplo*/
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

