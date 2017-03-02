<?php
class Contabilidad_DAO_FacturaCliente implements Contabilidad_Interfaces_IFacturaCliente{
	private $tablaMovimiento;
	private $tablaFactura;
	private $tablaClientes;
	private $tablaCuentasxc;
	private $tablaBanco;
	private $tablaEmpresas;
	private $tablaSucursal;
	private $tablaMultiplos;
	private $tablaProducto;
	
	private $tablaEmpresa;
	private $tablaImpuestoProductos;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
		//$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
		$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes(array('db'=>$dbAdapter));
		$this->tablaCuentasxc = new Contabilidad_Model_DbTable_Cuentasxc(array('db'=>$dbAdapter));
		$this->tablaBanco = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas(array('db'=>$dbAdapter));
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
		$this->tablaSucursal = new Sistema_Model_DbTable_Sucursal(array('db'=>$dbAdapter));
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos(array('db'=>$dbAdapter));
		$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
		
		
		$this->tablaImpuestoProductos = new Contabilidad_Model_DbTable_ImpuestoProductos(array('db'=>$dbAdapter));
	}
	public function guardaDetalleFactura(array $encabezado, $producto, $importe){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$dbAdapter->beginTransaction();
		
			$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
			$stringFecha = $fechaInicio->toString ('yyyy-MM-dd');
			
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
					//print_r($secuencial);
				}else{
					$secuencial = 1;	
					//print_r($secuencial);
				}
				
				
		 		$tablaMultiplos = $this->tablaMultiplos;
				$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
				$rowMultiplo = $tablaMultiplos->fetchRow($select); 
				
				print_r("select");
				
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
			
				
				if(is_null($rowMovimiento)){
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
	
	
	public function guardaFactura(array $encabezado, $importe, $formaPago, $productos){
		
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
			//print_r("$select");
			
			if(! is_null($rowFactura)){
				print_r("La Factura Ya existe");
			 }else{
				print_r("Puede crear Factura");
				$conceptoPago;
				if(($formaPago['pagada'])==="1"){
					$conceptoPago = "LI";
				}elseif(($formaPago['Pagada'])=== "0"){
					$conceptoPago = "PA";
				}elseif($formaPago['pagos']===""){
					$conceptoPago = "PE";
				}	
				//Guarda Movimiento en tabla factura
				$mFactura = array(
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idSucursal'=>$encabezado['idSucursal'],
					'idCoP'=>$encabezado['idCoP'],
					'idDivisa'=>$formaPago['divisa'],
					'numeroFactura'=>$encabezado['numeroFactura'],
					'estatus'=>"A",
					'conceptoPago'=>$conceptoPago,
					'descuento'=>100,
					'formaPago'=>$formaPago['formaLiquidar'],
					'fechaFactura'=>$stringFecha,
					'subTotal'=>$importe[0]['subTotal'],
					'total'=>$importe[0]['total'],
					'folioFiscal'=>$encabezado['folioFiscal'],
					'importePago'=>$importe[0]['total']
				);
					
				$dbAdapter->insert("Factura", $mFactura);
				//Obtine el ultimo id en tabla factura
				$idFactura = $dbAdapter->lastInsertId("Factura","idFactura");	
				if($formaPago['pagos']!= 0 ){
					print_r("Cantidad como pago en la factura");
				}elseif($formaPago['pagada']==="1"){
					print_r("Cantidad como pago en la factura");
				}
				//Guarda Movimiento en Cuentasxp
				$mCuentasxc = array(
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idSucursal'=>$encabezado['idSucursal'],
					'idFactura'=>$idFactura,
					'idCoP'=>$encabezado['idCoP'],
					'idBanco'=>$formaPago['idBanco'],
					'idDivisa'=>$formaPago['divisa'],
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
				//print_r($mCuentasxc);
				$dbAdapter->insert("Cuentasxc", $mCuentasxc);
						
				//Obtine el ultimo id en tabla factura
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
	public function actualizaSaldoCliente($encabezado, $formaPago){
		
		$tablaClientes = $this->tablaClientes;
		$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente =? ",$encabezado['idCoP']);
		$row = $tablaClientes->fetchRow($select);
		$saldoCliente = $row['saldo'] - $formaPago['pagos'];
		$where = $tablaClientes->getAdapter()->quoteInto("idCliente = ?", $encabezado['idCoP']);
		$tablaClientes->update(array("saldo" =>$saldoCliente), $where);
		
	}
	
	
	public function consecutivoEmpresa($encabezado){
		
		$consecutivo = $encabezado['numeroFactura'];
		
		$tablaSucursal = $this->tablaSucursal;
		$select = $tablaSucursal->select()->from($tablaSucursal)->where("idFiscales = ?",$encabezado['idEmpresas'])->where("idSucursal = ?",$encabezado['idSucursal']);
		$rowSucursal = $tablaSucursal->fetchRow($select);
		
		if(!is_null($rowSucursal)){
			$where = $tablaSucursal->getAdapter()->quoteInto("idSucursal=?",$encabezado['idSucursal']);
			$tablaSucursal->update(array("consecutivo"=>$consecutivo), $where);
		}
	
	}
	
	public function guardaImportesImpuesto(array $encabezado, $importe, $producto){
		/*if(! is_null($rowImpuestoProductos)){
			print_r("Select de producto Terminado");
			print_r("$select");
		}else{
			print_r("la consulta esta vacia");
		}*/
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		
		$tablaImpuestoProductos = $this->tablaImpuestoProductos;
		$select = $tablaImpuestoProductos->select()->from($tablaImpuestoProductos)->where("idProducto=?",$producto['descripcion']);
		$rowImpuestoProductos =$tablaImpuestoProductos->fetchRow($select);
		
		$idImpuesto = $rowImpuestoProductos->idImpuesto;
		print_r("$select");
		$tablaFactura = $this->tablaFactura;
		$select = $tablaFactura->select()->from($tablaFactura,array(new Zend_Db_Expr('max(idFactura) as idFactura')));
		$rowIdFactura =$tablaFactura->fetchRow($select);
		$idFactura = $rowIdFactura['idFactura'];
		
		
		print_r($idImpuesto);
		try{
			if(! is_null($rowImpuestoProductos)){
			$mFacturaImpuesto = array(
				'idFactura'=>$idFactura,
				'idImpuesto'=>$idImpuesto,
				'importe'=>0,
			);
			$dbAdapter->insert("FacturaImpuesto",$mFacturaImpuesto);
			}else{
				print_r("El producto no esta enlazado con impuesto");
			}
			$dbAdapter->commit();		
			}catch(Exception $ex){
				$dbAdapter->rollBack();
				print_r($ex->getMessage());				
				throw new Util_Exception_BussinessException("Error");
		}		
	}
	
	public function guardaIva(array $encabezado, $importe){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		
		
		$tablaFactura = $this->tablaFactura;
		$select = $tablaFactura->select()->from($tablaFactura,array(new Zend_Db_Expr('max(idFactura) as idFactura')));
		$rowIdFactura =$tablaFactura->fetchRow($select);
		$idFactura = $rowIdFactura['idFactura'];
		
		try{
			if(!is_null($importe[0]['iva'])){
			$mFacturaImpuesto = array(
				'idFactura'=>$idFactura,
				'idImpuesto'=>15,
				'importe'=>$importe[0]['iva']
			);
			$dbAdapter->insert("FacturaImpuesto",$mFacturaImpuesto);
			}else{
				$mFacturaImpuesto = array(
				'idFactura'=>$idFactura,
				'idImpuesto'=>15,
				'importe'=>0
			);
			$dbAdapter->insert("FacturaImpuesto",$mFacturaImpuesto);	
			}
			$dbAdapter->commit();		
			}catch(Exception $ex){
				$dbAdapter->rollBack();
				print_r($ex->getMessage());				
				throw new Util_Exception_BussinessException("Error");
		}		
	}
		
	
	
}
    
?>