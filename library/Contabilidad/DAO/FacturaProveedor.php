	<?php
	/**
	 * @author Areli Morales Palma
	 * @copyright 2016, Zazil Consultores S.A. de C.V.
	 * @version 1.0.0
	 */
	class Contabilidad_DAO_FacturaProveedor implements Contabilidad_Interfaces_IFacturaProveedor{
		
		private $tablaFactura;
		private $tablaFacturaDetalle;
		private $tablaImpuestos;
		
		private $tablaMovimiento;
		private $tablaInventario;
		private $tablaCapas;
		private $tablaMultiplos;
		private $tablaEmpresa;
		private $tablaBanco;
		private $tablaProveedor;
		private $tablaUnidad;
		private $tablaImpuestoProductos;
		private $tablaFacturaImpuesto;
		
		public function __construct() {
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			
			
			$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
			$this->tablaFacturaDetalle = new Contabilidad_Model_DbTable_FacturaDetalle(array('db'=>$dbAdapter));
		
			$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
			$this->tablaCapas = new Contabilidad_Model_DbTable_Capas(array('db'=>$dbAdapter));
			$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario(array('db'=>$dbAdapter));
			$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos(array('db'=>$dbAdapter));
			$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
			$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
			$this->tablaBanco = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
			$this->tablaProveedor = new Sistema_Model_DbTable_Proveedores(array('db'=>$dbAdapter));
			$this->tablaUnidad = new Inventario_Model_DbTable_Unidad(array('db'=>$dbAdapter));
			$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
			$this->tablaImpuestoProductos = new Contabilidad_Model_DbTable_ImpuestoProductos(array('db'=>$dbAdapter));
			$this->tablaFacturaImpuesto = new Contabilidad_Model_DbTable_FacturaImpuesto(array('db'=>$dbAdapter));
			
			$this->tablaFacturaImpuesto = new Inventario_Model_DbTable_Inventario(array('db'=>$dbAdapter));
		}
		
			
		public function guardaFactura(array $encabezado, $importe, $formaPago, $productos)
		{
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$dbAdapter->beginTransaction();
				
			$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
			$stringFecha = $fechaInicio->toString('YY-mm-dd');
			
			try{
		 		//Valida que la factura no exista
				$tablaFactura = $this->tablaFactura;
				$select = $tablaFactura->select()->from($tablaFactura)->where("idTipoMovimiento = ?",$encabezado['idTipoMovimiento'])->where("numeroFactura=?",$encabezado['numeroFactura'])
				->where("idCoP=?",$encabezado['idCoP'])->where("idSucursal=?",$encabezado['idSucursal']);
				$rowFactura = $tablaFactura->fetchRow($select);
				print_r("$select");
				if(!is_null($rowFactura)){
				 	echo"La factura ya esta registrada";
				}else{
					//Situacion de Pago $conceptoPago = array('AN'=>'ANTICIPO','LI'=>'LIQUIDACION','PA'=>'PAGO','PE'=>'PENDIENTE DE PAGO');
					$conceptoPago;
					if(($formaPago['pagada'])==="1"){
						$conceptoPago = "LI";
					}elseif(($formaPago['pagada'])=== "0"){
						$conceptoPago = "PE";
					}elseif($formaPago['pagos']===""){
						$conceptoPago = "PA";
					}
					
					//Guarda Movimiento en tabla factura
					$mFactura = array(
						'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
						'idSucursal'=>$encabezado['idSucursal'],
						'idCoP'=>$encabezado['idCoP'],
						'idDivisa'=>$formaPago['idDivisa'],
						'numeroFactura'=>$encabezado['numeroFactura'],
						'estatus'=>"A",
						'conceptoPago'=>$conceptoPago,
						'descuento'=>$importe[0]['descuento'],
						'formaPago'=>$formaPago['formaLiquidar'],
						'fechaFactura'=>$stringFecha,
						'subTotal'=>$importe[0]['subTotal'],
						'total'=>$importe[0]['total'],
						'folioFiscal'=>$encabezado['folioFiscal'],
						'importePago'=>$formaPago['pagos'],
					);
					print_r($mFactura);
					$dbAdapter->insert("Factura", $mFactura);
					//Obtine el ultimo id en tabla factura
					$idFactura = $dbAdapter->lastInsertId("Factura","idFactura");
					print_r($idFactura);
					//Guarda Movimiento en Cuentasxp
					if(($formaPago['pagada'])==="1"){
					$mCuentasxp = array(
						'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
						'idSucursal'=>$encabezado['idSucursal'],
						'idFactura'=>$idFactura,
						'idCoP'=>$encabezado['idCoP'],
						'idBanco'=>$formaPago['idBanco'],
						'idDivisa'=>$formaPago['idDivisa'],
						'numeroFolio'=>$encabezado['numeroFactura'],
						'secuencial'=>1,
						'fechaCaptura'=>date("Y-m-d H:i:s", time()),
						'fechaPago'=>$stringFecha,//Revisar fecha en pagos factura proveedor
						'estatus'=>"A",
						'numeroReferencia'=>$formaPago['numeroReferencia'],
						'conceptoPago'=>$conceptoPago,
						'formaLiquidar'=>$formaPago['formaLiquidar'],
						'subTotal'=>$importe[0]['subTotal'],
						'total'=>$importe[0]['total']	
					);
					
					//print_r($mCuentasxp);
					$dbAdapter->insert("Cuentasxp", $mCuentasxp);
					}
					//Guarda impuestoFactura
				
					print_r($idFactura);
					//Obtine el ultimo id en tabla factura
				//$idFactura = $bd->lastInsertId("Factura","idFactura");
				$tablaFactura = $this->tablaFactura;
				$select = $tablaFactura->select()->from($tablaFactura,array(new Zend_Db_Expr('max(idFactura) as idFactura')));
				$rowIdFactura =$tablaFactura->fetchRow($select);
				$idFactura = $rowIdFactura['idFactura'];
				print_r("$select");
				if(!is_null($rowIdFactura)){
					$mfacturaImpuesto = array(
						'idFactura'=>$idFactura ,
						'idImpuesto'=>15,
						'importe'=>$importe[0]['iva'],	
					);
				
					$dbAdapter->insert("FacturaImpuesto", $mfacturaImpuesto);
						
					}
		
				}

				$tablaFactura = $this->tablaFactura;
				$select = $tablaFactura->select()->from($tablaFactura,array(new Zend_Db_Expr('max(idFactura) as idFactura')));
				$rowIdFactura =$tablaFactura->fetchRow($select);
				$idFactura = $rowIdFactura['idFactura'];
				print_r("$select");
				
				if($importe[0]['ieps']<>0){
						$mfacturaImpuesto = array(
						'idFactura'=>$idFactura ,
						'idImpuesto'=>24,
						'importe'=>$importe[0]['ieps'],
						);
						$dbAdapter->insert("FacturaImpuesto", $mfacturaImpuesto);
						
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
		
		public function actualizarSaldoBanco($formaPago){
			//$saldo = $formaPago[]
			
			$tablaBanco = $this->tablaBanco;
			$select = $tablaBanco->select()->from($tablaBanco)->where("idBanco = ?",$formaPago['idBanco']);
			$row = $tablaBanco->fetchRow($select);
			//$saldo = 0;
			$saldo = $row['saldo'] - $formaPago['pagos'];
			print_r("<br />");
			print_r("<br />");
			print_r($saldo);
			print_r("<br />");
			$where = $tablaBanco->getAdapter()->quoteInto("idBanco=?",$formaPago['idBanco']);
			
			//$tablaBanco->update(array('saldo'=> $saldo,'fecha'=>$encabezado['fecha']));
			$tablaBanco->update(array ("saldo" => $saldo), $where);
			//print_r("$select");
			
		}
		
		public function actualizaSaldoProveedor($encabezado, $formaPago){
			$tablaProveedor = $this->tablaProveedor;
			$select = $tablaProveedor->select()->from($tablaProveedor)->where("idProveedores =? ",$encabezado['idCoP']);
			$row = $tablaProveedor->fetchRow($select);
			$saldoProveedor = $row['saldo'] - $formaPago['pagos'];
			$where = $tablaProveedor->getAdapter()->quoteInto("idProveedores = ?", $encabezado['idCoP']);
			$tablaProveedor->update(array("saldo" =>$saldoProveedor), $where);
				
		}
		
		public function guardaDetalleFactura(array $encabezado, $producto, $importe){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$dbAdapter->beginTransaction();
		
			$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
			$stringFecha = $fechaInicio->toString('YY-mm-dd');
			
			try{
				$secuencial = 0;	
				$tablaMovimiento = $this->tablaMovimiento;
				$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numeroFactura'])
				->where("idCoP=?",$encabezado['idCoP'])
				->where("idSucursal=?",$encabezado['idSucursal'])
				->where("numeroFolio=?",$encabezado['numeroFactura'])
				->where("fecha=?", $stringFecha)
				->order("secuencial DESC");
				$rowMovimiento = $tablaMovimiento->fetchRow($select); 
				
				if(!is_null($rowMovimiento)){
					$secuencial= $rowMovimiento->secuencial +1;
				}else{
					$secuencial = 1;	
				}
				
				
		 		$tablaMultiplos = $this->tablaMultiplos;
				$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
				$rowMultiplo = $tablaMultiplos->fetchRow($select);
				print_r("$select"); 
				//if(!is_null($rowMultiplo)){
					//====================Operaciones para convertir unidad minima====================================================== 
					$cantidad=0;
					$precioUnitario=0;
					$cantidad = $producto['cantidad'] * $rowMultiplo->cantidad;
					$precioUnitario = $producto['precioUnitario'] / $rowMultiplo->cantidad;
					$tablaFactura = $this->tablaFactura;
					
					$select = $tablaFactura->select()->from($tablaFactura,array(new Zend_Db_Expr('max(idFactura) as idFactura')));
					$rowIdFactura =$tablaFactura->fetchRow($select);
					$idFactura = $rowIdFactura['idFactura'];
					print_r($idFactura);
					//=======================Obtiene la unidad
					$tablaUnidad= $this->tablaUnidad;
					$select = $tablaUnidad->select()->from($tablaUnidad)->where("idUnidad=?", $producto['unidad']);
					$rowUnidad = $tablaUnidad->fetchRow($select);
					
					if(! is_null($rowUnidad)){
						//Guarda Movimiento en tabla Movimientos
						$mMovimiento = array(
							'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
							'idEmpresas'=>$encabezado['idEmpresas'],
							'idSucursal'=>$encabezado['idSucursal'],
							'idCoP'=>$encabezado['idCoP'],
							'numeroFolio'=>$encabezado['numeroFactura'],
							'idFactura'=>$idFactura,//
							'idProducto'=>$producto['descripcion'],
							'idProyecto'=>$encabezado['idProyecto'],
							'cantidad'=>$cantidad,
							'fecha'=>$stringFecha,
							'secuencial'=>$secuencial,
							'estatus'=>"A",
							'costoUnitario'=>$precioUnitario,
							'totalImporte'=>$producto['importe']
						);
					 	$dbAdapter->insert("Movimientos",$mMovimiento);
						$tablaProducto = $this->tablaProducto;
						$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto = ?", $producto['descripcion']);
						$rowProducto = $tablaProducto->fetchRow($select);
						$desProducto =$rowProducto['producto']; 
					
						//Insertar Movimiento en tabla FacturaDetalle
						$mFacturaDetalle = array(
							'idFactura'=>$idFactura,
							'idUnidad'=>$producto['unidad'],
							'secuencial'=>$secuencial,
							'cantidad'=>$cantidad,
							'descripcion'=>$desProducto,
							'precioUnitario'=>$precioUnitario,
							'importe'=>$producto['importe'],
							'fechaCaptura'=>$stringFecha,
							'fechaCancela'=>null
						);
				 		$dbAdapter->insert("FacturaDetalle",$mFacturaDetalle);
				//}else{
					//echo "El multiplo no existe";
				//}
	
				}
				//Inventario
				$tablaInventario = $this->tablaInventario;
		$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
		$rowInventario = $tablaInventario->fetchRow($select);
		
		if(!is_null($rowInventario)){
			$cantidad = $rowInventario->existencia + $cantidad;
			$costoCliente = ($rowInventario->costoUnitario * ($rowInventario->porcentajeGanancia / 100) + $rowInventario->costoUnitario);
			print ("<br />");
			print ($cantidad);
			$where = $tablaInventario->getAdapter()->quoteInto("idProducto = ?", $rowInventario->idProducto);	
			$tablaInventario->update(array('existencia'=> $cantidad,'existenciaReal'=> $cantidad,'existenciaReal'=> $cantidad), $where);	
			//print_r("<br />");
		}else{		
			$mInventario = array(
					'idProducto'=>$producto['descripcion'],
					'idDivisa'=>1,
					'idSucursal'=>$encabezado['idSucursal'],
					'existencia'=>$cantidad,
					'apartado'=>'0',
					'existenciaReal'=>$cantidad,
					'maximo'=>'0',
					'minimo'=>'0',
					'fecha'=>$stringFecha,
					'costoUnitario'=>$precioUnitario,
					'porcentajeGanancia'=>'0',
					'cantidadGanancia'=>'0',
					'costoCliente'=>(($rowInventario->porcentajeGanancia / 100)) 
				);
			$dbAdapter->insert("Inventario",$mInventario);
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