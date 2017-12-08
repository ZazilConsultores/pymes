<?php
class Contabilidad_DAO_FacturaCliente implements Contabilidad_Interfaces_INotaCredito{
	
	private $tablaMovimiento;
	private $tablaFactura;
	private $tablaClientes;
	private $tablaCuentasxc;
	private $tablaCardex;
	private $tablaBanco;
	private $tablaEmpresas;
	private $tablaSucursal;
	private $tablaMultiplos;
	private $tablaProducto;
	private $tablaEmpresa;
	private $tablaImpuestoProductos;
	private $tablaConsecutivo;
	private $tablaProductoCompuesto;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
		$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes(array('db'=>$dbAdapter));
		$this->tablaCuentasxc = new Contabilidad_Model_DbTable_Cuentasxc(array('db'=>$dbAdapter));
		$this->tablaCardex = new Contabilidad_Model_DbTable_Cardex(array('db'=>$dbAdapter));
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas(array('db'=>$dbAdapter));
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
		$this->tablaSucursal = new Sistema_Model_DbTable_Sucursal(array('db'=>$dbAdapter));
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos(array('db'=>$dbAdapter));
		$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
		$this->tablaImpuestoProductos = new Contabilidad_Model_DbTable_ImpuestoProductos(array('db'=>$dbAdapter));
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario(array('db'=>$dbAdapter));
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas(array('db'=>$dbAdapter));
		$this->tablaConsecutivo = new Contabilidad_Model_DbTable_Consecutivo(array('db'=>$dbAdapter));
		$this->tablaProductoCompuesto = new Inventario_Model_DbTable_ProductoCompuesto(array('db'=>$dbAdapter));
		
			
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
				
				if(($formaPago['pagada']) == "1"){
					$conceptoPago = "LI";
					$importePagado = $importe[0]['total'];
					print_r($importePagado);
					$saldo = 0;
				}elseif(($formaPago['pagada'])== "0" AND $formaPago['pagos'] =="0"){
					$conceptoPago = "PE";
					$importePagado = 0;
					$saldo = $importe[0]['total'];
				}elseif($formaPago['pagos'] <> 0 AND $formaPago['pagos'] <> $importe[0]['total']){
					$conceptoPago = "PA";
					$importePagado = $formaPago['pagos'];
					$saldo = $importe[0]['total']- $formaPago['pagos'];
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
					'descuento'=>$importe[0]['descuento'],
					'formaPago'=>$formaPago['formaLiquidar'],
					'fecha'=>$stringFecha,
					'subTotal'=>$importe[0]['subTotal'],
					'total'=>$importe[0]['total'],
					'saldo'=>$saldo,
					'folioFiscal'=>$encabezado['folioFiscal'],
					'importePagado'=>$importePagado
				);
					
				$dbAdapter->insert("Factura", $mFactura);
				//Obtine el ultimo id en tabla factura
				$idFactura = $dbAdapter->lastInsertId("Factura","idFactura");	
				if($formaPago['pagos']!= 0 ){
					print_r("Cantidad como pago en la factura");
				}elseif($formaPago['pagada']==="1"){
					print_r("Cantidad como pago en la factura");
				}
				//Guarda em facturaImpuesto
				$mfImpuesto = array(
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idFactura'=>$idFactura,
					'idImpuesto'=>4, //Iva
					'importe'=>$importe[0]['iva']
				);
					//print_r($mfImpuesto);
				$dbAdapter->insert("FacturaImpuesto", $mfImpuesto);
				//Guarda Movimiento en Cuentasxp
				if(($formaPago['pagada'])==="1"){
				$mCuentasxc = array(
					'idTipoMovimiento'=>16,
					'idSucursal'=>$encabezado['idSucursal'],
					'idFactura'=>$idFactura,
					'idCoP'=>$encabezado['idCoP'],
					'idBanco'=>$formaPago['idBanco'],
					'idDivisa'=>$formaPago['divisa'],
					'numeroFolio'=>$encabezado['numeroFactura'],
					'secuencial'=>1,
					'fecha'=>date("Y-m-d H:i:s", time()),
					'fechaPago'=>$stringFecha,//Revisar fecha en pagos factura proveedor
					'estatus'=>"A",
					'numeroReferencia'=>$formaPago['numeroReferencia'],
					'conceptoPago'=>$conceptoPago,
					'formaLiquidar'=>$formaPago['formaLiquidar'],
					'subTotal'=>$importe[0]['subTotal'],
					'total'=>$importe[0]['total']	
				);
				
				$dbAdapter->insert("Cuentasxc", $mCuentasxc);
				//Guarda em facturaImpuesto
				$mfImpuesto = array(
					'idTipoMovimiento'=>16,
					'idFactura'=>$idFactura,
					'idImpuesto'=>4, //Iva
					'importe'=>$importe[0]['iva']
				);	
				print_r($mfImpuesto);
				$dbAdapter->insert("FacturaImpuesto", $mfImpuesto);
				}
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
	
	public function guardaDetalleFactura(array $encabezado, $producto, $importe){
			
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringFecha = $fechaInicio->toString ('yyyy-MM-dd');
			
		try{
			//Valida que la factura no exista
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idTipoMovimiento = ?",$encabezado['idTipoMovimiento'])->where("numeroFactura=?",$encabezado['numeroFactura'])
			->where("idCoP=?",$encabezado['idCoP'])->where("idSucursal=?",$encabezado['idSucursal']);
			$rowFactura = $tablaFactura->fetchRow($select);
			print_r("$select");
			if(!is_null($rowFactura)){
				//Buscamos en Movimientos, para asignar secuencial
				$tablaMovimiento = $this->tablaMovimiento;	
				$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numeroFactura'])
				->where("idCoP=?",$encabezado['idCoP'])
				->where("idSucursal=?",$encabezado['idSucursal'])
				->where("fecha=?", $stringFecha)
				->order("secuencial DESC");			
				$rowMovimiento = $tablaMovimiento->fetchRow($select); 
				
				if(!is_null($rowMovimiento)){
					$secuencial= $rowMovimiento->secuencial +1;
				}else{
					$secuencial = 1;	
				}
				//====================Operaciones para convertir unidad minima======================================================
				$tablaMultiplos = $this->tablaMultiplos;
				$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['claveProducto'])->where("idUnidad=?",$producto['unidad']);
				$rowMultiplo = $tablaMultiplos->fetchRow($select);
				
				$cantidad=0;
				$precioUnitario=0;
				$cantidad = $producto['cantidad'] * $rowMultiplo->cantidad;
				$precioUnitario = $producto['precioUnitario'] / $rowMultiplo->cantidad;
				//Obtenemos el últiomo idFactura
				$tablaFactura = $this->tablaFactura;
				$select = $tablaFactura->select()->from($tablaFactura,array(new Zend_Db_Expr('max(idFactura) as idFactura')));
				$rowIdFactura =$tablaFactura->fetchRow($select);
				$idFactura = $rowIdFactura['idFactura'];
				//print_r($idFactura); 
				//Guarda Movimiento en tabla Movimientos
				$mMovimiento = array(
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idEmpresas'=>$encabezado['idEmpresas'],
					'idSucursal'=>$encabezado['idSucursal'],
					'idCoP'=>$encabezado['idCoP'],
					'numeroFolio'=>$encabezado['numeroFactura'],
					'idFactura'=>$idFactura,//
					'idProducto'=>$producto['claveProducto'],
					'idProyecto'=>$encabezado['idProyecto'],
					'cantidad'=>$cantidad,
					'fecha'=>$stringFecha,
					'secuencial'=>$secuencial,
					'estatus'=>"A",
					'costoUnitario'=>$precioUnitario,
					'totalImporte'=>$producto['importe']
				);
				$dbAdapter->insert("Movimientos",$mMovimiento);
				//Buscamos la descripción del producto en Tabla Producto
				$tablaProducto = $this->tablaProducto;
				$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto = ?", $producto['claveProducto']);
				$rowProducto = $tablaProducto->fetchRow($select);
				$desProducto = $rowProducto['producto'];
				//print_r("La factura detalle");
				//print_r("$select");
				//Insertar Movimiento en tabla FacturaDetalle
				$mFacturaDetalle = array(
					'idFactura'=>$idFactura,
					'idUnidad'=>$producto['unidad'],
					'secuencial'=>$secuencial,
					'cantidad'=>$cantidad,
					'descripcion'=>$producto['descripcion'],
					'precioUnitario'=>$precioUnitario,
					'importe'=>$producto['importe'],
					'fecha'=>$stringFecha,
					'fechaCancela'=>null
				);
				$dbAdapter->insert("FacturaDetalle",$mFacturaDetalle);	 
			}//Factura no existe
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
	
	public function actualizarSaldoBanco($formaPago, $importe){
		$tablaBancos= $this->tablaBanco;
		$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco = ?",$formaPago["idBanco"]);
			$rowBanco = $tablaBancos->fetchRow($select);
			print_r("$select");
			$sBanco = $rowBanco->saldo -  $importe[0]["total"];
			$rowBanco->saldo = $sBanco;
			//$rowBanco->fecha = $stringIni;
			$rowBanco->save();
			//}
		/*$tablaBanco = $this->tablaBanco;
			$select = $tablaBanco->select()->from($tablaBanco)->where("idBanco = ?",$formaPago['idBanco']);
			$row = $tablaBanco->fetchRow($select);
			//$saldo = 0;
			$saldo = $row['saldo'] - $formaPago['pagos'];
			print_r("<br />");
			print_r("<El saldo es: />");
			print_r($saldo);
			print_r("<br />");
			$where = $tablaBanco->getAdapter()->quoteInto("idBanco=?",$formaPago['idBanco']);
			
			//$tablaBanco->update(array('saldo'=> $saldo,'fecha'=>$encabezado['fecha']));
			$tablaBanco->update(array ("saldo" => $saldo), $where);
			//print_r("$select");*/
		
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
		$select = $tablaImpuestoProductos->select()->from($tablaImpuestoProductos)->where("idProducto=?",$producto['claveProducto']);
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
			//$dbAdapter->insert("FacturaImpuesto",$mFacturaImpuesto);
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
		
	/////////////////////////////////////////////////////////////////Inventario y cardex
	public function resta(array $encabezado, $producto){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
		$dbAdapter->beginTransaction();
		$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
		try{
		//======================Resta en capas, inventario============================================================================*//
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['claveProducto'])->where("idUnidad=?",$producto['unidad']);
		$rowMultiplo = $tablaMultiplos->fetchRow($select); 
		
		$cantidad = 0;
		$precioUnitario = 0;
		$cantidad = $producto['cantidad'] * $rowMultiplo->cantidad;
		$precioUnitario = $producto['precioUnitario'] / $rowMultiplo->cantidad;
			
			
		$tablaInventario = $this->tablaInventario;
		//$tablaInventario =$this->ta
		$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['claveProducto']);
		$rowInventario = $tablaInventario->fetchRow($select);
		$restaCantidad = $rowInventario["existencia"] - $cantidad;
		//$restaCantidad = 0;
		//print_r("Cantidad en inventario:");
		print_r("$restaCantidad");
	
		if(!is_null($rowInventario)){
			//print_r("la cantidad en inventario no es menor que 0");
			print_r("<br />");
			$tablaCapas = $this->tablaCapas;
			$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['claveProducto']) 
			->order("fechaEntrada ASC");
			$rowCapas = $tablaCapas->fetchRow($select);
			//print_r("<br />");
			print_r("<br />");
			//print_r("$select");
			//print_r("<br />");
			$cant =  $rowCapas["cantidad"] - $cantidad;
			//print_r("Cant <br />");
			print_r("<br />");
			//print_r("<Cantidad en Capas />");
			print_r("<br />");
			//print_r($cant);
			print_r("<br />");
			
			
		//=====================================================================Resta 
		if(! $cant <= 0){
			
			$where = $tablaCapas->getAdapter()->quoteInto("idProducto =?",$rowCapas["idProducto"],"fechaEntrada =?",$rowCapas["fechaEntrada"] );
			print_r("<br />");
			//print_r("query seleccion producto:");		
			print_r("<br />");
			//print_r("$where");
			print_r("<br />");
			//print_r($cant);
			print_r("<br />");
			//$tablaCapas->update(array('cantidad'=>$cant), $where);
			print_r("<br />");
			print_r("<br />");
			//print_r("$where");
		}else{
		
			$where = $tablaCapas->getAdapter()->quoteInto("fechaEntrada=?", $rowCapas->fechaEntrada,"idProducto =?",$rowCapas->idProducto);	
			//$tablaCapas->delete($where);
		}
		
		//===Resta cantidad en inventario
		$tablaProducto = $this->tablaProducto;
				$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?",$rowInventario['idProducto']);
				$rowProducto = $tablaProducto->fetchRow($select);
				$ProductoInv = substr($rowProducto->claveProducto, 0,2);
				//print_r($ProductoInv);
				//Si el producto es ProductoTerminado o servicio solo se ingresa una vez en inventario	
				//if($ProductoInv != 'PT' && $ProductoInv != 'SV' && $ProductoInv != 'VS'){
		
			$tablaInventario = $this->tablaInventario;
			$where = $tablaInventario->getAdapter()->quoteInto("idProducto=?", $producto['claveProducto']);
			$tablaInventario->update(array('existencia'=>$restaCantidad, 'existenciaReal'=>$restaCantidad),$where);
			//}
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
	public function creaCardex(array $encabezado, $producto){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
		$dbAdapter->beginTransaction();
		
		$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		try{
		$tablaCapas = $this->tablaCapas;
		$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['claveProducto'])
		//->where("fechaEntrada )
		->order("fechaEntrada ASC");
		print_r("$select");
		$rowCapas = $tablaCapas->fetchRow($select);
		
		//=======================================Seleccionar tabla Movimiento
		$tablaMovimiento = $this->tablaMovimiento;
		$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("idProducto =?", $producto['claveProducto'])
			->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])
			->where("idCoP=?",$encabezado['idCoP'])
			->where("idEmpresas=?",$encabezado['idEmpresas'])
			->where("fecha=?",$stringIni)
			->order("secuencial DESC");
			print_r("$select");
		$rowMovimiento = $tablaMovimiento->fetchRow($select); 
		
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['claveProducto'])->where("idUnidad=?",$producto['unidad']);
		$rowMultiplo = $tablaMultiplos->fetchRow($select); 
		//$utilidad =($rowMovimiento["costoUnitario"] - $rowCapas['costoUnitario']) * $rowMovimiento["cantidad"];
		//print_r($utilidad);
		$cantidad = 0;
		$precioUnitario = 0;
		$cantidad = $producto['cantidad'] * $rowMultiplo->cantidad;
		$precioUnitario = $producto['precioUnitario'] / $rowMultiplo->cantidad;
		//SecuencialEntrada 
		$tablaCardex = $this->tablaCardex;
		$select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$encabezado['numeroFactura'])
		->where("idSucursal=?",$encabezado['idSucursal'])
		->where("fechaEntrada=?", $stringIni)
		->order("secuencialEntrada DESC");
		print_r("$select");
		$rowCardex = $tablaCardex->fetchRow($select); 
		if(!is_null($rowCardex)){
			$secuencialSalida= $rowCardex->secuencialSalida + 1;
		}else{
			$secuencialSalida = 1;	
		}
		$costo = $rowMovimiento['cantidad'] * $rowCapas['costoUnitario'];
		$costoSalida= $rowMovimiento['cantidad'] * $producto['precioUnitario'];
		$utilidad = $costoSalida- $costo;
		$mCardex = array(
			'idSucursal'=>$encabezado['idSucursal'],
			'numerofolio'=>$encabezado['numeroFactura'],
			'idProducto'=>$producto['claveProducto'],
			'idDivisa'=>1,
			'secuencialEntrada'=>$rowCapas['secuencial'],
			'fechaEntrada'=>$rowCapas['fechaEntrada'],
			'secuencialSalida'=>$secuencialSalida,
			'fechaSalida'=>$stringIni,
			'cantidad'=>$cantidad,
			'costo'=>$costo,
			'costoSalida'=>$costoSalida,
			'utilidad'=>$utilidad
		);
			print_r($mCardex);
			$dbAdapter->insert("Cardex",$mCardex);
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
	
	/*Actuliza consecutivo por idSucursal*/
	public function editaNumeroFactura($idSucursal){
		$tablaConsecutivo = $this->tablaConsecutivo;
		$select = $tablaConsecutivo->select()->from($tablaConsecutivo)->where("idTipoMovimiento=?",2)->where("idSucursal=?",$idSucursal);
		$rowConsecutivo = $tablaConsecutivo->fetchAll($select);
		return $rowConsecutivo;
		///print_r($select->__toString());
		/*if(is_null($rowConsecutivo)) {
			return null;
		}else{
			return $rowConsecutivo;
		}*/
	}
	
	public function creaFacturaCliente(array $encabezado, $producto, $importe){
		//Seleccionamos el producto para su clasificacion, Ver si la validación del producto se puede hacer desde jquery
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?",$producto["claveProducto"]);
		$rowProducto = $tablaProducto->fetchRow($select);
		
		$tablaInventario = $this->tablaInventario;
		$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$rowProducto["idProducto"]);
		$rowInventario = $tablaInventario->fetchRow($select);
		
		if(!is_null($rowInventario)){
			$claveProducto = substr($rowProducto->claveProducto, 0,2);
			print_r($claveProducto);
			print_r("<br />");
			switch($claveProducto){
				case 'PT':
					print_r("<br />");	
					print_r("Obtine producto PT");
					$tablaProdComp = $this->tablaProductoCompuesto;
					$select = $tablaProdComp->select()->from($tablaProdComp)->where("idProducto=?",$producto["claveProducto"]);
					$rowsProductoComp= $tablaProdComp->fetchAll($select);
					print_r("<br />");
					print_r("$select");
					print_r("<br />");
					//Si no esta vacio, recorremos para ver si esta compuesto por más paquetes
					if(!is_null($rowsProductoComp)){
						foreach($rowsProductoComp as $rowProductoComp){
							$tablaProdComp = $this->tablaProductoCompuesto;
							$select = $tablaProdComp->select()->from($tablaProdComp)->where("productoEnlazado =?",$rowProductoComp["productoEnlazado"]);
							$rowsProductoEnlazado= $tablaProdComp->fetchAll($select);
							print_r("El producto PT esta compuesto por:");
							print_r("<br />");
							print_r("$select");
							print_r("<br />");
							//Si no esta vacio, recorremos para ver si esta inventario
							if(!is_null($rowsProductoEnlazado)){
								foreach($rowsProductoEnlazado as $rowProductoEnlazado){
									$tablaProdComp = $this->tablaProductoCompuesto;
									$select = $tablaProdComp->select()->from($tablaProdComp)->where("idProducto =?",$rowProductoEnlazado["productoEnlazado"]);
									$rowsProductoCompuesto= $tablaProdComp->fetchAll($select);
									print_r("<br />");
									print_r("El producto compuesto esta compuesto por el producto");
									print_r("$select");
									print_r("<br />");
									//Obtenemos los productos del productoCompuesto
									if(!is_null($rowsProductoCompuesto)){
										foreach($rowsProductoCompuesto as $rowProductoCompuesto){
											print_r("Actualizar es:");
											//$producto = $rowProductoCompuesto["productoEnlazado"];
											//print_r($producto);
										}
									}
								}//foreach productoEnlazado
							}//if not null $owsProductoEnlazado
						}//foreach $rowsProductoComp
					}	
				break;
				case 'VS':
					//No actualizamos en ninguna 
					print_r("<br />");
					print_r("Varios Servicio");
				break;
				case 'SV':
					//No actualizamos en ninguna 
					print_r("<br />");
					print_r("Servicio");
				break;
				default:
					print_r("<br />");
					print_r("Producto Normal");
					//Creamos o actualizamos Inventario, Cardex, Capas
				
			}
		}

	}
	public function restaProductoTerminado(array $encabezado, $formaPago, $productos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		//$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
		$stringFecha = $fechaInicio->toString('YY-mm-dd');
		
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$productos[0]["claveProducto"])->where("idUnidad=?",$productos[0]["unidad"]);
		$rowMultiplo = $tablaMultiplos->fetchRow($select); 
		$cantidad = $productos[0]['cantidad'] * $rowMultiplo["cantidad"];
		$precioUnitario = $productos[0]['precioUnitario'] / $rowMultiplo["cantidad"];
		
		if(!is_null(!is_null($rowMultiplo))){
			$tablaProdComp = $this->tablaProductoCompuesto;
			$select = $tablaProdComp->select()->from($tablaProdComp)->where("idProducto=?",$productos[0]["claveProducto"]);
			$rowsProductoComp = $tablaProdComp->fetchAll($select);
			print_r("<br />");
			print_r("$select");
			print_r("<br />");
			if(!is_null($rowsProductoComp)){
				foreach($rowsProductoComp as $rowProductoComp){
					//Esta compuesto por productoEnlazado
					$tablaProdEnl = $this->tablaProductoCompuesto;
					$select = $tablaProdEnl->select()->from($tablaProdEnl)->where("idProducto=?",$rowProductoComp["productoEnlazado"]);
					$rowsProductoEnl= $tablaProdEnl->fetchAll($select);
					if(!is_null($rowsProductoEnl)){
						foreach($rowsProductoEnl as $rowProductoEnl){
							$can = $rowProductoEnl->cantidad * $cantidad ;
							print_r($can);
							print_r("<br />");
							//Buscamos el productoEnlazado en Inventario
							$tablaInventario = $this->tablaInventario;
							$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$rowProductoEnl["productoEnlazado"]);
							$rowsInventario= $tablaInventario->fetchAll($select);
							if(!is_null($rowsInventario)){
								foreach($rowsInventario as $rowInventario){
									print_r("$select");
									print_r("<br />");
									$cantInv = $rowInventario->existenciaReal - $can;
									print_r($cantInv);
									print_r("<br />");
									if( $cantInv > 0){
										//Actualizamos capas conforme tipoInventario PEPS
										$tablaCapas = $this->tablaCapas;
										$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInventario["idProducto"]);
										$rowCapas= $tablaCapas->fetchRow($select);
										print_r("$select");
										print_r("<br />");
										print_r("Cantidad actual en capas:");
										$canCapas = $rowCapas["cantidad"] - $can;
										print_r($canCapas);
										print_r("<br />");
										if($canCapas > 0){
											$rowCapas->cantidad = $canCapas;
											//$rowCapas->costoUnitario = $canCapas * $rowCapas["costoUnitario"] ;
											$rowCapas->save();
											//Creamos Cardex
											$tablaMovimiento = $this->tablaMovimiento;
											$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numeroFactura'])
											->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])->where("idCoP=?",$encabezado['idCoP'])
											->where("idEmpresas=?",$encabezado['idEmpresas'])->where("fecha=?", $stringFecha)->order("secuencial DESC");
											$rowMovimiento = $tablaMovimiento->fetchRow($select); 
											print_r("$select");
											$tablaCardex = $this->tablaCardex;
											$select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$encabezado['numeroFactura'])
											->where("idSucursal=?",$encabezado['idSucursal'])->where("fechaEntrada=?", $stringFecha)->order("secuencialEntrada DESC");
											print_r("<br />");
											print_r("$select");
											print_r("<br />");
											$rowCardex = $tablaCardex->fetchRow($select); 
											if(!is_null($rowCardex)){
												$secuencialSalida= $rowCardex->secuencialSalida + 1;
											}else{
												$secuencialSalida = 1;	
											}
											$costo = $rowMovimiento['cantidad'] * $rowCapas['costoUnitario'];
											$costoSalida= $rowMovimiento['cantidad'] * $productos[0]['precioUnitario'];
											$utilidad = $costoSalida- $costo;
											$mCardex = array(
												'idSucursal'=>$encabezado['idSucursal'],
												'numerofolio'=>$encabezado['numeroFactura'],
												'idProducto'=>$productos[0]["claveProducto"],
												'idDivisa'=>1,
												'secuencialEntrada'=>$rowCapas['secuencial'],
												'fechaEntrada'=>$rowCapas['fechaEntrada'],
												'secuencialSalida'=>$secuencialSalida,
												'fechaSalida'=>$stringFecha,
												'cantidad'=>$cantidad,
												'costo'=>$costo,
												'costoSalida'=>$costoSalida,
												'utilidad'=>$utilidad
											);
											$dbAdapter->insert("Cardex",$mCardex);
										}else{
											$rowCapas->delete($select);
										}
									//Actulizamos en Inventario
									$tablaInventario = $this->tablaInventario;
									$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$rowProductoEnl["productoEnlazado"]);
									$rowInventario= $tablaInventario->fetchRow($select);
									$cantInv;
									$rowInventario->existencia = $cantInv;;
									$rowInventario->existenciaReal = $cantInv;;
									$rowInventario->save();
									}//Cantidad
								}//for
							}//
						}//foreach $rowProductoEnl){
					}//if(!is_null($rowsProductoEnl))
				}//foreach $rowProductoComp)
			}//if busca productoTerminado
		}//if multiplo
	}
}

	
    
?>