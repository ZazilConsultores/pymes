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
			//Seleccionamos el producto para su clasificacion, Ver si la validación del producto se puede hacer desde jquery
			$tablaProducto = $this->tablaProducto;
			$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?", $producto["descripcion"]);
			$rowProducto = $tablaProducto->fetchRow($select);
			
			print_r("$select");
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
					case 'PT':
					//print_r("<br />");
					$tablaCapas = $this->tablaCapas;
					$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['descripcion']);
					$rowCapas = $tablaCapas->fetchRow($select);
					if(is_null($rowCapas)){
						$mCapas = array(
								'idSucursal'=>$encabezado['idSucursal'],
								'numeroFolio'=>1,
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
					print_r("<br />");
					//print_r($costoCliente);
					if(is_null($rowInventario)){
						$mInventario = array(
							'idProducto'=>$producto['descripcion'],
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
			$select = $tablaProdComp->select()->from($tablaProdComp)->where("idProducto=?",$producto["descripcion"]);
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
	
				}//switch
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