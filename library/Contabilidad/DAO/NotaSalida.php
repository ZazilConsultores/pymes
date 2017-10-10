	<?php
	/**
	 * @author Areli Morales Palma
	 * @copyright 2016, Zazil Conslaultores S.A. de C.V.
	 * @version 1.0.0
	 */
	class Contabilidad_DAO_NotaSalida implements Contabilidad_Interfaces_INotaSalida{
		private $tablaMovimiento;
		private $tablaInventario;
		private $tablaCapas;
		private $tablaMultiplos;
		private $tablaCardex;
		private $tablaClientes;
		private $tablaProducto;
		private $tablaProductoCompuesto;
		
		public function __construct() {
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
			$this->tablaCapas = new Contabilidad_Model_DbTable_Capas(array('db'=>$dbAdapter));
			$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario(array('db'=>$dbAdapter));
			$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos(array('db'=>$dbAdapter));
			$this->tablaCardex = new  Contabilidad_Model_DbTable_Cardex(array('db'=>$dbAdapter));
			$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
			$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
			$this->tablaProductoCompuesto = new Inventario_Model_DbTable_ProductoCompuesto(array('db'=>$dbAdapter));	
		}
		
		public function obtenerClientes(){
			$tablaEmpresa = $this->tablaEmpresa;
			$select=$tablaEmpresa->select()
			->setIntegrityCheck(false)
			->from($tablaEmpresa, array('idEmpresa'))
			->join('Fiscales', 'Empresa.idFiscales = Fiscales.idFiscales', array('razonSocial'))
			->join('Clientes','Empresa.idEmpresa = Clientes.idEmpresa')
			->order("razonSocial ASC");
			return $tablaEmpresa->fetchAll($select);	
		}
		
		public function obtenerCliente($idCliente){
			$tablaEmpresa = $this->tablaEmpresa;
			$select=$tablaEmpresa->select()
			->setIntegrityCheck(false)
			->from($tablaEmpresa, array('idEmpresa'))
			->join('Fiscales', 'Empresa.idFiscales = Fiscales.idFiscales', array('razonSocial'))
			->join('Clientes','Empresa.idEmpresa = Clientes.idEmpresa')
			->order("razonSocial ASC")->where("Clientes.idCliente=?", $idCliente);
			print_r("$select");
			//return $tablaEmpresa->fetchRow($select);	
		}
	
		
		public function guardaMovimientos(array $encabezado, $producto){
			$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
			$dbAdapter->beginTransaction();
			
			$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
			$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
			try{
				//=======================Crea secuencial, convierte a unidad minima y guarda registro en tabla Movimiento=======================================
				$tablaMovimiento = $this->tablaMovimiento;
				$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
				->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])
				->where("idCoP=?",$encabezado['idCoP'])
				->where("idEmpresas=?",$encabezado['idEmpresas'])
				->where("fecha=?", $stringIni)
				->order("secuencial DESC");
		
				$rowMovimiento = $tablaMovimiento->fetchRow($select); 
			
				if(!is_null($rowMovimiento)){
					$secuencial= $rowMovimiento->secuencial +1;
				}else{
					$secuencial = 1;	
				}
	
				//==================================================================
				$tablaMultiplos = $this->tablaMultiplos;
				$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
				$rowMultiplos = $tablaMultiplos->fetchRow($select); 
				//print_r("$select")
				$cantidad = $producto['cantidad'] * $rowMultiplos->cantidad;
				$precioUnitario = $producto['precioUnitario'] / $rowMultiplos->cantidad;
				
				$mMovtos = array(
						'idProducto' => $producto['descripcion'],
						'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
						'idEmpresas'=>$encabezado['idEmpresas'],
						'idSucursal'=>$encabezado['idSucursal'],
						'idCoP'=>$encabezado['idCoP'],
						//'idProyecto'=>$encabezado['idProyecto'],
						'numeroFolio'=>$encabezado['numFolio'],
						'cantidad'=>$cantidad,
						'fecha'=>$stringIni,
						'estatus'=>"A",
						'secuencial'=> $secuencial,
						'costoUnitario'=>$precioUnitario,
						'totalImporte'=>$producto['importe']
					);
				//print_r($mMovtos);
				$dbAdapter->insert("Movimientos",$mMovtos);
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
		
		public function restaProducto(array $encabezado, $producto){
			$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
			$dbAdapter->beginTransaction();
			$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
			$stringIni = $dateIni->toString ('yyyy-MM-dd');
			
			try{
				//Seleccionamos el producto para su clasificación
				$tablaProducto = $this->tablaProducto;
				$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?", $producto["descripcion"]);
				$rowProducto = $tablaProducto->fetchRow($select);
				//print_r("$select");
				//Convertimos la unidad del producto
				$tablaMultiplos = $this->tablaMultiplos;
				$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
				$rowMultiplo = $tablaMultiplos->fetchRow($select); 
				$cantidad = $producto['cantidad'] * $rowMultiplo["cantidad"];
				$precioUnitario = $producto['precioUnitario'] / $rowMultiplo["cantidad"];
				if(!is_null($rowProducto && !is_null($rowMultiplo))){
					$claveProducto = substr($rowProducto->claveProducto, 0,2);
					print_r("<br />");
					switch($claveProducto){
						case 'PT'://======================================================================================================PRODUCTO TERMINADO
							$tablaProductoCompuesto = $this->tablaProductoCompuesto;
							$select = $tablaProductoCompuesto->select()->from($tablaProductoCompuesto)->where("idProducto=?",$producto["descripcion"]);
							$rowsProductoComp = $tablaProductoCompuesto->fetchAll($select);
							print_r("Producto Paquete");
							print_r("<br />");
							print_r("$select");
							print_r("<br />");
							foreach($rowsProductoComp as $rowProductoComp){//Recorremos el paquete y buscamos si el productoEnlazado es un producto compuesto
								$tablaProductoEnlazado = $this->tablaProductoCompuesto;
								$select = $tablaProductoEnlazado->select()->from($tablaProductoEnlazado)->where("idProducto=?",$rowProductoComp["productoEnlazado"]);
								$rowProductoEnlazado = $tablaProductoEnlazado->fetchRow($select);
								print_r("El paquete contiene");
								print_r("<br />");
								print_r("$select");
								print_r("<br />");
								$cantProdComp = $cantidad * $rowProductoComp->cantidad;
								//print_r("La cantidad en producto compuesto");
								//print_r("<br />");
								//print_r($cantProdComp);
								//print_r("<br />");
					 			if(!is_null($rowProductoEnlazado)){
					 				//Estos productos enlazados son productos compuestos
					 				//print_r("<br />");
									//print_r("El producto compuesto contiene");
									//print_r("<br />");
					 				$tablaProductoEnlazadoCompuesto = $this->tablaProductoCompuesto;
									$select = $tablaProductoEnlazadoCompuesto->select()->from($tablaProductoEnlazadoCompuesto)->where("idProducto = ?",$rowProductoComp["productoEnlazado"]);
									$rowsProductoEnl = $tablaProductoEnlazadoCompuesto->fetchAll($select);
									//print_r("<br />");
									//print_r("$select");
									//print_r("<br />");
									//Compuesto dentro de compuesto
									if(!is_null($rowsProductoEnl)){
										foreach($rowsProductoEnl as $rowProductoEnl){
											$tablaProductoEnlazadoEnlazado = $this->tablaProductoCompuesto;
											$select = $tablaProductoEnlazadoEnlazado->select()->from($tablaProductoEnlazadoEnlazado)->where("idProducto = ?",$rowProductoEnl["productoEnlazado"]);
											$rowsProductoEnlEnl = $tablaProductoEnlazadoEnlazado->fetchRow($select);
											if(!is_null($rowsProductoEnlEnl)){
												print_r("<br />");
												print_r("$select");
												$tablaProductoCompEnlazado = $this->tablaProductoCompuesto;
												$select = $tablaProductoCompEnlazado->select()->from($tablaProductoCompEnlazado)->where("idProducto = ?",$rowsProductoEnlEnl["idProducto"]);
												$rowsCompEnlazado = $tablaProductoCompEnlazado->fetchAll($select);
												//print_r("EL PRODUCTO COMPUESTO COMPUESTO CONTIENE:");
												//print_r("<br />");
												//print_r("$select");
												foreach($rowsCompEnlazado as $rowCompEnlazado){
													$cantMateria = $rowCompEnlazado->cantidad * $cantProdComp;
													//print_r("La cantidad del producto del producto compuesto es:");
													//print_r($cantMateria);
													//print_r("<br />");
													$tablaInventario = $this->tablaInventario;
													$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$rowCompEnlazado["productoEnlazado"]);
													$rowsInventario= $tablaInventario->fetchAll($select);
													//print_r("$select");
													if(!is_null($rowsInventario)){
														foreach($rowsInventario as $rowInventario){
															$cantInv = $rowInventario->existenciaReal - $cantMateria;
															//print_r($cantInv);
															if($cantInv > 0){
																$tablaCapas = $this->tablaCapas;
																$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowInventario["idProducto"]);
																$rowCapas= $tablaCapas->fetchRow($select);
																/*print_r("$select");
																print_r("<br />");
																print_r("Cantidad actual en capas:");*/
																$canCapas = $rowCapas["cantidad"] - $cantMateria;
																//print_r($canCapas);
																//print_r("<br />");
																if($canCapas > 0){
																	$rowCapas->cantidad = $canCapas;
																	//$rowCapas->costoUnitario = $canCapas * $rowCapas["costoUnitario"] ;
																	$rowCapas->save();
																	//Creamos Cardex
																	/*$tablaMovimiento = $this->tablaMovimiento;
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
																		'idProducto'=>$producto["descripcion"],
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
																	$dbAdapter->insert("Cardex",$mCardex);*/
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
							//}else{
								//foreach($rowsProductoEnl as $rowProductoEnl){
										$cantMateria = $rowProductoEnl->cantidad * $cantidad * $rowProductoComp->cantidad;
										print_r("<br />");
										print_r("El producto Terminado tiene");
										print_r($rowProductoEnl->idProducto);
										print_r("La cantidad del producsto Terminado");
										print_r($rowProductoEnl->cantidad * $cantidad);
										print_r("<br />");
										print_r("Resta producto dentro de otro producto");
										print_r($cantMateria);
										print_r("<br />");
										//Buscamos el productoEnlazado en Inventario
										$tablaInventario = $this->tablaInventario;
										$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$rowProductoEnl["productoEnlazado"]);
										$rowsInventario= $tablaInventario->fetchAll($select);
										print_r("$select");
										if(!is_null($rowsInventario)){
											foreach($rowsInventario as $rowInventario){
												print_r("$select");
												print_r("<br />");
												$cantInv = $rowInventario->existenciaReal - $cantMateria;
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
													$canCapas = $rowCapas["cantidad"] - $cantMateria;
													print_r($canCapas);
													print_r("<br />");
													if($canCapas > 0){
														$rowCapas->cantidad = $canCapas;
														//$rowCapas->costoUnitario = $canCapas * $rowCapas["costoUnitario"] ;
														$rowCapas->save();
														//Creamos Cardex
														/*$tablaMovimiento = $this->tablaMovimiento;
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
															'idProducto'=>$producto["descripcion"],
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
														$dbAdapter->insert("Cardex",$mCardex);*/
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
								print_r("El producto es Materia Prima");
								print_r("<br />");
								print_r("$select");
								print_r("<br />");
								$cantMateria = $rowProductoComp->cantidad * $cantidad;
								print_r("<br />");
								print_r($cantMateria);
								print_r("<br />");
								$canCapas = $rowCapas["cantidad"] - $cantMateria;
								print_r("Resta en capas");
								print_r($canCapas);
								print_r("<br />");
								if($canCapas > 0){
									$rowCapas->cantidad = $canCapas;
									//$rowCapas->costoUnitario = $canCapas * $rowCapas["costoUnitario"] ;
									$rowCapas->save();
									//Creamos Cardex
									/*$tablaMovimiento = $this->tablaMovimiento;
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
										'idProducto'=>$producto["descripcion"],
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
									$dbAdapter->insert("Cardex",$mCardex);*/
								}else{
									//$rowCapas->delete($select);
								}
								//Actualiza Inventario
								$tablaInventario = $this->tablaInventario;
								$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$rowProductoComp["productoEnlazado"]);
								$rowInventario= $tablaInventario->fetchRow($select);
								print_r("El producto en Inventario");
								print_r("<br />");
								print_r("$select");
								$cantInv = $rowInventario->existenciaReal -$cantMateria;
								$rowInventario->existencia = $cantInv;
								$rowInventario->existenciaReal = $cantInv;
								$rowInventario->save();
						 	}//if $rowProductoEnlazado
					}// foreach $rowProductoComp
					
					/*if(!is_null($rowsProductoComp)){
						foreach($rowsProductoComp as $rowProductoComp){
							$tablaProdEnl = $this->tablaProductoCompuesto;
							$select = $tablaProdEnl->select()->from($tablaProdEnl)->where("idProducto=?",$rowProductoComp["productoEnlazado"]);
							$rowsProductoEnl= $tablaProdEnl->fetchAll($select);
							print_r("<br />");
							print_r("<br />");
							print_r("$select");
							print_r("<br />");
							if(!is_null($rowsProductoEnl)){
								foreach($rowsProductoEnl as $rowProductoEnl){
									$tablaProdEnlComp = $this->tablaProductoCompuesto;
									$select = $tablaProdEnlComp->select()->from($tablaProdEnlComp)->where("idProducto=?",$rowProductoEnl["idProducto"]);
									$rowsProductoEnlCom= $tablaProdEnlComp->fetchAll($select);
									print_r("<br />");
									//print_r("$select");
									if(!is_null($rowsProductoEnlCom)){
										foreach($rowsProductoEnlCom as $rowProductoEnlCom){
											$can = $rowProductoEnlCom->cantidad * $cantidad ;
											print_r($can);
											print_r("<br />");	
										}
										print_r("Es solo producto");
									}else{
										$tablaCapas = $this->tablaCapas;
										$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowsProductoEnlCom["idProducto"]);
										$rowCapas= $tablaCapas->fetchRow($select);
										print_r("$select");
									}
								}//foreach $rowProductoEnl
								
								
							}//if $rowsProductoEnl	
						}//foreach $rowProductoComp
							
					}//if $owsProductoComp*/
							//Esta compuesto por productoEnlazado
							/*$tablaProdEnl = $this->tablaProductoCompuesto;
							$select = $tablaProdEnl->select()->from($tablaProdEnl)->where("idProducto=?",$rowProductoComp["productoEnlazado"]);
							$rowsProductoEnl= $tablaProdEnl->fetchAll($select);
							/*if(!is_null($rowsProductoEnl)){
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
												'idProducto'=>$producto["descripcion"],
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
									$rowInventario->existenciaReal = $cantInv;
									$rowInventario->save();
									}//Cantidad
								}//for
							}//
						}//foreach $rowProductoEnl){
					}else{//No esta compuesto por producto Compuesto, resta en Capas y Inventario
							
					}//if(!is_null($rowsProductoEnl))
					print_r("El producto no esta compuesto");
					$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?", $rowProductoComp["productoEnlazado"]);
					$rowCapas= $tablaCapas->fetchRow($select);
					print_r("<br />");
					print_r("$select");
				}//foreach $rowProductoComp)
				
			}//if busca productoTerminado*/
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
				print_r($canI);
				if($rowInventario['existenciaReal'] > $canI){
					$tablaCapas = $this->tablaCapas;
					$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['descripcion']) ->order("fechaEntrada ASC");
					$rowCapas = $tablaCapas->fetchRow($select);
					$cant =  $rowCapas->cantidad - $cantidad;
					print_r($cant);
					if($cant <= 0){
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
							'utilidad'=>$utilidad
						);
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
						print_r("$select");
						$tablaCardex = $this->tablaCardex;
						$select = $tablaCardex->select()->from($tablaCardex)->where("numeroFolio=?",$encabezado['numFolio'])
						->where("idSucursal=?",$encabezado['idSucursal'])->where("fechaEntrada=?", $stringIni)->order("secuencialEntrada DESC");
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
							'utilidad'=>$utilidad
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
					}//switch clasificación del producto
				}//Cierra if rowMultiplo y Producto
			$dbAdapter->commit();
			}catch(exception $ex){
				$dbAdapter->rollBack();
				print_r($ex->getMessage());
				throw new Util_Exception_BussinessException("Error");
			}
		}
	
		public function creaCardex(array $encabezado, $producto){
			$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
			$dbAdapter->beginTransaction();
			
			$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
			$stringIni = $dateIni->toString ('yyyy-MM-dd');
			try{
			$tablaCapas = $this->tablaCapas;
			$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['descripcion'])
			//->where("fechaEntrada )
			->order("fechaEntrada ASC");
			$rowCapas = $tablaCapas->fetchRow($select);
			
			//=======================================Seleccionar tabla Movimiento
			$tablaMovimiento = $this->tablaMovimiento;
				$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
				->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])
				->where("idCoP=?",$encabezado['idCoP'])
				->where("idEmpresas=?",$encabezado['idEmpresas'])
				->where("fecha=?", $stringIni)
				->order("secuencial DESC");
			$rowMovimiento = $tablaMovimiento->fetchRow($select); 
			
			$tablaMultiplos = $this->tablaMultiplos;
			$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
			$rowMultiplo = $tablaMultiplos->fetchRow($select); 
			$utilidad = ($rowMovimiento->costoUnitario - $rowCapas['costoUnitario'])* $rowMovimiento->cantidad;
			//print_r($utilidad);
			$cantidad = 0;
			$precioUnitario = 0;
			$cantidad = $producto['cantidad'] * $rowMultiplo->cantidad;
			$precioUnitario = $producto['precioUnitario'] / $rowMultiplo->cantidad;
			
			$mCardex = array(
						'idSucursal'=>$encabezado['idSucursal'],
						'numerofolio'=>$encabezado['numFolio'],
						'idProducto'=>$producto['descripcion'],
						'idDivisa'=>1,
						'secuencialEntrada'=>$rowCapas['secuencial'],
						'fechaEntrada'=>$rowCapas['fechaEntrada'],
						'secuencialSalida'=>$rowMovimiento->secuencial,
						'fechaSalida'=>$stringIni,
						'cantidad'=>$cantidad,
						'costo'=>$rowCapas['costoUnitario'],
						'costoSalida'=>$producto['importe'],
						'utilidad'=>$utilidad
						
				);
				//print_r($mCardex);
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
		
		public function restaPT(array $encabezado, $producto){
		}
		
	}