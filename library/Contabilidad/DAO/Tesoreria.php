<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_Tesoreria implements Contabilidad_Interfaces_ITesoreria{
	
	private $tablaMovimiento;
	private $tablaFactura;
	private $tablaFacturaDetalle;
	private $tablaFacturaImpuesto;
	private $tablaImpuesto;
	private $tablaBanco;
	private $tablaEmpresa;
	private $tablaCuentasxc;
	private $tablaCuentasxp;
	private $tablaMultiplos;
	private $tablaProducto;
	private $tablaInventario;
	private $tablaCapas;  
	private $tablaCardex;
		 
	public function __construct(){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
		$this->tablaEmpresa  = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
		$this->tablaImpuesto  = new Contabilidad_Model_DbTable_Impuesto(array('db'=>$dbAdapter));
		$this->tablaBanco = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
		$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
		$this->tablaCuentasxc = new Contabilidad_Model_DbTable_Cuentasxc(array('db'=>$dbAdapter));
		$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp(array('db'=>$dbAdapter));
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos(array('db'=>$dbAdapter));
		$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
		$this->tablaInventario = new Inventario_Model_DbTable_Inventario(array('db'=>$dbAdapter));
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas(array('db'=>$dbAdapter));
		$this->tablaCardex = new Contabilidad_Model_DbTable_Cardex(array('db'=>$dbAdapter));
		$this->tablaFacturaImpuesto = new Contabilidad_Model_DbTable_FacturaImpuesto(array('db'=>$dbAdapter));
	}
	public function obtenerEmpleadosNomina(){
		
	$tablaEmpresa = $this->tablaEmpresa;
		$select=$tablaEmpresa->select()
		->setIntegrityCheck(false)
		->from($tablaEmpresa, array('idEmpresa'))
		->join('Fiscales', 'Empresa.idFiscales = Fiscales.idFiscales', array('razonSocial'))
		->join('Proveedores','Empresa.idEmpresa = Proveedores.idEmpresa')
		->where('Proveedores.idTipoProveedor = 2')
		->order('razonSocial ASC');
		return $tablaEmpresa->fetchAll($select);		
		
	}
	
	public function sumaBanco($fondeo){
		$tablaBanco = $this->tablaBanco;
		$where = $tablaBanco->getAdapter()->quoteInto("idBanco=?", $fondeo['idBancoE']);
		$rowBanco = $tablaBanco->fetchRow($where);
		
		if(!is_null($rowBanco)){
			
			$importePago = $rowBanco->saldo + $fondeo['total'];
			$tablaBanco->update(array('saldo'=>$importePago),$where);
		}
	}
	
	public function restaBanco($fondeo){
		$tablaBanco = $this->tablaBanco;
		$where = $tablaBanco->getAdapter()->quoteInto("idBanco", $fondeo['idBancoS']);
		$rowBanco = $tablaBanco->fetchRow($where);
		if(!is_null($rowBanco)){
			$importePago = $rowBanco->saldo - $fondeo['total'];
			$tablaBanco->update(array('saldo'=>$importePago),$where);
		}
	}
	
	public function guardaFondeo( array $empresa, $fondeo){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$dateIni = new  Zend_Date($empresa['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');	
		
		
		try{
			$secuencial=0;	
			$tablaCuentasxc = $this->tablaCuentasxc;
			$select = $tablaCuentasxc->select()->from($tablaCuentasxc)->where("numeroFolio=?",$empresa['numFolio'])
			->where("idTipoMovimiento =?", $empresa['idTipoMovimiento'])
			->where("idCoP=?",$fondeo['idBancoS'])
			->where("idSucursal=?",$empresa['idSucursal'])
			->where("fechaPago=?", $stringIni)
			->order("secuencial DESC");
			$rowCuentasxc = $tablaCuentasxc->fetchRow($select); 
		
			if(!is_null($rowCuentasxc)){
				$secuencial= $rowCuentasxc->secuencial +1;
			}else{
				$secuencial = 1;	
			}
			
			$mCuentasxc = array(
			'idTipoMovimiento'=>$empresa['idTipoMovimiento'],
			'idSucursal'=>$empresa['idSucursal'],
			//'idFactura'=>$datos['idTipoMovimiento'],
			'idCoP'=>$empresa['idEmpresas'],/**/
			'idBanco'=>$fondeo['idBancoS'],
			'idDivisa'=>$fondeo['idDivisa'],
			//'idsImpuestos'=>$datos['idProducto'],
			'numeroFolio'=>$empresa['numFolio'],
			'secuencial'=>$secuencial,
			'fecha'=>date('Y-m-d h:i:s', time()),
			'fechaPago'=>$stringIni,
			'estatus'=>"A",
			'numeroReferencia'=>"",
			'formaLiquidar'=>"LI",
			'conceptoPago'=>$fondeo["formaPago"],
			'subTotal'=>$fondeo['total'],
			'total'=>$fondeo['total'],
			'comentario'=>""
			);
			$dbAdapter->insert("Cuentasxc",$mCuentasxc);
			$sumaBanco = $this->sumaBanco($fondeo);
			
			$mCuentasxp = array(
			'idTipoMovimiento'=>$empresa['idTipoMovimiento'],
			'idSucursal'=>$empresa['idSucursal'],
			//'idFactura'=>$datos['idTipoMovimiento'],
			'idCoP'=>$empresa['idEmpresas'],/**/
			'idBanco'=>$fondeo['idBancoE'],
			'idDivisa'=>$fondeo['idDivisa'],
			//'idsImpuestos'=>$datos['idProducto'],
			'numeroFolio'=>$empresa['numFolio'],
			'secuencial'=>$secuencial,
			'fecha'=>date('Y-m-d h:i:s', time()),
			'fechaPago'=>$stringIni,
			'estatus'=>"A",
			'numeroReferencia'=>"",
			'conceptoPago'=>$fondeo["formaPago"],
			'formaLiquidar'=>"LI",
			'subTotal'=>$fondeo['total'],
			'total'=>$fondeo['total']
			);
			
			$dbAdapter->insert("Cuentasxp",$mCuentasxp);
			$restaBanco = $this->restaBanco($fondeo);
			
			$dbAdapter->commit();
		}catch(exception $ex){
			print_r("<br />");
			print_r("==========");
			print_r("Excepcion Lanzada");
			print_r("<br />");
			print_r("==========");
			print_r("<br />");
			print_r($ex->getMessage());
			print_r("<br />");
			print_r("<br />");
			$dbAdapter->rollBack();
		}
	}
	
	public function guardaPagoNomina( array $empresa, $nomina){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
		$dbAdapter->beginTransaction();
	
		$dateIni = new  Zend_Date($empresa['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		try{
			//Guarda el Movimiento en Factura
			$mFactura = array(
				'idTipoMovimiento'=>$empresa['idTipoMovimiento'],
				'idSucursal'=>$empresa['idSucursal'],
				'idCoP'=>$empresa['idCoP'],
				'idDivisa'=>1,
				'numeroFactura'=>$empresa['numFolio'],
				'estatus'=>'A',
				'conceptoPago'=>'LI',
				'descuento'=>0,
				'formaPago'=>$empresa['formaLiquidar'],
				'fecha'=>$stringIni,
				'subtotal'=>$nomina['sueldo'],
				'total'=>$nomina['nominaxpagar'],
				'folioFiscal'=>$empresa['folioFiscal'],
				'importePagado'=>$nomina['nominaxpagar'],
				'saldo'=>0
			);
			$dbAdapter->insert("Factura",$mFactura);
			//Obtine el ultimo id en tabla factura
			$idFactura = $dbAdapter->lastInsertId("Factura","idFactura");
			print_r("El idFactura es 1:");
			print_r($idFactura);
			//Insertamos en la tabla Movimiento
			$secuencial=0;	
			$tablaMovimiento = $this->tablaMovimiento;
			$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$empresa['numFolio'])
			->where("idTipoMovimiento =?", $empresa['idTipoMovimiento'])
			->where("idCoP=?",$empresa['idCoP'])
			->where("idSucursal=?",$empresa['idSucursal'])
			->where("fecha=?", $stringIni)
			->order("secuencial DESC");
			$rowMovimiento = $tablaMovimiento->fetchRow($select); 
		
			if(!is_null($rowMovimiento)){
				$secuencial= $rowMovimiento->secuencial +1;
			}else{
				$secuencial = 1;	
			}
		
			$mMovtos = array(
				'idTipoMovimiento'=>$empresa['idTipoMovimiento'],
				'idEmpresas'=>$empresa['idEmpresas'],
				'idSucursal'=>$empresa['idSucursal'],
				'idCoP'=>$empresa['idCoP'],
				'numeroFolio'=>$empresa['numFolio'],
				'idFactura'=>$idFactura,
				'idProducto' => 746,
				//'idProyecto'=>$encabezado['idProyecto'],
				'cantidad'=>1,
				'fecha'=>$stringIni,
				'secuencial'=> $secuencial,
				'estatus'=>"A",
				'costoUnitario'=>$nomina['sueldo'], //el sueldo del empleado.
				'totalImporte'=>$nomina['nominaxpagar'] //total a pagar de nomina
			);
			//print_r($mMovtos);
			$dbAdapter->insert("Movimientos",$mMovtos);
			//Insertamos en la tabla Cuentasxp
			$mCuentasxp = array(
				'idTipoMovimiento'=>$empresa['idTipoMovimiento'],
				'idSucursal'=>$empresa['idSucursal'],
				'idFactura'=>$idFactura,
				'idCoP'=>$empresa['idEmpresas'],
				'idBanco'=>$empresa['idBanco'],
				'idDivisa'=>1,
				'numeroFolio'=>$empresa['numFolio'],
				'secuencial'=>$secuencial,
				'fecha'=>date('Y-m-d h:i:s', time()),
				'fechaPago'=>$stringIni,
				'estatus'=>"A",
				'numeroReferencia'=>$empresa['numeroReferencia'],
				'conceptoPago'=>"LI",
				'formaLiquidar'=>$empresa["formaLiquidar"],
				'subTotal'=>$nomina['sueldo'],
				'total'=>$nomina['nominaxpagar']
			);
			$dbAdapter->insert("Cuentasxp",$mCuentasxp);
			//Guarda Impuestos
			if (!is_null($nomina["IMSS"])){
				$mFacturaImpuesto = array(
					'idTipoMovimiento'=>$empresa["idTipoMovimiento"],
					'idFactura'=>$idFactura,
					'idImpuesto'=>5,
					'importe'=>$nomina['IMSS'],
				);
				$dbAdapter->insert("FacturaImpuesto",$mFacturaImpuesto);
	
			}
			if (!is_null($nomina["ISPT"])){
				$mFacturaImpuesto = array(
					'idTipoMovimiento'=>$empresa["idTipoMovimiento"],
					'idFactura'=>$idFactura,
					'idImpuesto'=>6,
					'importe'=>$nomina['ISPT'],
				);
				$dbAdapter->insert("FacturaImpuesto",$mFacturaImpuesto);
			
			}
			//Actulizar saldo banco
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
	
	public function guardaNotaCredito(array $notaCredito, $formaPago, $impuestos, $productos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($notaCredito[0]['fecha'],'YY-mm-dd');
		$stringFecha = $fechaInicio->toString('YY-mm-dd');
		
		try{
			if(($formaPago['pagada']) == "1"){
					$conceptoPago = "LI";
					$importePagado = $impuestos[0]['total'];
					print_r($importePagado);
					$saldo = 0;
				}elseif(($formaPago['pagada'])== "0" AND $formaPago['pagos'] =="0"){
					$conceptoPago = "PE";
					$importePagado = 0;
					$saldo = $impuestos[0]['total'];
				}elseif($formaPago['pagos'] <> 0 AND $formaPago['pagos'] <> $importe[0]['total']){
					$conceptoPago = "PA";
					$importePagado = $formaPago['pagos'];
					$saldo = $importe[0]['total']- $formaPago['pagos'];
				}	
			//Guarda Movimiento en tabla factura
			$mFactura = array(
				'idTipoMovimiento'=>$notaCredito[0]['idTipoMovimiento'],
				'idSucursal'=>$notaCredito[0]['idSucursal'],
				'idCoP'=>$notaCredito[0]['idCoP'],
				'idDivisa'=>1,
				'numeroFactura'=>$notaCredito[0]['numFolio'],
				'estatus'=>"A",//deberia ser cancelado
				'conceptoPago'=>$conceptoPago,
				'descuento'=>$impuestos[0]['descuento'],
				'formaPago'=>$formaPago['formaLiquidar'],
				'fecha'=>$stringFecha,
				'subTotal'=>$impuestos[0]['subTotal'],
				'total'=>$impuestos[0]['total'],
				'saldo'=>0,
				'folioFiscal'=>$notaCredito[0]['folioFiscal'],
				'importePagado'=>$impuestos[0]['total']
			);
			$dbAdapter->insert("Factura", $mFactura);
			
			$idFactura = $dbAdapter->lastInsertId("Factura","idFactura");	
			$mfImpuesto = array(
				'idTipoMovimiento'=>$notaCredito[0]['idTipoMovimiento'],
				'idFactura'=>$idFactura,
				'idImpuesto'=>4, //Iva
				'importe'=>$impuestos[0]['iva']
			);
			//print_r($mfImpuesto);
			$dbAdapter->insert("FacturaImpuesto", $mfImpuesto);
			
			//Movimimientos
			foreach ($productos as $producto){
				$tablaMovimiento = $this->tablaMovimiento;	
				$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$notaCredito[0]['numFolio'])
				->where("idCoP=?",$notaCredito[0]['idCoP'])
				->where("idSucursal=?",$notaCredito[0]['idSucursal'])
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
					'idTipoMovimiento'=>$notaCredito[0]['idTipoMovimiento'],
					'idEmpresas'=>$notaCredito[0]['idEmpresas'],
					'idSucursal'=>$notaCredito[0]['idSucursal'],
					'idCoP'=>$notaCredito[0]['idCoP'],
					'numeroFolio'=>$notaCredito[0]['numFolio'],
					'idFactura'=>$idFactura,
					'idProducto'=>$producto['claveProducto'],
					'idProyecto'=>$notaCredito[0]['idProyecto'],
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
			}//foreach
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
	
	public function restaProducto(array $notaCredito, $producto){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
		$dbAdapter->beginTransaction();
		$dateIni = new Zend_Date($notaCredito[0]['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
		try{
			//Seleccionamos el producto para su clasificacion, Ver si la validación del producto se puede hacer desde jquery
			$tablaProducto = $this->tablaProducto;
			$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?", $producto["claveProducto"]);
			$rowProducto = $tablaProducto->fetchRow($select);
			
			print_r("$select");
			//Convertimos la unidad del producto
			$tablaMultiplos = $this->tablaMultiplos;
			$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['claveProducto'])->where("idUnidad=?",$producto['unidad']);
			$rowMultiplo = $tablaMultiplos->fetchRow($select); 
			$cantidad = $producto['cantidad'] * $rowMultiplo["cantidad"];
			$precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
	
			if(!is_null($rowProducto && !is_null($rowMultiplo))){
				$claveProducto = substr($rowProducto->claveProducto, 0,2);
				print_r("<br />");
				switch($claveProducto){
					case 'PT':
					//print_r("<br />");
					$tablaCapas = $this->tablaCapas;
					$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['claveProducto']);
					$rowCapas = $tablaCapas->fetchRow($select);
					if(is_null($rowCapas)){
						$mCapas = array(
								'idSucursal'=>$encabezado['idSucursal'],
								'numeroFolio'=>1,
								'idProducto'=>$producto['claveProducto'],
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
					$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['claveProducto']);
					$rowInventario = $tablaInventario->fetchRow($select);
					$costoCliente = $precioUnitario * ($rowInventario["porcentajeGanancia"] / 100) + $precioUnitario;
					print_r("<br />");
					//print_r($costoCliente);
					if(is_null($rowInventario)){
						$mInventario = array(
							'idProducto'=>$producto['claveProducto'],
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
						$dbAdapter->insert("Inventario",$mInventario);
					}else{
						//Actuliza, fecha, costoUnitrio, costoCliente
						$rowInventario->fecha = date('Y-m-d h:i:s', time());
						$rowInventario->costoUnitario = $precioUnitario;
						$rowInventario->costoCliente = $costoCliente;
						$rowInventario->save();
					}
					//Resta ProductoCompuesto
					$tablaProdComp = $this->tablaProductoCompuesto;
			$select = $tablaProdComp->select()->from($tablaProdComp)->where("idProducto=?",$producto["claveProducto"]);
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
											$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
											->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])->where("idCoP=?",$encabezado['idCoP'])
											->where("idEmpresas=?",$encabezado['idEmpresas'])->where("fecha=?", $stringIni)->order("secuencial DESC");
											$rowMovimiento = $tablaMovimiento->fetchRow($select); 
											print_r("$select");
											$tablaCardex = $this->tablaCardex;
											$select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$encabezado['numFolio'])
											->where("idSucursal=?",$encabezado['idSucursal'])->where("fechaEntrada=?", $stringIni)->order("secuencialEntrada DESC");
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
											$costoSalida= $rowMovimiento['cantidad'] * $producto['precioUnitario'];
											$utilidad = $costoSalida- $costo;
											$mCardex = array(
												'idSucursal'=>$encabezado['idSucursal'],
												'numerofolio'=>$encabezado['numFolio'],
												'idProducto'=>$producto["claveProducto"],
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
				print_r($canI);
				if($rowInventario['existenciaReal'] > $canI){
					$tablaCapas = $this->tablaCapas;
					$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['claveProducto']) ->order("fechaEntrada ASC");
					$rowCapas = $tablaCapas->fetchRow($select);
					$cant =  $rowCapas->cantidad - $cantidad;
					print_r($cant);
					if($cant <= 0){
						//Creamos Cardex
						$tablaMovimiento = $this->tablaMovimiento;
						$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$notaCredito[0]['numFolio'])
						->where("idTipoMovimiento = ?",$notaCredito[0]['idTipoMovimiento'])->where("idCoP=?",$notaCredito[0]['idCoP'])
						->where("idEmpresas=?",$notaCredito[0]['idEmpresas'])->where("fecha=?", $stringIni)->order("secuencial DESC");
						$rowMovimiento = $tablaMovimiento->fetchRow($select); 
						
						$tablaCardex = $this->tablaCardex;
						$select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$notaCredito[0]['numFolio'])
						->where("idSucursal=?",$notaCredito[0]['idSucursal'])->where("fechaEntrada=?", $stringIni)->order("secuencialEntrada DESC");
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
						//Crea Cardex
						$mCardex = array(
							'idSucursal'=>$notaCredito[0]['idSucursal'],
							'numerofolio'=>$notaCredito[0]['numFolio'],
							'idProducto'=>$producto['claveProducto'],
							'idDivisa'=>1,
							'secuencialEntrada'=>$rowMovimiento['secuencial'],
							'fechaEntrada'=>$rowMovimiento['fecha'],
							'secuencialSalida'=>$secuencialSalida,
							'fechaSalida'=>$stringIni,
							'cantidad'=>$cantidad,
							'costo'=>$producto['importe'],
							'costoSalida'=>$producto['importe'],
							'utilidad'=>0
						);
						//print_r($mCardex);
						$dbAdapter->insert("Cardex",$mCardex);
						$rowCapas->delete($select);
					}else{
						//Creamos Cardex
						$tablaMovimiento = $this->tablaMovimiento;
						$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$notaCredito[0]['numFolio'])
						->where("idTipoMovimiento=?",$notaCredito[0]['idTipoMovimiento'])->where("idCoP=?",$notaCredito[0]['idCoP'])
						->where("idEmpresas=?",$notaCredito[0]['idEmpresas'])->where("fecha=?", $stringIni)->order("secuencial DESC");
						$rowMovimiento = $tablaMovimiento->fetchRow($select); 
						
						$tablaCardex = $this->tablaCardex;
						$select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$notaCredito[0]['numFolio'])
						->where("idSucursal=?",$notaCredito[0]['idSucursal'])->where("fechaEntrada=?", $stringIni)->order("secuencialEntrada DESC");
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
						//Crea Cardex
						$mCardex = array(
							'idSucursal'=>$notaCredito[0]['idSucursal'],
							'numerofolio'=>$notaCredito[0]['numFolio'],
							'idProducto'=>$producto['claveProducto'],
							'idDivisa'=>1,
							'secuencialEntrada'=>$rowMovimiento['secuencial'],
							'fechaEntrada'=>$rowMovimiento['fecha'],
							'secuencialSalida'=>$secuencialSalida,
							'fechaSalida'=>$stringIni,
							'cantidad'=>$cantidad,
							'costo'=>$producto['importe'],
							'costoSalida'=>$producto['importe'],
							'utilidad'=>0
						);
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
	
	public function guardaPagoImpuesto(array $encabezado, $info){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$dateIni = new  Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');	
		
		
		try{
			
			$mCuentasxp = array(
			'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
			'idSucursal'=>$encabezado['idSucursal'],
			//'idFactura'=>$datos['idTipoMovimiento'],
			'idCoP'=>$encabezado['idEmpresas'],/**/
			'idBanco'=>$info['idBancoS'],
			'idDivisa'=>1,
			'numeroFolio'=>$encabezado['numFolio'],
			'secuencial'=>1,
			'fecha'=>date('Y-m-d h:i:s', time()),
			'fechaPago'=>$stringIni,
			'estatus'=>"A",
			'numeroReferencia'=>$encabezado['numFolio'],
			'conceptoPago'=>"LI",
			'formaLiquidar'=>$info["formaLiquidar"],
			'subTotal'=>$info['total'],
			'total'=>$info['total']
			);
			$dbAdapter->insert("Cuentasxp",$mCuentasxp);
			//Guarda Movimiento en FacturaImpuesto
			$idcxp = $dbAdapter->lastInsertId("Cuentasxp","idCuentasxp");	
			$mfImpuesto = array(
				'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
				'idFactura'=>0,
				'idCuentasxp'=>$idcxp,
				'idImpuesto'=>$info['idImpuesto'], //Iva
				'importe'=>$info['total']
			);
			$dbAdapter->insert("FacturaImpuesto", $mfImpuesto);
			//restaBanco
			$tablaBanco = $this->tablaBanco;
			$where = $tablaBanco->getAdapter()->quoteInto("idBanco = ?",$info['idBancoS']);
			$rowBanco = $tablaBanco->fetchRow($where);
			print_r($where);
			if(!is_null($rowBanco)){
				$importePago = $rowBanco->saldo - $info['total'];
				$tablaBanco->update(array('saldo'=>$importePago),$where);
			}
			
			$dbAdapter->commit();
		}catch(exception $ex){
			print_r("<br />");
			print_r("==========");
			print_r("Excepcion Lanzada");
			print_r("<br />");
			print_r("==========");
			print_r("<br />");
			print_r($ex->getMessage());
			print_r("<br />");
			print_r("<br />");
			$dbAdapter->rollBack();
		}
		
	}

}