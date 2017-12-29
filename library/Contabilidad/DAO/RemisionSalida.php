
<?php
/**
 * @author Areli Morales Palma
 * @copyright 2017, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_RemisionSalida implements Contabilidad_Interfaces_IRemisionSalida{
	private $tablaMovimiento;
	private $tablaInventario;
	private $tablaCapas;
	private $tablaMultiplos;
	private $tablaCardex;
	private $tablaClientes;
	private $tablaCuentasxc;
	private $tablaBancos;
	private $tablaProducto;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas(array('db'=>$dbAdapter));
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario(array('db'=>$dbAdapter));
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos(array('db'=>$dbAdapter));
		$this->tablaCardex = new  Contabilidad_Model_DbTable_Cardex(array('db'=>$dbAdapter));
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));	
		$this->tablaClientes =  new Sistema_Model_DbTable_Clientes(array('db'=>$dbAdapter));
		$this->tablaCuentasxc = new Contabilidad_Model_DbTable_Cuentasxc(array('db'=>$dbAdapter));
		$this->tablaBancos = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
		$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
		$this->tablaProductoCompuesto = new Inventario_Model_DbTable_ProductoCompuesto(array('db'=>$dbAdapter));
	}
	
	public function obtenerClientes(){
		$tablaEmpresa = $this->tablaEmpresa;
		$select=$tablaEmpresa->select()
		->setIntegrityCheck(false)
		->from($tablaEmpresa, array('idEmpresa'))
		->join('fiscales', 'Empresa.idFiscales = fiscales.idFiscales', array('razonSocial'))
		->join('Clientes','Empresa.idEmpresa = Clientes.idEmpresa');
		return $tablaEmpresa->fetchAll($select);	
	}

	public function restarProducto(array $encabezado, $producto, $formaPago){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
		$dbAdapter->beginTransaction();
		$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
		try{
			//Seleccionamos el producto para su clasificación
			$tablaProducto = $this->tablaProducto;
			$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?", $producto["descripcion"]);
			$rowProducto = $tablaProducto->fetchRow($select);
			//print_r("$select");Convertimos la unidad del producto
			$tablaMultiplos = $this->tablaMultiplos;
			$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
			$rowMultiplo = $tablaMultiplos->fetchRow($select); 
			$cantidad = $producto['cantidad'] * $rowMultiplo["cantidad"];
			$precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
			//GuardaMovimiento en tabla Movimiento.
			$tablaMovimiento = $this->tablaMovimiento;	
			$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
			->where("idCoP=?",$encabezado['idCoP'])
			->where("idSucursal=?",$encabezado['idSucursal'])
			->where("fecha=?", $stringIni)
			->order("secuencial DESC");			
			$rowMovimiento = $tablaMovimiento->fetchRow($select); 
			if(!is_null($rowMovimiento)){
				$secuencial= $rowMovimiento->secuencial +1;
			}else{
				$secuencial = 1;	
			}
			$mMovtos = array(
				'idProducto' => $producto['descripcion'],
				'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
				'idEmpresas'=>$encabezado['idEmpresas'],
				'idSucursal'=>$encabezado['idSucursal'],
				'idCoP'=>$encabezado['idCoP'],
				'idProyecto'=>$encabezado['idProyecto'],
				'numeroFolio'=>$encabezado['numFolio'],
				'cantidad'=>$cantidad,
				'fecha'=>$stringIni,
				'estatus'=>"A",
				'secuencial'=> $secuencial,
				'costoUnitario'=>$precioUnitario,
			    'totalImporte'=>$producto['importe'],
			    );
			//print_r($mMovtos);
			$dbAdapter->insert("Movimientos",$mMovtos);
			if(!is_null($rowProducto && !is_null($rowMultiplo))){
				$claveProducto = substr($rowProducto->claveProducto, 0,2);
				switch($claveProducto){
					case 'PT': //======================================================================================================PRODUCTO TERMINADO
					$tablaProductoCompuesto = $this->tablaProductoCompuesto;
					$select = $tablaProductoCompuesto->select()->from($tablaProductoCompuesto)->where("idProducto=?",$producto["descripcion"]);
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
					$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
					$rowInventario = $tablaInventario->fetchRow($select);
					$canI =  $rowInventario->existencia - $cantidad;
					//print_r($canI);
					if($rowInventario['existenciaReal'] > $canI){
						$tablaCapas = $this->tablaCapas;
						$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['descripcion']) ->order("fechaEntrada ASC");
						$rowCapas = $tablaCapas->fetchRow($select);
						$cant =  $rowCapas->cantidad - $cantidad;
						//print_r($cant);
						if($cant <= 0){
							//Creamos Cardex
							$tablaMovimiento = $this->tablaMovimiento;
							$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
							->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])->where("idCoP=?",$encabezado['idCoP'])
							->where("idEmpresas=?",$encabezado['idEmpresas'])->where("fecha=?", $stringIni)->order("secuencial DESC");
							$rowMovimiento = $tablaMovimiento->fetchRow($select); 
							//print_r("$select");
							$tablaCardex = $this->tablaCardex;
							$select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$encabezado['numFolio'])
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
								'numerofolio'=>$encabezado['numFolio'],
								'idProducto'=>$producto['descripcion'],
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
							$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
							->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])->where("idCoP=?",$encabezado['idCoP'])
							->where("idEmpresas=?",$encabezado['idEmpresas'])->where("fecha=?", $stringIni)->order("secuencial DESC");
							$rowMovimiento = $tablaMovimiento->fetchRow($select); 
							//print_r("$select");
							$tablaCardex = $this->tablaCardex;
							$select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$encabezado['numFolio'])
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
								'numerofolio'=>$encabezado['numFolio'],
								'idProducto'=>$producto['descripcion'],
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
	
	public function generaCXC(array $encabezado, $formaPago, $productos){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
		//$dbAdapter->beginTransaction();
		$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
		try{	
			$tablaCuentasxc = $this->tablaCuentasxc;
			$select = $tablaCuentasxc->select()->from($tablaCuentasxc)->where("numeroFolio=?",$encabezado['numFolio'])->where("idCoP=?",$encabezado['idCoP'])
			->where("idSucursal=?",$encabezado['idSucursal'])->where("fechaPago=?", $stringIni)->order("secuencial DESC");
			$rowCuentasxc = $tablaCuentasxc->fetchRow($select); 
				
			if(!is_null($rowCuentasxc)){
				$secuencial= $rowCuentasxc->secuencial +1;
			}else{
				$secuencial = 1;	
			}
			
			$mCuentasxc = array(
				'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
				'idSucursal'=>$encabezado['idSucursal'],
				//'idFactura'=>$encabezado['idFactura'],
				'idCoP'=>$encabezado['idCoP'],
				'idBanco'=>$formaPago['idBanco'],
				'idDivisa'=>$formaPago['idDivisa'],
				'numeroFolio'=>$encabezado['numFolio'],
				'secuencial'=>$secuencial,
				'fecha'=>date("Y-m-d H:i:s", time()),
				'fechaPago'=>$stringIni,
				'estatus'=>"A",
				'numeroReferencia'=>0,
				'formaLiquidar'=>$formaPago['formaLiquidar'],
				'conceptoPago'=>$formaPago['conceptoPago'],
				'subTotal'=>0,
				'total'=>$formaPago['importePago']
			);   
			
			$dbAdapter->insert("Cuentasxc",$mCuentasxc);
			//Actualiza Saldo Banco
			$tablaBancos = $this->tablaBancos;
			$where = $tablaBancos->getAdapter()->quoteInto("idBanco= ?", $formaPago['idBanco']);
			$rowBanco = $tablaBancos->fetchRow($where);
			$importePago = $rowBanco->saldo + $productos[0]['importe'];
			$tablaBancos->update(array('saldo'=> $importePago), $where);
		$dbAdapter->commit();
		}catch(exception $ex){
			$dbAdapter->rollBack();
			print_r($ex->getMessage());
			throw new Util_Exception_BussinessException("Error");
		}
	}
	
	public function restaProductoCafeteria(array $encabezado, $productos, $formaPago){
	    $dbAdapter =  Zend_Registry::get('dbmodgeneral');
	    //$dbAdapter->beginTransaction();
	    $dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
	    $stringIni = $dateIni->toString ('yyyy-MM-dd');
	    try {
	        if(($formaPago['pagada']) == "1"){
	           $conceptoPago = "LI";
	           $importePagado = $formaPago['importePago'];
	           $saldo = 0;
	           $estatus = 'A';
	       }else{
	            $conceptoPago = "PE";
	           $importePagado = 0;
	           $saldo = $formaPago['importePago'];
	           $estatus = 'P';
	          
	       }
	       foreach($productos as $producto){
	           $tablaMovimiento = $this->tablaMovimiento;
	           $select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])->where("idCoP=?",$encabezado['idCoP'])
	           ->where("idSucursal=?",$encabezado['idSucursal'])->where("fecha=?", $stringIni)->order("secuencial DESC");
	           $rowMovimiento = $tablaMovimiento->fetchRow($select);
	       
	           //Seleccionamos el producto para su clasificación
	           $tablaProducto = $this->tablaProducto;
	           $select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?", $producto["descripcion"]);
	           $rowProducto = $tablaProducto->fetchRow($select);
	           //print_r("$select");Convertimos la unidad del producto
	           $tablaMultiplos = $this->tablaMultiplos;
	           $select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
	           $rowMultiplo = $tablaMultiplos->fetchRow($select);
	           $cantidad = $producto['cantidad'] * $rowMultiplo["cantidad"];
	           $precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
	           //GuardaMovimiento en tabla Movimiento.
	           $tablaMovimiento = $this->tablaMovimiento;
	           $select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
	           ->where("idCoP=?",$encabezado['idCoP'])
	           ->where("idSucursal=?",$encabezado['idSucursal'])
	           ->where("fecha=?", $stringIni)
	           ->order("secuencial DESC");
	           $rowMovimiento = $tablaMovimiento->fetchRow($select);
	           if(!is_null($rowMovimiento)){
	               $secuencial= $rowMovimiento->secuencial +1;
	           }else{
	               $secuencial = 1;
	           }
	       $mMovtos = array(
	           'idProducto' => $producto['descripcion'],
	           'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
	           'idEmpresas'=>$encabezado['idEmpresas'],
	           'idSucursal'=>$encabezado['idSucursal'],
	           'idCoP'=>$encabezado['idCoP'],
	           'idProyecto'=>$encabezado['idProyecto'],
	           'numeroFolio'=>$encabezado['numFolio'],
	           'cantidad'=>$cantidad,
	           'fecha'=>$stringIni,
	           'estatus'=>$estatus,
	           'secuencial'=> $secuencial,
	           'costoUnitario'=>$precioUnitario,
	           'totalImporte'=>$producto['importe'],
	           'entrega'=>$producto['tipoEmpaque']
	           
	       );

	       $dbAdapter->insert("Movimientos",$mMovtos);
	       if(!is_null($rowProducto && !is_null($rowMultiplo))){
	           $claveProducto = substr($rowProducto->claveProducto, 0,2);
	           switch($claveProducto){
	               case 'PT': //======================================================================================================PRODUCTO TERMINADO
	                   $tablaProductoCompuesto = $this->tablaProductoCompuesto;
	                   $select = $tablaProductoCompuesto->select()->from($tablaProductoCompuesto)->where("idProducto=?",$producto["descripcion"]);
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
	                   $select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
	                   $rowInventario = $tablaInventario->fetchRow($select);
	                   $canI =  $rowInventario->existencia - $cantidad;
	                   //print_r($canI);
	                   if($rowInventario['existenciaReal'] > $canI){
	                       $tablaCapas = $this->tablaCapas;
	                       $select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['descripcion']) ->order("fechaEntrada ASC");
	                       $rowCapas = $tablaCapas->fetchRow($select);
	                       $cant =  $rowCapas->cantidad - $cantidad;
	                       //print_r($cant);
	                       if($cant <= 0){
	                           //Creamos Cardex
	                           $tablaMovimiento = $this->tablaMovimiento;
	                           $select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
	                           ->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])->where("idCoP=?",$encabezado['idCoP'])
	                           ->where("idEmpresas=?",$encabezado['idEmpresas'])->where("fecha=?", $stringIni)->order("secuencial DESC");
	                           $rowMovimiento = $tablaMovimiento->fetchRow($select);
	                           //print_r("$select");
	                           $tablaCardex = $this->tablaCardex;
	                           $select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$encabezado['numFolio'])
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
	                               'numerofolio'=>$encabezado['numFolio'],
	                               'idProducto'=>$producto['descripcion'],
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
	                           $select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
	                           ->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])->where("idCoP=?",$encabezado['idCoP'])
	                           ->where("idEmpresas=?",$encabezado['idEmpresas'])->where("fecha=?", $stringIni)->order("secuencial DESC");
	                           $rowMovimiento = $tablaMovimiento->fetchRow($select);
	                           //print_r("$select");
	                           $tablaCardex = $this->tablaCardex;
	                           $select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$encabezado['numFolio'])
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
	                               'numerofolio'=>$encabezado['numFolio'],
	                               'idProducto'=>$producto['descripcion'],
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
	       $resta = $this->restaDesechableCafe($producto);
	       }
	       if(($formaPago['pagada'])=="1"){
	           $mCuentasxc = array(
	               'idTipoMovimiento'=>13,
	               'idSucursal'=>$encabezado['idSucursal'],
	               //'idFactura'=>$idFactura,
	               'idCoP'=>$encabezado['idCoP'],
	               'idBanco'=>$formaPago['idBanco'],
	               'idDivisa'=>$formaPago['idDivisa'],
	               'numeroFolio'=>$encabezado['numFolio'],
	               'secuencial'=>1,
	               'fecha'=>date("Y-m-d H:i:s", time()),
	               'fechaPago'=>$stringIni,
	               'estatus'=>"A",
	               'numeroReferencia'=>$encabezado['numFolio'],
	               'conceptoPago'=>$conceptoPago,
	               'formaLiquidar'=>$formaPago['formaLiquidar'],
	               'subTotal'=>0,
	               'total'=>$formaPago['importePago']
	           );
	           //print_r($mCuentasxc);
	           $dbAdapter->insert("Cuentasxc", $mCuentasxc);
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
	
	public function restaDesechableCafe($productos){
	   
	    $can  = $productos['cantidad'];
	    if($productos['tipoEmpaque'] == 'D'){
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
	    }else if($productos['tipoEmpaque'] == 'C'){
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