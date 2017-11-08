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
	private $tablaTipoMovimiento;
	private $tablaInventario;
	private $tablaCapas;
	private $tablaMultiplos;
	private $tablaEmpresa;
	private $tablaBanco;
	private $tablaProveedor;
	private $tablaUnidad;
	private $tablaImpuestoProductos;
	private $tablaFacturaImpuesto;
	private $tablaProductoCompuesto;
		
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
		$this->tablaFacturaDetalle = new Contabilidad_Model_DbTable_FacturaDetalle(array('db'=>$dbAdapter));
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
		$this->tablaTipoMovimiento= new Contabilidad_Model_DbTable_TipoMovimiento(array('db'=>$dbAdapter));
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas(array('db'=>$dbAdapter));
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario(array('db'=>$dbAdapter));
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos(array('db'=>$dbAdapter));
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
		$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
		$this->tablaProductoCompuesto = new Inventario_Model_DbTable_ProductoCompuesto(array('db'=>$dbAdapter));
		$this->tablaBanco = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
		$this->tablaProveedor = new Sistema_Model_DbTable_Proveedores(array('db'=>$dbAdapter));
		$this->tablaUnidad = new Inventario_Model_DbTable_Unidad(array('db'=>$dbAdapter));
		$this->tablaImpuestos = new Contabilidad_Model_DbTable_Impuesto(array('db'=>$dbAdapter));
		$this->tablaImpuestoProductos = new Contabilidad_Model_DbTable_ImpuestoProductos(array('db'=>$dbAdapter));
		$this->tablaFacturaImpuesto = new Contabilidad_Model_DbTable_FacturaImpuesto(array('db'=>$dbAdapter));
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
			//print_r("$select");
			if(!is_null($rowFactura)){
				echo"La factura ya esta registrada";
			}else{
				//Situacion de Pago $conceptoPago = array('AN'=>'ANTICIPO','LI'=>'LIQUIDACION','PA'=>'PAGO','PE'=>'PENDIENTE DE PAGO');
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
					'idDivisa'=>$formaPago['idDivisa'],
					'numeroFactura'=>$encabezado['numeroFactura'],
					'estatus'=>"A",
					'conceptoPago'=>$conceptoPago,
					'descuento'=>$importe[0]['descuento'],
					'formaPago'=>$formaPago['formaLiquidar'],
					'fecha'=>$stringFecha,
					'subTotal'=>$importe[0]['subTotal'],
					'total'=>$importe[0]['total'],
					'folioFiscal'=>$encabezado['folioFiscal'],
					'importePagado'=>$importePagado,
					'saldo'=>$saldo
				);
				$dbAdapter->insert("Factura", $mFactura);
				//Obtine el ultimo id en tabla factura y Guarda los impuestos
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
				//Guarda Impuesto
				$tablaImpuesto = $this->tablaImpuestos;
				$select = $tablaImpuesto->select()->from($tablaImpuesto);
				$rowsImpuesto = $tablaImpuesto->fetchAll();
				foreach($rowsImpuesto as $rowImpuesto){
					$abreviatura  = $rowImpuesto["abreviatura"];
					switch ($abreviatura ) {
						case 'IEPS':
							if($importe[0]["ieps"]!== 0){
								$dbAdapter->insert("FacturaImpuesto", array("idTipoMovimiento"=>$encabezado['idTipoMovimiento'],"idFactura"=>$idFactura,"idCuentasxp"=>0,"idImpuesto"=>$rowImpuesto["idImpuesto"],"importe"=>$importe[0]["ieps"]));
							}
							break;	
						case 'ISH':
							if($importe[0]["ish"]!=0){
								$dbAdapter->insert("FacturaImpuesto", array("idTipoMovimiento"=>$encabezado['idTipoMovimiento'],"idFactura"=>$idFactura,"idCuentasxp"=>0,"idImpuesto"=>$rowImpuesto["idImpuesto"],"importe"=>$importe[0]["ish"]));	
							}
							break;
						case 'ISR':
							if($importe[0]["isr"]!=0){
								$dbAdapter->insert("FacturaImpuesto", array("idTipoMovimiento"=>$encabezado['idTipoMovimiento'],"idFactura"=>$idFactura,"idCuentasxp"=>0,"idImpuesto"=>$rowImpuesto["idImpuesto"],"importe"=>$importe[0]["isr"]));
							}
							break;
					} 
				}
				//Cierra guarda impuesto
				//Guarda Movimiento en Cuentasxp si forma de pago es igual a liquidado
				if(($formaPago['pagada'])==="1"){
					$mCuentasxp = array(
						'idTipoMovimiento'=>15,
						'idSucursal'=>$encabezado['idSucursal'],
						'idFactura'=>$idFactura,
						'idCoP'=>$encabezado['idCoP'],
						'idBanco'=>$formaPago['idBanco'],
						'idDivisa'=>$formaPago['idDivisa'],
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
					$dbAdapter->insert("Cuentasxp", $mCuentasxp);
					//Guarda el impuesto de pago facturaImpuesto
					$mfImpuesto = array(
						'idTipoMovimiento'=>15,
						'idFactura'=>$idFactura,
						'idImpuesto'=>$rowImpFactura['idImpuesto'], //Iva
						'idCuentasxp'=>0,
						'importe'=>$importe[0]['iva']	
					);
					$dbAdapter->insert("FacturaImpuesto", $mfImpuesto);
					//Solo si esta pagada, actualiza saldo Banco
					$tablaBanco = $this->tablaBanco;
					$select = $tablaBanco->select()->from($tablaBanco)->where("idBanco = ?",$formaPago['idBanco']);
					$rowBanco = $tablaBanco->fetchRow($select);
					$saldo = $rowBanco->saldo - $importe[0]['total'];
					//print_r($saldo); print_r("<br />");
					$where = $tablaBanco->getAdapter()->quoteInto("idBanco=?",$formaPago['idBanco']);
					$tablaBanco->update(array ("saldo" => $saldo), $where);	
				}else{
					//Actualizamos el saldo del proveedor
					$tablaProv = $this->tablaProveedor;
					$select = $tablaProv->select()->from($tablaProv)->where("idProveedores = ?",$encabezado['idCoP']);
					$rowProv = $tablaProv->fetchRow($select);
					// print_r($expression);
					if(!is_null($rowProv)){
						$saldo  = $importe[0]['total'] + $rowProv->saldo;
						$rowProv->saldo = $saldo;
						$rowProv->save();
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
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
		$stringFecha = $fechaInicio->toString('YY-mm-dd');
			
			try{
		 		$tablaMultiplos = $this->tablaMultiplos;
				$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
				$rowMultiplo = $tablaMultiplos->fetchRow($select);
				
				if(!is_null($rowMultiplo)){
					//====================Operaciones para convertir unidad minima====================================================== 
					$cantidad = 0;
					$precioUnitario = 0;
					$cantidad = $producto['cantidad'] * $rowMultiplo->cantidad;
					$precioUnitario = $producto['precioUnitario'] / $rowMultiplo->cantidad;
					$tablaFactura = $this->tablaFactura;
					$tablaMovimiento = $this->tablaMovimiento;
					$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numeroFactura'])->where("idCoP=?",$encabezado['idCoP'])
					->where("idSucursal=?",$encabezado['idSucursal'])->where("fecha=?", $stringFecha)->order("secuencial DESC");
					$rowMovimiento = $tablaMovimiento->fetchRow($select); 
					if(!is_null($rowMovimiento)){
						$secuencial= $rowMovimiento->secuencial +1;
					}else{
						$secuencial = 1;	
					}
					//Obtenemos el id de la ultima factura
					$select = $tablaFactura->select()->from($tablaFactura,array(new Zend_Db_Expr('max(idFactura) as idFactura')));
					$rowIdFactura =$tablaFactura->fetchRow($select);
					$idFactura = $rowIdFactura['idFactura'];
					//Guarda Movimiento en tabla Movimientos
					$mMovimiento = array(
						'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
						'idEmpresas'=>$encabezado['idEmpresas'],
						'idSucursal'=>$encabezado['idSucursal'],
						'idCoP'=>$encabezado['idCoP'],
						'numeroFolio'=>$encabezado['numeroFactura'],
						'idFactura'=>$idFactura,
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
					//Buscamos descipcion del producto.
					$tablaProducto = $this->tablaProducto;
					$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto = ?", $producto['descripcion']);
					$rowProducto = $tablaProducto->fetchRow($select);
					//$desProducto =$rowProducto['producto']; Insertar Movimiento en tabla FacturaDetalle
					$mFacturaDetalle = array(
						'idFactura'=>$idFactura,
						'idUnidad'=>$producto['unidad'],
						'secuencial'=>1,
						'cantidad'=>$cantidad,
						'descripcion'=>$rowProducto['producto'],
						'precioUnitario'=>$precioUnitario,
						'importe'=>$producto['importe'],
						'fecha'=>$stringFecha,
						'fechaCancela'=>null);
						//print_r($mFacturaDetalle);
					$dbAdapter->insert("FacturaDetalle",$mFacturaDetalle);
				}else{
					print_r("<br />"); echo "El multiplo es incorrecto";
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

	public function actulizaProducto(array $encabezado, $formaPago, $producto, $importe){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();	
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
		$stringIni = $fechaInicio->toString('YY-mm-dd');
		
		try{
			//Seleccionamos el producto para su clasificacion, Ver si la validación del producto se puede hacer desde jquery
			$tablaProducto = $this->tablaProducto;
			$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?",$producto["descripcion"]);
			$rowProducto = $tablaProducto->fetchRow($select);
			//print_r("$select"); //Convertimos la unidad del producto
			$tablaMultiplos = $this->tablaMultiplos;
			$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
			$rowMultiplo = $tablaMultiplos->fetchRow($select); 
			//print_r("$select");
			$cantidad = $producto['cantidad'] * $rowMultiplo["cantidad"];
			$precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
			//print_r("<br />"); print_r("$select"); print_r("<br />");
			if(!is_null($rowProducto && !is_null($rowMultiplo))){
				$claveProducto = substr($rowProducto->claveProducto, 0,2);
				//print_r($claveProducto); print_r("<br />");
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
					//print_r("<br />"); print_r($costoCliente);
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
					//No registramos  en Capas, si no existe en Inventario lo registra solo una vez, pero nunca actuliaza existencia  
					$tablaInventario = $this->tablaInventario;
					$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
					$rowInventario = $tablaInventario->fetchRow($select);
					$costoCliente = $rowInventario["costoUnitario"] * ($rowInventario["porcentajeGanancia"] / 100) + $rowInventario["costoUnitario"];
					//print_r("<br />");print_r("$select");
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
					//print_r("<br />");print_r("Servicio");print_r("<br />");print_r("Varios Servicios");
					$tablaInventario = $this->tablaInventario;
					$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
					$rowInventario = $tablaInventario->fetchRow($select);
					$costoCliente = $rowInventario["costoUnitario"] * ($rowInventario["porcentajeGanancia"] / 100) + $rowInventario["costoUnitario"];
					//print_r("<br />"); print_r("$select");
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
					//print_r("<br />"); print_r("Producto Normal");
					//Creamos o actualizamos Capas y Inventario
					$tablaCapas = $this->tablaCapas;
					$select = $tablaCapas->select()->from($tablaCapas)->where("numeroFolio=?",$encabezado['numeroFactura'])->where("fechaEntrada=?", $stringIni)->order("secuencial DESC");
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
						'idDivisa'=>$formaPago["idDivisa"],
						'idSucursal'=>$encabezado['idSucursal'],
						'numeroFolio'=>$encabezado['numeroFactura'],
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
					$rowsProductosComp = $tablaProdComp->fetchRow($select);
					//print_r("<br />"); print_r("$select"); print_r("<br />");
					if(!is_null($rowsProductosComp)){
						$rowsProductosComp["costoUnitario"] = $precioUnitario;
						$rowsProductosComp->save();
					}//RowProductoCompuesto	
				}//Existencia de Multiplo	
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

	public function actulizaCostoProducto(array $encabezado, $formaPago, $producto, $importe){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();	
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
		$stringIni = $fechaInicio->toString('YY-mm-dd');
		
		try{
			$tablaProducto = $this->tablaProducto;
			$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?",$producto["descripcion"]);
			$rowProducto = $tablaProducto->fetchRow($select);
			
			$tablaMultiplos = $this->tablaMultiplos;
			$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
			$rowMultiplo = $tablaMultiplos->fetchRow($select); 
			
			$cantidad = $producto['cantidad'] * $rowMultiplo["cantidad"];
			$precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
			
			if(!is_null($rowProducto && !is_null($rowMultiplo))){
				$claveProducto = substr($rowProducto->claveProducto, 0,2);
				if($claveProducto <> 'PT' || $claveProducto <> 'VS' || $claveProducto <> 'SV' ){
					//print_r("Busca el producto en ProductoCompuesto");
					$tablaProdComp = $this->tablaProductoCompuesto;
					$select = $tablaProdComp->select()->from($tablaProdComp)->where("productoEnlazado=?",$producto["descripcion"]);
					$rowsProductosComp = $tablaProdComp->fetchAll($select);
					//print_r("<br />"); print_r("$select"); print_r("<br />");
					if(!is_null($rowsProductosComp)){
						foreach($rowsProductosComp as $rowProductoComp){
							//Actualizamos costo en Capas y Inventario.
							$tablaProdComp = $this->tablaProductoCompuesto;
							$select = $tablaProdComp->select()->from($tablaProdComp, new Zend_Db_Expr('sum(cantidad * costoUnitario) as total'))->where("idProducto=?",$rowProductoComp["idProducto"]);
							$rowsProductosCompxp = $tablaProdComp->fetchRow($select);
							//print_r("<br />");
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
							//print_r("<br />"); print_r("$select");print_r("<br />");
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
			}//rowProducto y multiplo
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
	
	public function obtieneProyectoProveedor($idCoP){
		$tablaTipoMovimiento =  $this->tablaTipoMovimiento;
		$select   = $tablaTipoMovimiento->select()->from($tablaTipoMovimiento)->where("afectaInventario = ?", "+");
		$rowsTipoMovtos = $tablaTipoMovimiento->fetchAll($select);
		$idsTipoMovimiento = array ();
		foreach ($rowsTipoMovtos as $rowTipoMovimiento) {
			if(!in_array($rowTipoMovimiento->idTipoMovimiento, $idsTipoMovimiento)){
				$idsTipoMovimiento[] = $rowTipoMovimiento->idTipoMovimiento;
			}
		}
		
		$tablaMovimientos = $this->tablaMovimiento;
			$select= $tablaMovimientos->select()
			->setIntegrityCheck(false)
			->from($tablaMovimientos, new Zend_Db_Expr('DISTINCT(Movimientos.idFactura)as idFactura'))
			->join('Factura', 'Movimientos.idFactura = Factura.idFactura', array('total','Factura.idSucursal','Factura.idTipoMovimiento','Factura.numeroFactura','Factura.fecha'))
			->join('Proyecto', 'Movimientos.idProyecto = Proyecto.idProyecto', array('descripcion'))
			->join('TipoMovimiento', 'Movimientos.idTipoMovimiento = TipoMovimiento.idTipoMovimiento', array('descripcion AS descripcionTipo' ))
			->where('Movimientos.idCoP =?', $idCoP)->where("Movimientos.idTipoMovimiento  IN (?)", $idsTipoMovimiento)->order('Factura.idTipoMovimiento')->order("Factura.numeroFactura ASC");
			//print_r("$select");
		return $tablaMovimientos->fetchAll($select);
		
	}

	//Busca factura por sucursal 	
	public function buscaFacturaProveedor($idSucursal){
		$tablaFactura = $this->tablaFactura;
		$select = $tablaFactura->select()->from($tablaFactura)->where("idTipoMovimiento=?",4)->where("idSucursal=?",$idSucursal)
		->where("estatus =?","A")->where("conceptoPago =?","PE");
		$rowsNumFac = $tablaFactura->fetchAll($select);
		print_r("$select");
		//return $rowsNumFac;
	}
	
	//Busca factura proveedor por idSucursal y numero factura
	public function busca_FacProv($idSucursal,$num){
		$tablaFactura = $this->tablaFactura;
		$select= $tablaFactura->select()->setIntegrityCheck(false)->from($tablaFactura)
		->join('Proveedores','Factura.idCoP = Proveedores.idProveedores', array('idEmpresa'))
		->join('Empresa','Proveedores.idEmpresa = Empresa.idEmpresa')->join('Fiscales','Empresa.idFiscales = Fiscales.idFiscales',  array('razonSocial'))->where('Factura.idTipoMovimiento = ?',4)
		->where("estatus <> ?", "C")->where("conceptoPago =?","PE")->where("idSucursal =?", $idSucursal)->where("numeroFactura = ?" ,$num);
		//print_r("$select");
		return $tablaFactura->fetchAll($select);				
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
}