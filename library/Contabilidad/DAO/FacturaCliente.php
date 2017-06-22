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
	private $tablaConsecutivo;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
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
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario(array('db'=>$dbAdapter));
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas(array('db'=>$dbAdapter));
		$this->tablaConsecutivo = new Contabilidad_Model_DbTable_Consecutivo(array('db'=>$dbAdapter));
			
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
					//obtenemos el secuencial por factura
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
					$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['claveProducto'])->where("idUnidad=?",$producto['unidad']);
					$rowMultiplo = $tablaMultiplos->fetchRow($select); 
					if(!is_null($rowMultiplo)){
						
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
					
					$tablaProducto = $this->tablaProducto;
						$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto = ?", $producto['claveProducto']);
					$rowProducto = $tablaProducto->fetchRow($select);
					$desProducto =$rowProducto['producto']; 
					
					//Insertar Movimiento en tabla FacturaDetalle
					$mFacturaDetalle = array(
						'idFactura'=>$idFactura,
						'idUnidad'=>$producto['unidad'],
						'secuencial'=>$secuencial,
						'cantidad'=>$cantidad,
						'descripcion'=>$producto["descripcion"],
						'precioUnitario'=>$precioUnitario,
						'importe'=>$producto['importe'],
						'fecha'=>$stringFecha,
						'fechaCancela'=>null
					);
				 	$dbAdapter->insert("FacturaDetalle",$mFacturaDetalle);	
				}
	
						
					}else{
						echo "Multiplo incorrecto";
					}
				
				}else{
					echo "La factura ya existe";
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
				
				if(($formaPago['pagada']) =="1"){
					$conceptoPago = "LI";
					$importePagado = $formaPago['pagos'];
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
				//print_r($mCuentasxc);
				$dbAdapter->insert("Cuentasxc", $mCuentasxc);
				//Guarda em facturaImpuesto
				$mfImpuesto = array(
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idFactura'=>$idFactura,
					'idImpuesto'=>4, //Iva
					'importe'=>$importe[0]['iva']
				);
				//print_r($mfImpuesto);
				$dbAdapter->insert("FacturaImpuesto", $mfImpuesto);
			}		
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
		//$restaCantidad = $rowInventario->existencia - $cantidad;
		$restaCantidad = 0;
		//print_r("Cantidad en inventario:");
		//print_r("$restaCantidad");
		

		if(!is_null($rowInventario)){
			//print_r("la cantidad en inventario no es menor que 0");
			/*print_r("<br />");
			$tablaCapas = $this->tablaCapas;
			$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['claveProducto']) 
			->order("fechaEntrada ASC");
			$rowCapas = $tablaCapas->fetchRow($select);
			//print_r("<br />");
			print_r("<br />");
			//print_r("$select");
			//print_r("<br />");
			$cant =  $rowCapas->cantidad - $cantidad;
			//print_r("Cant <br />");
			print_r("<br />");
			//print_r("<Cantidad en Capas />");
			print_r("<br />");
			//print_r($cant);
			print_r("<br />");
			
			
		//=====================================================================Resta 
		if(!$cant <= 0){
			
			$where = $tablaCapas->getAdapter()->quoteInto("idProducto =?",$rowCapas->idProducto,"fechaEntrada =?",$rowCapas->fechaEntrada );
			print_r("<br />");
			//print_r("query seleccion producto:");		
			print_r("<br />");
			//print_r("$where");
			print_r("<br />");
			//print_r($cant);
			print_r("<br />");
			$tablaCapas->update(array('cantidad'=>$cant), $where);
			print_r("<br />");
			print_r("<br />");
			//print_r("$where");
		}else{
		
			$where = $tablaCapas->getAdapter()->quoteInto("fechaEntrada=?", $rowCapas->fechaEntrada,"idProducto =?",$rowCapas->idProducto);	
			$tablaCapas->delete($where);
		}**/
		
		//===Resta cantidad en inventario
		
			$tablaInventario = $this->tablaInventario;
			$where = $tablaInventario->getAdapter()->quoteInto("idProducto=?", $producto['claveProducto']);
			$tablaInventario->update(array('existencia'=>$restaCantidad, 'existenciaReal'=>$restaCantidad),$where);
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
		$rowCapas = $tablaCapas->fetchRow($select);
		
		//=======================================Seleccionar tabla Movimiento
		$tablaMovimiento = $this->tablaMovimiento;
			$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numeroFactura'])
			->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])
			->where("idCoP=?",$encabezado['idCoP'])
			->where("idEmpresas=?",$encabezado['idEmpresas'])
			->where("fecha=?", $stringIni)
			->order("secuencial DESC");
		$rowMovimiento = $tablaMovimiento->fetchRow($select); 
		
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['claveProducto'])->where("idUnidad=?",$producto['unidad']);
		$rowMultiplo = $tablaMultiplos->fetchRow($select); 
		$utilidad = ($rowMovimiento->costoUnitario - $rowCapas['costoUnitario'])* $rowMovimiento->cantidad;
		//print_r($utilidad);
		$cantidad = 0;
		$precioUnitario = 0;
		$cantidad = $producto['cantidad'] * $rowMultiplo->cantidad;
		$precioUnitario = $producto['precioUnitario'] / $rowMultiplo->cantidad;
		
		$mCardex = array(
					'idSucursal'=>$encabezado['idSucursal'],
					'numerofolio'=>$encabezado['numeroFactura'],
					'idProducto'=>$producto['claveProducto'],
					'idDivisa'=>1,
					'secuencialEntrada'=>1,
					'fechaEntrada'=>$rowCapas['fechaEntrada'],
					'secuencialSalida'=>$rowMovimiento->secuencial,
					'fechaSalida'=>$stringIni,
					'cantidad'=>$cantidad,
					'costo'=>$rowCapas['costoUnitario'],
					'costoSalida'=>$producto['importe'],
					'utilidad'=>$utilidad
					
			);
			//print_r($mCardex);
			//$dbAdapter->insert("Cardex",$mCardex);
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
}
    
?>