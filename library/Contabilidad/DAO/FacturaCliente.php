<?php
class Contabilidad_DAO_FacturaCliente implements Contabilidad_Interfaces_IFacturaCliente{
	
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
	private $tablaImpuestos;
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
		$this->tablaImpuestos = new Contabilidad_Model_DbTable_Impuesto(array('db'=>$dbAdapter));
		$this->tablaFacturaImpuesto = new Contabilidad_Model_DbTable_FacturaImpuesto(array('db'=>$dbAdapter));
		$this->tablaImpuestoProductos = new Contabilidad_Model_DbTable_ImpuestoProductos(array('db'=>$dbAdapter));
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario(array('db'=>$dbAdapter));
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas(array('db'=>$dbAdapter));
		$this->tablaConsecutivo = new Contabilidad_Model_DbTable_Consecutivo(array('db'=>$dbAdapter));
		$this->tablaProductoCompuesto = new Inventario_Model_DbTable_ProductoCompuesto(array('db'=>$dbAdapter));
		$this->tablaBanco = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));		
	}	
	
    public function guardaFactura(array $encabezado,$importe,$formaPago, $productos){
		
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
			if(!is_null($rowFactura)){
				print_r("La Factura Ya existe");
			 }else{
				if(($formaPago['pagada']) == "1"){
					$conceptoPago = "LI";
					$importePagado = $importe[0]['total'];
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
				//Guarda en facturaImpuesto
				$tablaImpuesto = $this->tablaImpuestos;
				$select = $tablaImpuesto->select()->from($tablaImpuesto)->where("abreviatura = ?",'IVA');
				$rowImpFactura = $tablaImpuesto->fetchRow($select);
				//print_r("$select");
				$mfImpuesto = array(
				    'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
				    'idFactura'=>$idFactura,
				    'idImpuesto'=>$rowImpFactura['idImpuesto'],
				    'idCuentasxp'=>0,
				    'importe'=>$importe[0]['iva']
				);
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
					    'fechaPago'=>$stringFecha,
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
					   'idCuentasxp'=>0,
				        'idImpuesto'=>$rowImpFactura['idImpuesto'], //Iva
					   'importe'=>$importe[0]['iva']
				    );	
                    $dbAdapter->insert("FacturaImpuesto", $mfImpuesto);
				    //Solo si esta pagada, actualiza saldo Banco
				    $tablaBanco = $this->tablaBanco;
				    $select = $tablaBanco->select()->from($tablaBanco)->where("idBanco = ?",$formaPago['idBanco']);
				    $rowBanco = $tablaBanco->fetchRow($select);
				    $saldo = $rowBanco->saldo + $importe[0]['total'];
				    $where = $tablaBanco->getAdapter()->quoteInto("idBanco=?",$formaPago['idBanco']);
				    $tablaBanco->update(array ("saldo" => $saldo), $where);
				}else{
					$tablaCli = $this->tablaClientes;
					$select = $tablaCli->select()->from($tablaCli)->where("idCliente = ?",$encabezado['idCoP']);
					$rowCli= $tablaCli->fetchRow($select);
					// print_r($expression);
					if(!is_null($rowCli)){
					   $saldo  = $importe[0]['total'] + $rowCli->saldo;
					   $rowCli->saldo = $saldo;
					   $rowCli->save();
					}
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
			if(!is_null($rowFactura)){
				//Buscamos en Movimientos, para asignar secuencial
				$tablaMovimiento = $this->tablaMovimiento;	
				$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numeroFactura'])->where("idCoP=?",$encabezado['idCoP'])
				->where("idSucursal=?",$encabezado['idSucursal'])->where("fecha=?", $stringFecha)->order("secuencial DESC");			
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
				//print_r($idFactura); //Guarda Movimiento en tabla Movimientos
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
				//print_r("La factura detalle");//print_r("$select");//Insertar Movimiento en tabla FacturaDetalle
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
	
	
    public function restarProducto(array $encabezado, $producto){
	    $dbAdapter =  Zend_Registry::get('dbmodgeneral');
	    $dbAdapter->beginTransaction();
	    $dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
	    $stringIni = $dateIni->toString ('yyyy-MM-dd');
	    
	    try{
	        //Seleccionamos el producto para su clasificación
	        $tablaProducto = $this->tablaProducto;
	        $select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?", $producto["claveProducto"]);
	        $rowProducto = $tablaProducto->fetchRow($select);
	        //print_r("$select");Convertimos la unidad del producto
	        $tablaMultiplos = $this->tablaMultiplos;
	        $select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['claveProducto'])->where("idUnidad=?",$producto['unidad']);
	        $rowMultiplo = $tablaMultiplos->fetchRow($select);
	        $cantidad = $producto['cantidad'] * $rowMultiplo["cantidad"];
	        $precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
	        if(!is_null($rowProducto && !is_null($rowMultiplo))){
	            $claveProducto = substr($rowProducto->claveProducto, 0,2);
	            switch($claveProducto){
	                case 'PT': //======================================================================================================PRODUCTO TERMINADO
	                    $tablaProductoCompuesto = $this->tablaProductoCompuesto;
	                    $select = $tablaProductoCompuesto->select()->from($tablaProductoCompuesto)->where("idProducto=?",$producto["claveProducto"]);
	                    $rowsProductoComp = $tablaProductoCompuesto->fetchAll($select);
	                    //print_r("Producto Paquete"); print_r("<br />");print_r("$select");print_r("<br />");
	                    foreach($rowsProductoComp as $rowProductoComp){//Recorremos el paquete y buscamos si el productoEnlazado es un producto compuesto
	                        $tablaProductoEnlazado = $this->tablaProductoCompuesto;
	                        $select = $tablaProductoEnlazado->select()->from($tablaProductoEnlazado)->where("idProducto=?",$rowProductoComp["productoEnlazado"]);
	                        $rowProductoEnlazado = $tablaProductoEnlazado->fetchRow($select);
	                        //print_r("El paquete contiene");print_r("<br />");print_r("$select");print_r("<br />");
	                        $cantProdComp = $cantidad * $rowProductoComp->cantidad;
	                        //print_r("La cantidad en producto compuesto"); print_r("<br />"); print_r($cantProdComp); print_r("<br />");
	                        if(!is_null($rowProductoEnlazado)){
	                            //Estos productos enlazados son productos compuesto print_r("<br />"); print_r("El producto compuesto contiene");print_r("<br />");
	                            $tablaProductoEnlazadoCompuesto = $this->tablaProductoCompuesto;
	                            $select = $tablaProductoEnlazadoCompuesto->select()->from($tablaProductoEnlazadoCompuesto)->where("idProducto = ?",$rowProductoComp["productoEnlazado"]);
	                            $rowsProductoEnl = $tablaProductoEnlazadoCompuesto->fetchAll($select);
	                            //print_r("<br />"); print_r("$select"); print_r("<br />"); Compuesto dentro de compuesto
	                            if(!is_null($rowsProductoEnl)){
	                                foreach($rowsProductoEnl as $rowProductoEnl){
	                                    $tablaProductoEnlazadoEnlazado = $this->tablaProductoCompuesto;
	                                    $select = $tablaProductoEnlazadoEnlazado->select()->from($tablaProductoEnlazadoEnlazado)->where("idProducto = ?",$rowProductoEnl["productoEnlazado"]);
	                                    $rowsProductoEnlEnl = $tablaProductoEnlazadoEnlazado->fetchRow($select);
	                                    if(!is_null($rowsProductoEnlEnl)){
	                                        //print_r("EL PRODUCTO COMPUESTO COMPUESTO ES:"); print_r("<br />"); print_r("$select");
	                                        $tablaProductoCompEnlazado = $this->tablaProductoCompuesto;
	                                        $select = $tablaProductoCompEnlazado->select()->from($tablaProductoCompEnlazado)->where("idProducto = ?",$rowsProductoEnlEnl["idProducto"]);
	                                        $rowsCompEnlazado = $tablaProductoCompEnlazado->fetchAll($select);
	                                        //print_r("EL PRODUCTO COMPUESTO COMPUESTO CONTIENE:"); print_r("<br />"); print_r("$select");
	                                        foreach($rowsCompEnlazado as $rowCompEnlazado){
	                                            $cantMateria = $rowCompEnlazado->cantidad * $cantProdComp;
	                                            //print_r("La cantidad del producto del producto compuesto es:"); print_r($cantMateria); print_r("<br />");
	                                            $tablaInventario = $this->tablaInventario;
	                                            $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$rowCompEnlazado["productoEnlazado"]);
	                                            $rowsInventario= $tablaInventario->fetchAll($select);
	                                            //print_r("$select");
	                                            if(!is_null($rowsInventario)){
	                                                foreach($rowsInventario as $rowInventario){
	                                                    $cantInv = $rowInventario->existenciaReal - $cantMateria;
	                                                    //print_r($cantInv);
	                                                    if( $cantInv > 0){
	                                                        //Capas
	                                                        $tablaCapas = $this->tablaCapas;
	                                                        $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInventario["idProducto"]);
	                                                        $rowCapas= $tablaCapas->fetchRow($select);
	                                                        //print_r("$select"); print_r("<br />"); print_r("Cantidad actual en capas:");
	                                                        $canCapas = $rowCapas["cantidad"] - $cantMateria;
	                                                        //print_r($canCapas); print_r("<br />");
	                                                        if($canCapas > 0){
	                                                            $rowCapas->cantidad = $canCapas;
	                                                            $rowCapas->save();
	                                                        }else{
	                                                            //$rowCapas->delete($select);
	                                                        }//if canCapas
	                                                        //Actulizamos en Inventario
	                                                        $tablaInventario = $this->tablaInventario;
	                                                        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$rowCompEnlazado["productoEnlazado"]);
	                                                        $rowInventario= $tablaInventario->fetchRow($select);
	                                                        $rowInventario->existencia = $cantInv;
	                                                        $rowInventario->existenciaReal = $cantInv;
	                                                        $rowInventario->save();
	                                                    }//if CantInv
	                                                }//foreach $rowsInventario
	                                            }//if Inventario
	                                        }//for $rowsCompEnlazado
	                                    }//if $rowsProductoEnlEnl
	                                    
	                                    $cantMateria = $rowProductoEnl->cantidad * $cantidad * $rowProductoComp->cantidad;
	                                    //print_r("<br />");print_r("El producto Terminado tiene");print_r($rowProductoEnl->idProducto); print_r("La cantidad del producto Terminado");
	                                    $tablaInventario = $this->tablaInventario;
	                                    $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$rowProductoEnl["productoEnlazado"]);
	                                    $rowsInventario= $tablaInventario->fetchAll($select);
	                                    //print_r("$select");
	                                    if(!is_null($rowsInventario)){
	                                        foreach($rowsInventario as $rowInventario){
	                                            //print_r("$select"); print_r("<br />");
	                                            $cantInv = $rowInventario->existenciaReal - $cantMateria;
	                                            //print_r($cantInv); print_r("<br />");
	                                            if( $cantInv > 0){
	                                                //Actualizamos capas conforme tipoInventario PEPS
	                                                $tablaCapas = $this->tablaCapas;
	                                                $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInventario["idProducto"]);
	                                                $rowCapas= $tablaCapas->fetchRow($select);
	                                                //print_r("$select");print_r("<br />");print_r("Cantidad actual en capas:");
	                                                $canCapas = $rowCapas["cantidad"] - $cantMateria;
	                                                //print_r($canCapas); print_r("<br />");
	                                                if($canCapas > 0){
	                                                    $rowCapas->cantidad = $canCapas;
	                                                    $rowCapas->save();
	                                                }else{
	                                                    //$rowCapas->delete($select);
	                                                }//if canCapas
	                                                //Actulizamos en Inventario
	                                                $tablaInventario = $this->tablaInventario;
	                                                $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$rowProductoEnl["productoEnlazado"]);
	                                                $rowInventario= $tablaInventario->fetchRow($select);
	                                                $rowInventario->existencia = $cantInv;;
	                                                $rowInventario->existenciaReal = $cantInv;
	                                                $rowInventario->save();
	                                            }//Cantidad
	                                        }//foreach
	                                    }//IF inventario
	                                }
	                            }
	                        }else{
	                            $tablaCapas = $this->tablaCapas;
	                            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto = ?",$rowProductoComp["productoEnlazado"]);
	                            $rowCapas = $tablaCapas->fetchrow($select);
	                            //print_r("El producto es Materia Prima"); print_r("<br />"); print_r("$select"); print_r("<br />");
	                            $cantMateria = $rowProductoComp->cantidad * $cantidad;
	                            //print_r("<br />"); print_r($cantMateria); print_r("<br />");
	                            $canCapas = $rowCapas["cantidad"] - $cantMateria;
	                            //print_r("Resta en capas"); print_r($canCapas); print_r("<br />");
	                            if($canCapas > 0){
	                                $rowCapas->cantidad = $canCapas;
	                                //$rowCapas->costoUnitario = $canCapas * $rowCapas["costoUnitario"] ;
	                                $rowCapas->save();
	                            }else{
	                                //$rowCapas->delete($select);
	                            }
	                            //Actualiza Inventario
	                            $tablaInventario = $this->tablaInventario;
	                            $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$rowProductoComp["productoEnlazado"]);
	                            $rowInventario= $tablaInventario->fetchRow($select);
	                            //print_r("El producto en Inventario"); print_r("<br />"); print_r("$select");
	                            $cantInv = $rowInventario->existenciaReal -$cantMateria;
	                            $rowInventario->existencia = $cantInv;
	                            $rowInventario->existenciaReal = $cantInv;
	                            $rowInventario->save();
	                        }//if $rowProductoEnlazado
	                    }// foreach $rowProductoComp
	                    
	                    break;
	                case 'VS':
	                    break;
	                case 'SV':
	                    break;
	                default:
	                    //Producto de Entrada y salida
	                    $tablaInventario = $this->tablaInventario;
	                    $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['claveProducto']);
	                    $rowInventario = $tablaInventario->fetchRow($select);
	                    $canI =  $rowInventario->existencia - $cantidad;
	                    //print_r($canI);
	                    if($rowInventario['existenciaReal'] > $canI){
	                        $tablaCapas = $this->tablaCapas;
	                        $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['claveProducto']) ->order("fechaEntrada ASC");
	                        $rowCapas = $tablaCapas->fetchRow($select);
	                        $cant =  $rowCapas->cantidad - $cantidad;
	                        //print_r($cant);
	                        if($cant <= 0){
	                            //Creamos Cardex
	                            $tablaMovimiento = $this->tablaMovimiento;
	                            $select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numeroFactura'])
	                            ->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])->where("idCoP=?",$encabezado['idCoP'])
	                            ->where("idEmpresas=?",$encabezado['idEmpresas'])->where("fecha=?", $stringIni)->order("secuencial DESC");
	                            $rowMovimiento = $tablaMovimiento->fetchRow($select);
	                            //print_r("$select");
	                            $tablaCardex = $this->tablaCardex;
	                            $select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$encabezado['numeroFactura'])
	                            ->where("idSucursal=?",$encabezado['idSucursal'])->where("fechaEntrada=?", $stringIni)->order("secuencialEntrada DESC");
	                            //print_r("$select");
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
	                                'utilidad'=>$utilidad);
	                            //print_r($mCardex);
	                            $dbAdapter->insert("Cardex",$mCardex);
	                            $rowCapas->delete($select);
	                        }else{
	                            //Creamos Cardex
	                            $tablaMovimiento = $this->tablaMovimiento;
	                            $select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numeroFactura'])
	                            ->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])->where("idCoP=?",$encabezado['idCoP'])
	                            ->where("idEmpresas=?",$encabezado['idEmpresas'])->where("fecha=?", $stringIni)->order("secuencial DESC");
	                            $rowMovimiento = $tablaMovimiento->fetchRow($select);
	                            //print_r("$select");
	                            $tablaCardex = $this->tablaCardex;
	                            $select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$encabezado['numeroFactura'])
	                            ->where("idSucursal=?",$encabezado['idSucursal'])->where("fechaEntrada=?", $stringIni)->order("secuencialEntrada DESC");
	                            //print_r("$select");
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
	                                'utilidad'=>$utilidad);
	                            //print_r($mCardex);
	                            $dbAdapter->insert("Cardex",$mCardex);
	                            //Edita Capas
	                            $rowCapas->cantidad = $cant;
	                            $rowCapas->save();
	                        }//cantidadt
	                        //Edita Inventatio
	                        $rowInventario->existencia = $canI;
	                        $rowInventario->existenciaReal = $canI;
	                        $rowInventario->save();
	                    }else{
	                        echo "No hay existencia del producto";
	                    }//cantidadI menor o igual a 0
	                    
	            }//switch
	        }//Cierra if rowMultiplo y Producto
	        $dbAdapter->commit();
	    }catch(exception $ex){
	        $dbAdapter->rollBack();
	        print_r($ex->getMessage());
	        throw new Util_Exception_BussinessException("Error");
	    }
    }

	
	
	public function buscaNumeroFactura($idSucursal){
		$tablaFactura = $this->tablaFactura;
		$select = $tablaFactura->select()->from($tablaFactura)->where("idTipoMovimiento=?",2)->where("idSucursal=?",$idSucursal)
		->where("estatus =?","A")->where("conceptoPago =?","PE");
		$rowsNumFac = $tablaFactura->fetchAll($select);
		
		return $rowsNumFac;
		
	}
	
	public function cancelaFactura($idFactura){
		$tablaFactura = $this->tablaFactura;
		$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura=?",$idFactura);
		$rowNumFac = $tablaFactura->fetchRow($select);
		//print_r("$select");
		if(!is_null($rowNumFac)){
			$rowNumFac->estatus = "C";
			$rowNumFac->save();
		}
	}
	
	public function restaDesechable($producto){
	    $can  = $producto['cantidad'];
	    if($producto['tipoEmpaque'] == 1){
	        //Vaso p/café
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",137);
	        $rowInvCafe  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvCafe)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvCafe["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvCafe['existencia'] - $can;
	            $rowInvCafe->existencia = $cantidad;
	            $rowInvCafe->existenciaReal = $cantidad;
	            $rowInvCafe->save();
	        }else{
	            echo "No hay existencia de vaso café en inventario";
	        }
	        //Tapa para café
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",132);
	        $rowInvTCafe  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvTCafe)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvTCafe["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvTCafe['existencia'] - $can;
	            $rowInvTCafe->existencia = $cantidad;
	            $rowInvTCafe->existenciaReal = $cantidad;
	            $rowInvTCafe->save();
	        }else{
	            echo "No hay existencia de tapa para café en inventario";
	        }
	        //Cuchillo
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",58);
	        $rowInvCuchillo  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvCuchillo)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvCuchillo["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvCuchillo['existencia'] - $can;
	            $rowInvCuchillo->existencia = $cantidad;
	            $rowInvCuchillo->existenciaReal = $cantidad;
	            $rowInvCuchillo->save();
	        }else{
	            echo "No hay existencia de cuchuillo en inventario";
	        }
	        //Tenedor
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",136);
	        $rowInvTenedor  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvTenedor)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvTenedor["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvTenedor['existencia'] - $can;
	            $rowInvTenedor->existencia = $cantidad;
	            $rowInvTenedor->existenciaReal = $cantidad;
	            $rowInvTenedor->save();
	        }else{
	            echo "No hay existencia de tenedor en inventario";
	        }
	        //Ega pac 131
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",131);
	        $rowInvTenedor  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvTenedor)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvTenedor["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can * 25;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvTenedor['existencia'] - $can * 25;
	            $rowInvTenedor->existencia = $cantidad;
	            $rowInvTenedor->existenciaReal = $cantidad;
	            $rowInvTenedor->save();
	        }else{
	            echo "No hay existencia de ega pac en inventario";
	        }
	        //Domo tres divisiones
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",61);
	        $rowInvDomo  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvDomo)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvDomo["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvDomo['existencia'] - $can;
	            $rowInvDomo->existencia = $cantidad;
	            $rowInvDomo->existenciaReal = $cantidad;
	            $rowInvDomo->save();
	        }else{
	            echo "No hay existencia de domo en inventario";
	        }
	        //Frutero
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",134);
	        $rowInvFrutero  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvFrutero)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvFrutero["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvFrutero['existencia'] - $can;
	            $rowInvFrutero->existencia = $cantidad;
	            $rowInvFrutero->existenciaReal = $cantidad;
	            $rowInvFrutero->save();
	        }else{
	            echo "No hay existencia de vaso gelatinero en inventario";
	        }
	        //Bolsa camiseta 3 kg
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",128);
	        $rowInvBolsa  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvFrutero)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvBolsa["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvBolsa['existencia'] - $can;
	            $rowInvBolsa->existencia = $cantidad;
	            $rowInvBolsa->existenciaReal = $cantidad;
	            $rowInvBolsa->save();
	        }else{
	            echo "No hay existencia de bolsa camiseta en inventario";
	        }
	    }else if($producto['tipoEmpaque'] == 2){
	        //================================================================================================>>Desechable comida
	        //Vaso rojo
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",97);
	        $rowInvVasoRojo  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvVasoRojo)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvVasoRojo["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvVasoRojo['existencia'] - $can;
	            $rowInvVasoRojo->existencia = $cantidad;
	            $rowInvVasoRojo->existenciaReal = $cantidad;
	            $rowInvVasoRojo->save();
	        }else{
	            echo "No hay existencia de vaso rojo en inventario";
	        }
	        
	        //Vaso 16 oz
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",160);
	        $rowInvVaso16  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvVaso16)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvVaso16["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvVaso16['existencia'] - $can;
	            $rowInvVaso16->existencia = $cantidad;
	            $rowInvVaso16->existenciaReal = $cantidad;
	            $rowInvVaso16->save();
	        }else{
	            echo "No hay existencia de vaso 16 oz en inventario" ;
	        }
	        //Vaso 1 lt
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",135);
	        $rowInvVasoUnicel  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvVasoUnicel)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvVasoUnicel["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvVaso16['existencia'] - $can;
	            $rowInvVasoUnicel->existencia = $cantidad;
	            $rowInvVasoUnicel->existenciaReal = $cantidad;
	            $rowInvVasoUnicel->save();
	        }else{
	            echo "No hay existencia de vaso 32 sl en inventario" ;
	        }
	        //Tapa 1LT.
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",133);
	        $rowInvTapa  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvTapa)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvTapa["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvTapa['existencia'] - $can;
	            $rowInvTapa->existencia = $cantidad;
	            $rowInvTapa->existenciaReal = $cantidad;
	            $rowInvTapa->save();
	        }else{
	            echo "No hay existencia de tapa 32 sl en inventario" ;
	        }
	        
	        //Cuchillo plastico
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",58);
	        $rowInvCuchillo  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvCuchillo)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvCuchillo["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvCuchillo['existencia'] - $can;
	            $rowInvCuchillo->existencia = $cantidad;
	            $rowInvCuchillo->existenciaReal = $cantidad;
	            $rowInvCuchillo->save();
	        }else{
	            echo "No hay existencia de cuchillo en inventario";
	        }
	        
	        //Tenedor.
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",136);
	        $rowInvTenedor  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvTenedor)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvTenedor["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvTenedor['existencia'] - $can;
	            $rowInvTenedor->existencia = $cantidad;
	            $rowInvTenedor->existenciaReal = $cantidad;
	            $rowInvTenedor->save();
	        }else{
	            echo "No hay existencia de tenedor en inventario";
	        }
	        
	        //Cuchara
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",158);
	        $rowInvCuchara  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvCuchara)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvCuchara["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvCuchara['existencia'] - $can;
	            $rowInvCuchara->existencia = $cantidad;
	            $rowInvCuchara->existenciaReal = $cantidad;
	            $rowInvCuchara->save();
	        }else{
	            echo "No hay existencia de cuchara en inventario";
	        }
	        
	        //EgaPac Pendiente
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?", 131);
	        $rowInvEgaPac  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvEgaPac)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvEgaPac["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can * 25;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvEgaPac['existencia'] - $can * 25;
	            $rowInvEgaPac->existencia = $cantidad;
	            $rowInvEgaPac->existenciaReal = $cantidad;
	            $rowInvEgaPac->save();
	        }else{
	            echo "No existe producto en existencia";
	        }
	        //Bolsa Camiseta
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",128);
	        $rowInvBolsa  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvBolsa)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvBolsa["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvBolsa['existencia'] - $can;
	            $rowInvBolsa->existencia = $cantidad;
	            $rowInvBolsa->existenciaReal = $cantidad;
	            $rowInvBolsa->save();
	        }else{
	            echo "No hay existencia de bolsa de camiseta en inventario";
	        }
	        //Aluminio
	        $tablaInventario = $this->tablaInventario;
	        $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto  = ?",98);
	        $rowInvAlum  = $tablaInventario->fetchRow($select);
	        if(!is_null($rowInvAlum)){
	            $tablaCapas = $this->tablaCapas;
	            $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInvAlum["idProducto"]);
	            $rowCapas= $tablaCapas->fetchRow($select);
	            $canCapas = $rowCapas["cantidad"] - $can * 50;
	            if($canCapas > 0){
	                $rowCapas->cantidad = $canCapas;
	                $rowCapas->save();
	            }else{
	                //Eliminamos el registro
	            }
	            $cantidad  = $rowInvAlum['existencia'] - $can * 50;
	            $rowInvAlum->existencia = $cantidad;
	            $rowInvAlum->existenciaReal = $cantidad;
	            $rowInvAlum->save();
	        }else{
	            echo "No hay existencia de papel aluminio de camiseta en inventario";
	        }
	    }
	}
}
