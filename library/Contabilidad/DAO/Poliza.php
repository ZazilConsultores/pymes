	<?php
	
	class Contabilidad_DAO_Poliza implements Contabilidad_Interfaces_IPoliza {
			
		private $tablaCuentasxp;
		private $tablaProveedores;
		private $tablaFactura;
		private $tablaProveedorEmpresa;
		private $tablaGuiaContable;
		private $tablaBancos;
		private $tablaClientes;
		private $tablaPoliza;
		private $tablaFacturaImpuesto;
		
	
		
		public function __construct() {
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp(array('db'=>$dbAdapter));
			$this->tablaProveedores = new Sistema_Model_DbTable_Proveedores(array('db'=>$dbAdapter));
			$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
			$this->tablaProveedorEmpresa = new Sistema_Model_DbTable_ProveedoresEmpresa(array('db'=>$dbAdapter));
			$this->tablaGuiaContable = new Contabilidad_Model_DbTable_GuiaContable(array('db'=>$dbAdapter));
			$this->tablaGuiaContable = new Contabilidad_Model_DbTable_GuiaContable(array('db'=>$dbAdapter));
			$this->tablaBancos = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
			$this->tablaClientes = new Sistema_Model_DbTable_Clientes(array('db'=>$dbAdapter));
			$this->tablaPoliza = new Contabilidad_Model_DbTable_Poliza(array('db'=>$dbAdapter));
			$this->tablaFacturaImpuesto = new Contabilidad_Model_DbTable_FacturaImpuesto(array('db'=>$dbAdapter));
		}
	
		public function generaGruposFacturaProveedor($datos){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$dbAdapter->beginTransaction();
						
			$nomina; //Guarda el tipoProveedor, si la ocupamos =====================la borraremos y asignaremos directamente tipo
			$empresaProveedor; //empresa proveedora cuando el tipo no es bueno (Compras), pero es un proveedor, si se ocupa
			//Iniciamos variables
			$subTotal = 0; // si se ocupa
			$iva = 0;
			$total = 0; //si se ocupa
			$idProveedor = 0; //Si la utilizamos
			$idFactura = 0; //si la ocupamos
			$importe = 0;
			$idBanco =0;
			$numMov=0; //si se ocup
			$consecutivo = 0;
			$nivel=1;
			$descripcionPol;
			$fecha; // si se ocupa
			$tipoES;
			$abono;
			$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
			$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
			$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
			$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
			
			try{
				//Seleccionamos grupoFactura por fecha, tipoMovto = 4 facturaProveedor, idSucursal y estatus
				$tablaFactura = $this->tablaFactura;
				$select = $tablaFactura->select()->from($tablaFactura)->where('fechaFactura >= ?',$stringFechaInicio)->where('fechaFactura <=?',$stringFechaFinal)->where('idTipoMovimiento=?',4)
				->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
				$rowsGrupoFacturaP = $tablaFactura->fetchAll($select);
				//Verificamos que existe facturasProveedor 
				if(!is_null($rowsGrupoFacturaP)){
					foreach($rowsGrupoFacturaP as $rowFacturaP){
						//Obtenemos el idProveedor y el tipo
						$idCoP = $rowFacturaP["idCoP"];	
						$tablaProveedores = $this->tablaProveedores;
						$select = $tablaProveedores->select()->from($tablaProveedores, array('idProveedores','idTipoProveedor'))->where("idProveedores = ?", $idCoP);
						$rowProveedor = $tablaProveedores->fetchRow($select);
						//print_r("$select");
						//Verificamos que el proveedor exista
						if(!is_null($rowProveedor)){
							$tipo = $rowProveedor->idTipoProveedor;
				
							//Buscamos si es empresaProveedor, si el proveedor no esta en empresaProveedor no se realiza la poliza
						$tablaProveedoresEmpresa = $this->tablaProveedorEmpresa;
						$select = $tablaProveedoresEmpresa->select()->from($tablaProveedoresEmpresa, 'idEmpresas')->where("idProveedores =?", $idCoP);
						$rowProveedoresEmpresa = $tablaProveedoresEmpresa->fetchRow($select); 
						//Verificamos que el proveedor, sea un proveedor de la empresa selecciona
						if(!is_null($rowProveedoresEmpresa)){
							$empresaProveedor = $rowProveedoresEmpresa->idEmpresas;
							//print_r("El tipo es:");
							//print_r($tipo);
							//Verificamos que el tipo sea= 5 (bueno) y que sea un proveedor empresa de lo contrario  no se relizara poliza.
							if($tipo == 5  && $empresaProveedor <> "0"){
								print_r("<br />");		
								//print_r( $empresaProveedor);
								
								//asignamos variables
								$idFactura = $rowFacturaP["idFactura"];
								$modulo = 1; //Asignamos 1=>"Compra"
								$numMov = $rowFacturaP["numeroFactura"];
								$subTotal = $rowFacturaP["subtotal"];
								$total = $rowFacturaP["total"];
								$fecha = $rowFacturaP["fechaFactura"];
								//Buscamos en FacturaImpuesto el iva
								$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
								$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idFactura=?", $idFactura);
								$rowFacturaImp =$tablaFacturaImpuesto->fetchRow($select);
								$iva = $rowFacturaImp->importe; //print_r("<br />"); print_r("iva:"); print_r($iva);
								print_r("<br />");
								//Seleccionamos en la guia contable el modulo y el tipo
								$tablaGuiaContable = $this->tablaGuiaContable;
								$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?", $tipo);
								$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
								print_r("$select");
								//Comprobamos que esta el modulo y el tipo en guia contable
								if(!is_null($rowsGuiaContable)){
									foreach($rowsGuiaContable as $rowGuiaContable){
										$origen =$rowGuiaContable["origen"]; //Indica el importe corresponidente a cada registro
										switch($origen){
											case 'S':
												$importe = $subTotal;
												$origen = "SIN"; //No se porque va
												print_r("<br />");
												print_r("importe subtotal:"); //print_r($importe);
												print_r($importe);
											break;
											case 'I':
												$importe = $iva;
												$origen = "SIN";
												print_r("importe iva:"); //print_r($importe);
												print_r("<br />");
												print_r($importe);
												//print_r("ORIGEN:"); print_r($origen);
											break;
											case 'T':
												$importe = $total;
												$origen	= "PRO";
												print_r("<br />");
												print_r("importe total:"); //print_r($importe);
												print_r("<br />");
												print_r($importe); //print_r($origen);
											break;
										}//Cierra el switch origen
										//Asigna tipoES
										if($rowGuiaContable["origen"] =='I'){
											$tipoES = "I";
											print_r("<br />");
											print_r($tipoES);
										}else{
											$tipoES = "D";
											print_r("<br />");
											print_r($tipoES);
										}//Cierra tipoES
										//asigna abono o cargo
										if($rowGuiaContable["cargo"]== "X"){
											$cargo = $importe;
											print_r("El cargo, no esta vacio");
											print_r($cargo);
										}else{
											$cargo = 0;
										}
										
										if($rowGuiaContable["abono"]== "X"){
											$abono = $importe;
											print_r("El abono, no esta vacio");
											print_r($abono);
										}else{
											$abono = 0;
										}						
										//Arma descripcion
										if($rowGuiaContable["origen"] ='I' || $rowGuiaContable["origen"] = 'S'){
											$desPol = $rowGuiaContable->descripcion;
											print_r("<br />");
											//print_r($desPol);
										}else{	
											//Crear descripcion
											switch($modulo){
												case '1,6':
													$desPol = "Factura " . $numMov;
													break;
												case 3:
													$desPol = "Pago Factura " . $numMov;
													break;
												default:
													$delPol = $armaConsulta = $this->armaDescripcion($banco, $rowGuiaContable->descripcion);
											}//Cierra switch en casso de armar descripcion
										}//Cierra  if arma descripcion
										//print_r($origen);
										//Busca ctaProveedor y valor de subcuenta que nos va permitir saber el nivel. El proveedor  el nivel es 1
										if($origen == "PRO"){
											$tablaProveedores = $this->tablaProveedores;
											$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?",$idCoP);
											$rowProveedor = $tablaProveedores->fetchRow($select);
											$subCta = $rowProveedor["cuenta"];
											$posicion = 1;
										}else{
											$subCta = "0000";
											$posicion = 0;
										}//Cierra if origen proveedor
										//Creamos switch para Armar_Cuenta
										print_r("La posicio  es:");
										print_r($posicion);
										//Probamos el nivel
										/*$tipoEmpresa = Zend_Registry::get("tipoEmpresa"); */
										$mascara= Zend_Registry::get("mascara");
										print_r($mascara);
										if(!is_null($mascara)){
											$nivel1 = 1;
											$nivel2 = 2;
											$nivel3 = 3;
											$nivel4 = 4;
											$nivel5 = 5;
										}
										
										if($nivel1 == 1){
											if($posicion == 1){
												$armaSub1 = $subCta;
												print_r($armaSub1);
											}else{
												$armaSub1 = $rowGuiaContable["sub1"];
												print_r($armaSub1);
											}						
										}
										if($nivel2 == 2){
											if($posicion == 2){
												$armaSub2 = $subCta;
												print_r($armaSub2);
											}else{
												$armaSub2 = $rowGuiaContable["sub2"];
												print_r($armaSub2);
											}						
										}
										if($nivel3 == 3){
											if($posicion == 3){
												$armaSub3 = $subCta;
												print_r($armaSub3);
											}else{
												$armaSub3 = $rowGuiaContable["sub3"];
												print_r($armaSub3);
											}						
										}
										if($nivel4 == 4){
											if($posicion == 4){
												$armaSub4 = $subCta;
												print_r($armaSub4);
											}else{
												$armaSub4 = $rowGuiaContable["sub4"];
												print_r($armaSub4);
											}						
										}
										if($nivel5 == 5){
											if($posicion == 5){
												$armaSub5 = $subCta;
												print_r($armaSub5);
											}else{
												$armaSub5 = $rowGuiaContable["sub5"];
												print_r($armaSub5);
											}						
										}
										//Asignamos secuencial
										$secuencial = 0;	
										$tablaPoliza = $this->tablaPoliza;
										$select = $tablaPoliza->select()->from($tablaPoliza)->where("idModulo=?",$modulo)
										->where("idTipoProveedor=?",$tipo)
										->where("idSucursal=?",$datos['idSucursal'])
										->where("idCoP=?",$idCoP)
										->where("numDocto=?", $numMov)
										->order("secuencial DESC");
										$rowPoliza = $tablaPoliza->fetchRow($select); 
										print_r("$select");
										if(!is_null($rowPoliza)){
											$secuencial= $rowPoliza->secuencial +1;
										//print_r($secuencial);
										}else{
											$secuencial = 1;	
										//print_r($secuencial);
										}
										//Agregamos en tablaPoliza.
										$mPoliza = array(
										'idModulo'=>$modulo,
										'idTipoProveedor'=>$rowGuiaContable["idTipoProveedor"],
										'idSucursal'=>$datos['idSucursal'],
										'idCoP'=>$idCoP,
										'cta'=>$rowGuiaContable["cta"],
										'sub1'=>$armaSub1,
										'sub2'=>$armaSub2,
										'sub3'=>$armaSub3,
										'sub4'=>$armaSub4,
										'sub5'=>$armaSub5,
										'tipoES'=>$tipoES,
										'fecha'=>$fecha,/**/
										'descripcion'=>$desPol,
										'tipoES'=>$tipoES,
										'cargo'=>$cargo,
										'abono'=>$abono,
										'numdocto'=>$numMov,
										'secuencial'=>$secuencial
										);
										print_r($mPoliza);
										$dbAdapter->insert("Poliza", $mPoliza);
									}//cierra forach
								}//cierra if guiaContable
							}
						}else{
							echo "El proveedor seleccionado no es un proveedor de la empresa";
						}//Cierra  verificacion proveedorEmpresa
						}else{
							echo "El Numero de proveedor que introdujo no esta registrado en proveedores";
						}//Cierra verificamos que exista proveedor
						
						
					}//Cierra foreach
					
				}else{
					echo "No se no esta registrado Factura";
				} //Cierra verificacion de que existan factura	
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
		
		
		public function generaGruposFacturaCliente($datos){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$dbAdapter->beginTransaction();
			$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
			$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
			$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
			$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
			
			try{
				//Seleccionamos grupoFactura por fecha, tipoMovto = 2 facturaCliente, idSucursal y estatus
				$tablaFactura = $this->tablaFactura;
				$select = $tablaFactura->select()->from($tablaFactura)->where('fechaFactura >= ?',$stringFechaInicio)->where('fechaFactura <=?',$stringFechaFinal)->where('idTipoMovimiento=?',2)
				->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
				$rowsGrupoFacturaC = $tablaFactura->fetchRow($select);
				if(!is_null($rowsGrupoFacturaC)){
					foreach($rowsGrupoFacturaC as $rowGrupoFacturaC){
						$idSucursal = $rowsFacturac["idSucursal"];
						$numMov = $rowsFacturac["numeroFactura"];
						$subTotal = $rowsFacturac["subtotal"];
						$total = $rowsFacturac["total"];
						$fecha = $rowsFacturac["fecha"];
						$idCoP = $rowsFacturac["idCoP"];
						//Buscamos la cuenta de cliente
						$tablaClientes = $this->tablaClientes;
						$select = $tablaClientes->select()->from($tablaClientes,array('idCliente, cuenta'))->where("idCliente = ?", $idCoP);
						$rowCliente = $tablaClientes->fetchRow($select);
						print_r($select);
						//$iva = 32;
						
					}//Cierra foreach
				}else{
					echo "No se no esta registrado Factura";
					
					//Verificamos que sea un cliente
					$tablaClientes = $this->tablaClientes;
					$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente = ?",$idCliente);
					$rowClientes = $tablaClientes->fetchRow($select);
					//Definimos el modulo y el tipo
					$nomina = 5;
					$modulo = 6;
					//Deberia ir la funcion Genera poliza_C
					$tablaGuiaContable = $this->tablaGuiaContable;
					$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$nomina);
					$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
					print_r("<br />");
					print_r("$select");
					foreach($rowsGuiaContable as $rowGuiaContable){
						$origen = $rowGuiaContable->origen;
								switch($origen){
								case 'S':
									$importe = $subTotal;
									$origen = "SIN"; //No se porque va
									print_r("<br />");
									print_r("importe subtotal:"); print_r($importe);
									break;
								case 'I':
									$importe = $iva;
									$origen = "SIN";
									$descripcionPol = $rowGuiaContable->descripcion;
									print_r("<br />");
									print_r("importe iva:"); print_r($importe);
									print_r("<br />");
									print_r("ORIGEN:"); print_r($origen);
									break;
								case 'T':
									$importe = $total;
									$origen	= "PRO";
									print_r("<br />");
									print_r("importe total:"); print_r($importe);
									print_r("<br />");
									print_r("ORIGEN:"); print_r($origen);	
								break;
								}
								//Arma descripcion
								if($rowGuiaContable->origen ='I'){
									$desPol = $rowGuiaContable->descripcion;
								}else{
									//Crear descripcion
									print_r("No existe descripcion");
								}
								print_r($desPol);
								switch($origen){
								case 'CLT':
									$posicion = 1;
									//Seleccionamos el Cliente
									$tablaClientes = $this->tablaClientes;
									$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?",$idCliente);
									$rowCliente = $tablaClientes->fetchRow($select);
									print_r("<br />");
									print_r("<br />");
									print_r("<br />");
									print_r("$select");
									$subcta = $rowCliente->cuenta;
									print_r("<br />");
									//print_r($ctaProv);
									break;
								case 'PRO':
									$posicion = 1;
									//Seleccionamos el Proveedor
									/*$tablaProveedores = $this->tablaProveedores;
									$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?",$idProveedor);
									$rowProveedor = $tablaProveedores->fetchRow($select);
									print_r("<br />");
									print_r("<br />");
									print_r("<br />");
									print_r("$select");
									$subcta = $rowProveedor->cuenta;
									print_r("<br />");*/
									//print_r($ctaProv);
									break;
								case 'BAN':
									$posicion = 1;
									$ctaBanco = 0;
									$subcta = 0;
									//Seleccionamos el Banco
									/*$tablaBancos = $this->tablaBancos;
									$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$idBanco);
									$rowBanco = $tablaBancos->fetchRow($select);
									print_r("<br />");
									print_r("<br />");
									print_r("<br />");
									print_r("$select");
									$ctaBanco = $rowBanco->cuenta;
									print_r("<br />");
									print_r($ctaBanco);	*/	
									break;	
								default:
									$subcta = "0000";
									$posicion = 0;
									print_r ("<br />");
									print_r($subcta);
									print_r ("<br />");
									print_r($posicion);
									break;
								}//Cierra switch origen
								//Cuenta
								if($origen == "BAN"){
									 $ctaBanco;
								}else{
									$cta = $rowGuiaContable->cta;
									print_r("<br />");
									print_r("la cuenta de banco o de la guia contable es:");
									print_r($cta);
								}
								
								//Guarda en Poliza
								$mPoliza = array(
									'idModulo'=>$modulo,
									'idTipoProveedor'=>$rowGuiaContable->idTipoProveedor,
									'idSucursal'=>$datos['idSucursal'],
									'idCoP'=>$idCliente,
									'cta'=>$cta,
									/*'sub1'=>1, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub2'=>2, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub3'=>3, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub4'=>4, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub5'=>5, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									*/
									'sub1'=>'000',
									'sub2'=>'000',
									'sub3'=>'000',
									'sub4'=>'000',
									'sub5'=>'000',
									'fecha'=>$fecha,
									'descripcion'=>$desPol,
									'cargo'=>$importe,
									'abono'=>$importe,
									'numdocto'=>$numMov,
									'secuencial'=>1
							
						);
						print_r($mPoliza);
						$dbAdapter->insert("Poliza", $mPoliza);
								
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
		
		public function generacxc(){}
		
		public function generacxp($datos){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$dbAdapter->beginTransaction();
			
			$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
			$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
			$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
			$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
			
			try{
				//Seleccionamos grupoCuentasxp por fecha, tipoMovto = 15  Pago Factura, idSucursal y estatus
				$tablaCtsxp = $this->tablaCuentasxp;
				$select = $tablaCtsxp->select()->from($tablaCtsxp)->where('fechaPago >= ?',$stringFechaInicio)->where('fechaPago <=?',$stringFechaFinal)->where('idTipoMovimiento=?',15)
				->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
				$rowsCxp= $tablaCtsxp->fetchAll($select);
				//print_r($select->__toString());
				if(!is_null($rowsCxp)){
					foreach($rowsCxp as $rowCxp){
						$idCoP = $rowCxp["idCoP"];
						$tablaProveedores = $this->tablaProveedores;
						$select = $tablaProveedores->select()->from($tablaProveedores, array('idProveedores','idTipoProveedor'))->where("idProveedores = ?", $idCoP);
						$rowProveedor = $tablaProveedores->fetchRow($select);
						print_r("$select");
						//Verificamos que el proveedor exista
						if(!is_null($rowProveedor)){
							//Nomina
							$tipo = $rowProveedor->idTipoProveedor;
							//Buscamos si es empresaProveedor, si el proveedor no esta en empresaProveedor no se realiza la poliza
							$tablaProveedoresEmpresa = $this->tablaProveedorEmpresa;
							$select = $tablaProveedoresEmpresa->select()->from($tablaProveedoresEmpresa, 'idEmpresas')->where("idProveedores =?", $idCoP);
							$rowProveedoresEmpresa = $tablaProveedoresEmpresa->fetchRow($select);
							print_r($select->__toString());
						}
						$idSucursal = $rowsFacturac["idSucursal"];
						$numMov = $rowsFacturac["numeroFactura"];
						$subTotal = $rowsFacturac["subtotal"];
						$total = $rowsFacturac["total"];
						$fecha = $rowsFacturac["fecha"];
						
						//Buscamos la cuenta de cliente
						$tablaClientes = $this->tablaClientes;
						$select = $tablaClientes->select()->from($tablaClientes,array('idCliente, cuenta'))->where("idCliente = ?", $idCoP);
						$rowCliente = $tablaClientes->fetchRow($select);
						print_r($select);
						//$iva = 32;
						
					}//Cierra foreach
				}else{
					echo "No se no esta registrado Factura";
					
					//Verificamos que sea un cliente
					$tablaClientes = $this->tablaClientes;
					$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente = ?",$idCliente);
					$rowClientes = $tablaClientes->fetchRow($select);
					//Definimos el modulo y el tipo
					$nomina = 5;
					$modulo = 6;
					//Deberia ir la funcion Genera poliza_C
					$tablaGuiaContable = $this->tablaGuiaContable;
					$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$nomina);
					$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
					print_r("<br />");
					print_r("$select");
					foreach($rowsGuiaContable as $rowGuiaContable){
						$origen = $rowGuiaContable->origen;
								switch($origen){
								case 'S':
									$importe = $subTotal;
									$origen = "SIN"; //No se porque va
									print_r("<br />");
									print_r("importe subtotal:"); print_r($importe);
									break;
								case 'I':
									$importe = $iva;
									$origen = "SIN";
									$descripcionPol = $rowGuiaContable->descripcion;
									print_r("<br />");
									print_r("importe iva:"); print_r($importe);
									print_r("<br />");
									print_r("ORIGEN:"); print_r($origen);
									break;
								case 'T':
									$importe = $total;
									$origen	= "PRO";
									print_r("<br />");
									print_r("importe total:"); print_r($importe);
									print_r("<br />");
									print_r("ORIGEN:"); print_r($origen);	
								break;
								}
								//Arma descripcion
								if($rowGuiaContable->origen ='I'){
									$desPol = $rowGuiaContable->descripcion;
								}else{
									//Crear descripcion
									print_r("No existe descripcion");
								}
								print_r($desPol);
								switch($origen){
								case 'CLT':
									$posicion = 1;
									//Seleccionamos el Cliente
									$tablaClientes = $this->tablaClientes;
									$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?",$idCliente);
									$rowCliente = $tablaClientes->fetchRow($select);
									print_r("<br />");
									print_r("<br />");
									print_r("<br />");
									print_r("$select");
									$subcta = $rowCliente->cuenta;
									print_r("<br />");
									//print_r($ctaProv);
									break;
								case 'PRO':
									$posicion = 1;
									//Seleccionamos el Proveedor
									/*$tablaProveedores = $this->tablaProveedores;
									$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?",$idProveedor);
									$rowProveedor = $tablaProveedores->fetchRow($select);
									print_r("<br />");
									print_r("<br />");
									print_r("<br />");
									print_r("$select");
									$subcta = $rowProveedor->cuenta;
									print_r("<br />");*/
									//print_r($ctaProv);
									break;
								case 'BAN':
									$posicion = 1;
									$ctaBanco = 0;
									$subcta = 0;
									//Seleccionamos el Banco
									/*$tablaBancos = $this->tablaBancos;
									$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$idBanco);
									$rowBanco = $tablaBancos->fetchRow($select);
									print_r("<br />");
									print_r("<br />");
									print_r("<br />");
									print_r("$select");
									$ctaBanco = $rowBanco->cuenta;
									print_r("<br />");
									print_r($ctaBanco);	*/	
									break;	
								default:
									$subcta = "0000";
									$posicion = 0;
									print_r ("<br />");
									print_r($subcta);
									print_r ("<br />");
									print_r($posicion);
									break;
								}//Cierra switch origen
								//Cuenta
								if($origen == "BAN"){
									 $ctaBanco;
								}else{
									$cta = $rowGuiaContable->cta;
									print_r("<br />");
									print_r("la cuenta de banco o de la guia contable es:");
									print_r($cta);
								}
								
								//Guarda en Poliza
								$mPoliza = array(
									'idModulo'=>$modulo,
									'idTipoProveedor'=>$rowGuiaContable->idTipoProveedor,
									'idSucursal'=>$datos['idSucursal'],
									'idCoP'=>$idCliente,
									'cta'=>$cta,
									/*'sub1'=>1, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub2'=>2, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub3'=>3, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub4'=>4, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub5'=>5, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									*/
									'sub1'=>'000',
									'sub2'=>'000',
									'sub3'=>'000',
									'sub4'=>'000',
									'sub5'=>'000',
									'fecha'=>$fecha,
									'descripcion'=>$desPol,
									'cargo'=>$importe,
									'abono'=>$importe,
									'numdocto'=>$numMov,
									'secuencial'=>1
							
						);
						print_r($mPoliza);
						$dbAdapter->insert("Poliza", $mPoliza);
								
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
		public function generacxc_Fo(){}
		public function generacxp_Fo($datos){
			
			$subTotal;
			$total;
			$idProveedor;
			$idBanco;
			$nummov;
			$modulo = 8;
			$consecutivo;
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$dbAdapter->beginTransaction();
			$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
			$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
			$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
			$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
			try{
			//Buscamos en grupo cuentasxp
			$tablaCxp = $this->tablaCuentasxp;
			$select = $tablaCxp->select()->from($tablaCxp)->where('fechaPago >= ?', $stringFechaInicio)->where('fechaPago <= ?',$stringFechaFinal);
			$rowsCXPF = $tablaCxp->fetchAll($select);
			//print_r("$select");
			if(!is_null($rowsCXPF)){
				print_r("Puede realizar poliza");
				foreach($rowsCXPF as $rowCXPF){
					$idProveedor = $rowCXPF->idCoP; 
					
					//Buscamos nomina
					//Asignamos tipo
					$tipo = 6;
					$idBanco = $rowCXPF->idBanco;
					$idSucursal = $rowCXPF->idSucursal;
					$numMov = $rowCXPF->numeroFolio;
					$fecha = $rowCXPF->fechaPago;
					$subTotal = $rowCXPF->subTotal;
					$total = $rowCXPF->total;
					$consec = $rowCXPF->secuencial;
					
					//Funcion Genera_Poliza_Fo_P
					$tablaGuiaContable = $this->tablaGuiaContable;
					$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
					$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
					foreach($rowsGuiaContable as $rowGuiaContable){
						$origen = $rowGuiaContable->origen;
								switch($origen){
								case 'S':
									$importe = $subTotal;
									$origen = "SIN"; //No se porque va
									print_r("<br />");
									print_r("importe subtotal:"); print_r($importe);
									break;
								case 'I':
									$importe = $iva;
									$origen = "SIN";
									$descripcionPol = $rowGuiaContable->descripcion;
									print_r("<br />");
									print_r("importe iva:"); print_r($importe);
									print_r("<br />");
									print_r("ORIGEN:"); print_r($origen);
									break;
								case 'T':
									$importe = $total;
									$origen	= "BAN";
									print_r("<br />");
									print_r("importe total:"); print_r($importe);
									print_r("<br />");
									print_r("ORIGEN:"); print_r($origen);	
								break;
								}
								//Arma descripcion
								if($rowGuiaContable->origen ='I'){
									$desPol = $rowGuiaContable->descripcion;
								}else{
									//Crear descripcion
									print_r("No existe descripcion");
								}
								print_r($desPol);
								switch($origen){
								case 'CLT':
									$posicion = 1;
									//Seleccionamos el Cliente
									$tablaClientes = $this->tablaClientes;
									$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?",$idCliente);
									$rowCliente = $tablaClientes->fetchRow($select);
									print_r("<br />");
									print_r("<br />");
									print_r("<br />");
									print_r("$select");
									$subcta = $rowCliente->cuenta;
									print_r("<br />");
									//print_r($ctaProv);
									break;
								case 'PRO':
									$posicion = 1;
									//Seleccionamos el Proveedor
									$tablaProveedores = $this->tablaProveedores;
									$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?",$idProveedor);
									$rowProveedor = $tablaProveedores->fetchRow($select);
									print_r("<br />");
									print_r("<br />");
									print_r("<br />");
									print_r("$select");
									$subcta = $rowProveedor->cuenta;
									print_r("<br />");
									//print_r($ctaProv);
									break;
								case 'BAN':
									$posicion = 1;
									$cta= 0;
									$subcta = 0;
									//Seleccionamos el Banco
									$tablaBancos = $this->tablaBancos;
									$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$idBanco);
									$rowBanco = $tablaBancos->fetchRow($select);
									print_r("<br />");
									print_r("<br />");
									print_r("<br />");
									print_r("$select");
									$cta = $rowBanco->cuentaContable;
									print_r("<br />");
									print_r($cta);
									break;	
								default:
									$subcta = "0000";
									$posicion = 0;
									print_r ("<br />");
									print_r($subcta);
									print_r ("<br />");
									print_r($posicion);
									break;
								}//Cierra switch origen
								$abono;
								if($rowGuiaContable->cargo = "X"){
									$cargo= $importe;
								}else{
									$abono = $importe;
								}
								//Cuenta
								if($origen == "BAN"){
									 $cta;
								}else{
									$cta = $rowGuiaContable->cta;
									print_r("<br />");
									print_r("la cuenta de banco o de la guia contable es:");
									print_r($cta);
								}
								
									}
					
					
				}
	//Guarda en Poliza
								$mPoliza = array(
									'idModulo'=>$modulo,
									'idTipoProveedor'=>$rowGuiaContable->idTipoProveedor,
									'idSucursal'=>$datos['idSucursal'],
									'idCoP'=>$idProveedor,
									'cta'=>$cta,
									/*'sub1'=>1, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub2'=>2, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub3'=>3, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub4'=>4, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									'sub5'=>5, $posicion, $subcta, substr($row->sub1,4), substr($row->sub2,4), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0),
									*/
									'sub1'=>'000',
									'sub2'=>'000',
									'sub3'=>'000',
									'sub4'=>'000',
									'sub5'=>'000',
									'fecha'=>$fecha,
									'descripcion'=>$desPol,
									'cargo'=>$cargo,
									'abono'=>0,
									'numdocto'=>$numMov,
									'secuencial'=>1
							
						);
						//print_r($mPoliza);
						$dbAdapter->insert("Poliza", $mPoliza);
			
			}else{
				print_r("No esta registrado en CuentasXP");
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
		public function generaCompra(){}
		public function generaVenta(){}
		public function generacxpRemisiones(){}
		
		public function busca_Tipo($Persona, $Empresa){
			
			if ($Empresa ="P" ){
				$tablaProveedores = $this->tablaProveedores;
				$select = $tablaProveedores->select()->from($tablaProveedores,'idTipoProveedor')
				->where("idProveedores = ?", $Persona);
				$rowProveedor = $tablaProveedores->fetchAll($select);
				//print_r("$select");
				
				if(!is_null($rowProveedor)){
					return $rowProveedor->toArray();
				}else{
					$nomina = "COMPRA";
				}
				
			}
			
			/*elseif($Empresa == "C"){
				print_r("<br />");
				print_r("Es un cliente");
				$tablaClientes = $this->tablaClientes;
				$select = $tablaClientes->select()->from($tablaClientes,'idTipoCliente')
				->where("idCliente = ?", $Persona);
				$rowCliente = $tablaClientes->fetchRow($select);
				print_r("<br />");
				print_r("$select");
				/*if(!is_null($rowCliente)){
					return $rowCliente->toArray();
				}else{
					$nomina = "VENTA";
				}		
			}*/
		}
		
		public function busca_Proveedor($Persona, $Empresa){
			if($Empresa = "P"){
				$tablaProveedoresEmpresa = $this->tablaProveedorEmpresa;
				$select =$tablaProveedoresEmpresa->select()->from($tablaProveedoresEmpresa, 'idEmpresas')
				->where("idProveedores =?", $Persona);
				print_r("<br />");
				print_r("$select");
				$rowProveedoresEmpresa = $tablaProveedoresEmpresa->fetchRow($select); 
				//return $select;
				
				if(!is_null($rowProveedoresEmpresa)){
					//$nomina = $rowProveedoresEmpresa->idProveedores;
					$nomina = $rowProveedoresEmpresa->idEmpresas;
					return $nomina;
				}else{
					$nomina = 0;
				}
			}
			
			/*if($Empresa = "C"){
				$tablaClientes = $this->tablaClientes;
				$select =$tablaClientes->select()->from($tablaClientes, 'idTipoCliente')
				->where("idCliente =?", $Persona);
				$rowClientes = $tablaClientes->fetchRow($select); 
				//return $select;
				if(!is_null($rowClientes)){
					$nomina = $rowClientes->idTipoCliente;
					return $nomina;
				}else{
					$nomina = 0;
				}
				
			}*/
		}
		
		public function busca_SubCuenta($persona, $origen){
			/*$tipoBanco = Zend_Registry::get("tipoBanco");	
			$eTipoBanco->setMultiOptions($tipoBanco);*/
			
			$subCuenta = Zend_Registry::get('subCuenta');
			print_r($subCuenta);
			//Cliente
			if ($origen = "CLI"){
				$tablaClientes = $this->tablaClientes;
				$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente = ?",$persona);
				$rowClientes = $tablaClientes->fetchRow($select);
				//print_r("$select");
				$cuenta = $rowClientes->cuenta;
				if (is_null($cuenta <> 0)){
					print_r("El cliente no tiene numero de cuenta" );
				}
			
			}
			//Proveedor
			if ($origen = "PRO"){
				$tablaProveedores = $this->tablaProveedores;
				$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedor = ?",$persona);
				$rowProveedor = $tablaProveedores->fetchRow($select);
				//print_r("$select");
				$cuenta = $rowProveedor->cuenta;
				if (is_null($cuenta <> 0)){
					print_r("El Proveedor no tiene numero de cuenta" );
				}
			
			}
			//Banco
			if ($origen = "CLI"){
				$tablaBancos = $this->tablaBancos;
				$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco = ?",$persona);
				$rowBanco = $tablaBancos->fetchRow($select);
				//print_r("$select");
				$cuenta = $rowBanco->cuentaContable;
				if (is_null($cuenta <> 0)){
					print_r("El Banco no tiene numero de cuenta" );
				}
			
			}
			
			return $cuenta;
		}
		
		public function armaDescripcion($banco, $guia){
			$tablaBancos = $this->tablaBancos;
			$select = $tablaBancos->select()->from($tablaBancos,'tipo')->where("idBanco = ?",$banco);
			$rowBancos = $tablaBancos->fetchRow($select);
			if (!is_null($rowBancos)){
				if($rowBancos->tipo = 'CA'){
					$armaDes = "Caja";
				}else{
					$armaDes = $guia;
				}
			}else{  
				$armaDes = $guia;
			}
			
			
		}
		
		public function arma_Cuenta($nivel, $posicion, $subCta, $sub1, $sub2, $sub3, $sub4, $sub5){
			/*switch($nivel){
				case 1:
					if ($posicion = 1){
						$armaCuenta = $subcta;
					}else{
						$armaCuenta = $sub1;
					}
					print_r("<br />");
					print_r("CASO ORIGEN SEA =1");
					print_r("<br />");
					print_r($posicion);
					break;
				case 2:
					if ($posicion = 2){
						$armaCuenta = $subcta;
					}else{
						$armaCuenta = $sub2;
					}
					break;
				case 3:
					if ($posicion = 3){
						$armaCuenta = $subcta;
					}else{
						$armaCuenta = $sub3;
					}
					print_r("CASO ORIGEN SEA =2");
					print_r("<br />");
					print_r($posicion);
					break;
				case 4:
					if ($posicion = 4){
						$armaCuenta = $subcta;
					}else{
						$armaCuenta = $sub4;
					}
					break;
				case 5:
					if ($posicion = 5){
						$armaCuenta = $subcta;
					}else{
						$armaCuenta = $sub5;
					}
					break;
			}*/
			$modulo =1; $tipo=5;
			$tablaGuiaContable = $this->tablaGuiaContable;
			$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
			$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
			foreach($rowsGuiaContable as $rowGuiaContable){
				$origen = $rowGuiaContable->origen;
				switch($nivel){
											case '1':
												if($posicion == 1){
													$this->arma_Cuenta = $subCta;
												}else{
												$this->arma_Cuenta = $rowGuiaContable["sub1"];
												print_r("Arma Cuenta");
												print_r("<br />");
												print_r($this->arma_Cuenta);
												}
												break;
											case 2:
												if($posicion == 2){
													$this->arma_Cuenta = $subCta;
												}else{
													 $this->arma_Cuenta = $rowGuiaContable["sub2"];;
													 print_r("Hola");
													 print_r("<br />");
													 print_r($this->arma_Cuenta);
													 print_r("<br />");
												}
												break;
											case 3 :
												if($posicion == 3){
													$this->arma_Cuenta = $subCta;
												}else{
													 $this->arma_Cuenta = $sub3;
												}
											case 4 :
												if($posicion == 4){
													$this->arma_Cuenta = $subCta;
												}else{
													 $this->arma_Cuenta = $sub4;
												}
												break;
											case 5:
												if($posicion == 5){
													$this->arma_Cuenta = $subCta;
												}else{
													 $this->arma_Cuenta = $sub5;
												}
												break;
											
											}//Cierra switch en caso de armar descripcion*/	
											}		
		}
		
		public function genera_Poliza_F($modulo, $tipo, $iva){
			//$dbAdapter = Zend_Registry::get('dbmodgeneral');
		
			$tablaGuiaContable = $this->tablaGuiaContable;
			$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?", $tipo);
			$rowGuiaContable = $tablaGuiaContable->fetchRow($select);
			print_r("$select");
			
			if(!is_null($rowGuiaContable)){
				print_r("<br />");
				//select case $rowGuiaContable->origen;
				$origen = $rowGuiaContable->origen;
				print_r("<br />"); 
				print_r($origen);
				switch($origen){
					case 'S':
						$importe = "subTotal";
						$origen = "SIN";
					case 'I':
						$importe = $iva;
						print_r($importe);
						$origen = "SIN";
					case 'T':
						$importe = "total";
						$origen	= "PRO";	
						break;
				}
				//Arma descripcion
				if($origen ="I" or $origen="S" ){
					$desPol = $rowGuiaContable->descripcion;
					print_r("<br />");
					print_r($desPol);
				}else{
				 	switch($modulo){
						case 1:
							$delPol = "Factura " + $numov;
							break;
						case 2:
							$delPol = "Pago Factura" +$numov;
							break;
						default:
							$delPol = $armaConsulta = $this->armaDescripcion($banco, $rowGuiaContable->descripcion);
						break;	
				 	}
				}
				if ($importe <> 0){
					switch($origen){
						case 'CLI':
							$posicion = ctaclt;
							$subcta = $this->busca_SubCuenta($proveedor, $origen);
							break;
						case 'PRO':
							$posicion = ctapro;
							$subcta = $this->busca_SubCuenta($proveedor, $origen);
							break;
						case 'BAN':
							/*Falta funcion banco*/
							$posicion = ctaban;
							$subcta = $this->busca_SubCuenta($proveedor, $origen);
							break;
						default:
							$posicion = "0000";
							$subcta = 0;
					}
				}
				
				if($origen ="BAN"){
					
					//TRY
					try{
						//$datos = $this->generaGruposFactura($datos);
						//$datos = $this->generaGruposFacturaProveedor($datos);
						$mPoliza = array(
							/*'idModulo'=>1,
							'idTipoProveedor'=>$rowGuiaContable->idTipoProveedor,
							'idSucursal'=>$datos['idSucursal'],
							'idCoP'=>$proveedor,
							//'cta'=>106, 
							//'sub1'=>$armaCuenta = $this->arma_Cuenta(1, $posicion, right($rowGuiaContable->sub1, $length), right($rowGuiaContable->sub2, $length), right($rowGuiaContable->sub3, $length), right($rowGuiaContable->sub4, $length), right($rowGuiaContable->sub5, $length)),
							//'sub2'=>$stringIni,
							//'sub4'=> $secuencial,
							/*'sub5'=>$precioUnitario,
							'fecha'=>$producto['importe'],
							'descripcion'=>$stringIni,
							'cargo'=>"A",
							'abono'=> $secuencial,
							'numDocto'=>$precioUnitario,
							'secuencial'=>$producto['importe']*/
					);
				
				// $dbAdapter->insert("Poliza",$mPoliza);
				//$dbAdapter->commit();
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
				//$dbAdapter->rollBack();
			}
					
				}
			}
		}
		
		public function crear_Texto(){
			$coma = " ";
			$espacio = "         ";
			
			//Creamos el poliza .txt
			$poliza_txt = "poliza.txt";
			if($archivo = fopen($poliza_txt, "w")){//Abre archivo
			
			//Agrupamos por movimiento y empresa
			$tablaPoliza = $this->tablaPoliza;
			$select = $tablaPoliza->select()->from($tablaPoliza, array('idSucursal','fecha','numDocto','idModulo'))->group('idSucursal')
			->group('fecha')->group('numDocto')->group('idModulo')->order('idSucursal')->order('numDocto');
			$rowsGrupoPoliza = $tablaPoliza->fetchAll($select);
			//rowsGrupoPoliza regresa grupo
			//print_r("$select");
			$cont =0;
			if(!is_null($rowsGrupoPoliza)){
				//while o foreach
				foreach($rowsGrupoPoliza as $rowGrupoPoliza){
					$select = $tablaPoliza->select()->from($tablaPoliza)->where("idSucursal = ?", $rowGrupoPoliza["idSucursal"])->where("numDocto = ?", $rowGrupoPoliza["numDocto"])
					->where("idModulo=?",$rowGrupoPoliza["idModulo"])->order('idSucursal')->order('fecha')->order('numDocto')->order('idModulo');
					$rowsPoliza = $tablaPoliza->fetchAll($select);
					print_r("<br />");
					print_r("Busca en poliza desde el grupo");
					print_r("$select");
					
					if(!is_null($rowsPoliza)){
						//contabilizamos el numero de registro
						$select = $tablaPoliza->select()->from($tablaPoliza,  array('count("idMoculo") as contabi'))->where("idSucursal = ?", $rowGrupoPoliza["idSucursal"])->where("numDocto = ?", $rowGrupoPoliza["numDocto"])
						->where("idModulo=?",$rowGrupoPoliza["idModulo"])->group('idModulo');
						$rowPolizaCont = $tablaPoliza->fetchRow($select);
						print_r("<br />");
						$contabiliza = $rowPolizaCont->contabi;
						$cont = 0;
						print_r($contabiliza);
						//print_r("$select");
						foreach($rowsPoliza as $rowPoliza){
							if($rowPoliza["idModulo"] > 10 && $cont=0){
								$mensaje = "GASTOS";
								print_r($mensaje);
							}else{
								$mensaje = $rowPoliza["descripcion"] ;
								print_r($mensaje);
							}
							
							$tipoES = $rowPoliza["tipoES"];
							switch($tipoES){
								case 'E'://Egreso
									$tipo = 1;
									break;
								case 'S': //Salida
									$tipo = 2;
									break;
								case 'D': //Deudor
									$tipo = 3;
									break;	
							}
							
							//Genera Encabezado
							if($cont == 0 && $contabiliza = 3){
								$fecha = $rowPoliza->fecha;
								$arrayFecha = explode("-", $fecha,3);
								$fechaS= $arrayFecha[0].$arrayFecha[1].substr($arrayFecha[2], 0, -8);
								print_r($fechaS	);
								fwrite($archivo,"P".$coma.$coma .$fechaS.$coma.$coma.$coma.$coma.$espacio ."1".$coma ."1".$coma ."0" .$espacio .$coma . str_pad($mensaje,97) .$coma .$coma .$coma .$coma ."11 0 0". PHP_EOL);
								
							}
							
							$cont = $cont +1;
							$numMovto = $rowPoliza["numDocto"];
							$temNumDocto = strlen($numMovto);
							
							if($temNumDocto < 5){
								foreach ($temNumDocto as $temNumDocto) {
									$numMovto = " ".$numMovto;
									$temNumDocto= $temNumDocto + 1;
								}
							}else{
								print_r("el numdocto es mayor o igual a 5");
							}
							
							if($rowPoliza["cargo"] <> 0){
								$cargo = round($rowPoliza["cargo"]);
								print_r( "<br />");
								//print_r("El cardo es igual". "<br />");
								//print_r($cargo);
								$importe = $cargo;
								$debeHaber = 0;
								print_r( "<br />");
								print_r("debeHaber". "<br />");
								print_r($debeHaber);
	
							}
									
							if($rowPoliza["abono"] <> 0){
								$abono = round($rowPoliza["abono"]);
								print_r( "<br />");
								print_r($abono);
								$importe = $abono;
								$debeHaber = 1;
								
								print_r( "<br />");
								print_r("El debeHaber". "<br />");
								print_r($debeHaber);
							}
	
							
							//Espacios para importe
									$temImporte =strlen($importe);
									//if($temImporte < 10	){
										//foreach ($temImporte as $temImporte) {
											//$importe = $importe. " ";
											//$temImpor = $temImpor + 1;
										//}
									//}
									$moneda =1;
									$d1 = $rowPoliza["cta"];
									$d2 = $rowPoliza["sub1"];
									//Prueba txtfile.Writeline ("M1" & Coma & D1 & D2 & Coma & Coma & Coma & Espacio & Espacio & Coma & Coma & numoper & Espacio & Coma & Coma & Coma & Coma & Coma & Coma & debehaber & Coma & Importe & Espacio & Coma & Coma & "0" & Espacio & Coma & "0.0" & Espacio & Espacio & Mensaje & Espacio)
									fwrite($archivo,"M1" .$coma .$d1 .$d2 .$coma .$coma .$coma .$espacio. $espacio .$coma .$coma .$coma .$coma .$numMovto.$espacio.$coma.$coma.$coma.$coma.$coma.$coma .$debeHaber.$coma.$importe.$espacio.$coma.$coma ."0".$espacio .$coma ."0.0" .$espacio .$espacio . str_pad($mensaje,97).$espacio.PHP_EOL);		
							}
						}//cierra foreach $rowsPoliza	
					}//Cierra if rowsPoliza 	
				}//Cierra foreach
			}//cierra if agrupa poliza
		}//cierra funcion crear_Texto
	}