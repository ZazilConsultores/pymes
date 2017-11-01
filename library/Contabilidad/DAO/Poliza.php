<?php
class Contabilidad_DAO_Poliza implements Contabilidad_Interfaces_IPoliza {
	private $tablaCuentasxp;
	private $tablaCuentasxc;
	private $tablaProveedores;
	private $tablaFactura;
	private $tablaProveedorEmpresa;
	private $tablaGuiaContable;
	private $tablaBancos;
	private $tablaClientes;
	private $tablaPoliza;
	private $tablaFacturaImpuesto;
	private $tablaImpuesto;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp(array('db'=>$dbAdapter));
		$this->tablaCuentasxc = new Contabilidad_Model_DbTable_Cuentasxc(array('db'=>$dbAdapter));
		$this->tablaProveedores = new Sistema_Model_DbTable_Proveedores(array('db'=>$dbAdapter));
		$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
		$this->tablaProveedorEmpresa = new Sistema_Model_DbTable_ProveedoresEmpresa(array('db'=>$dbAdapter));
		$this->tablaGuiaContable = new Contabilidad_Model_DbTable_GuiaContable(array('db'=>$dbAdapter));
		$this->tablaGuiaContable = new Contabilidad_Model_DbTable_GuiaContable(array('db'=>$dbAdapter));
		$this->tablaBancos = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes(array('db'=>$dbAdapter));
		$this->tablaPoliza = new Contabilidad_Model_DbTable_Poliza(array('db'=>$dbAdapter));
		$this->tablaFacturaImpuesto = new Contabilidad_Model_DbTable_FacturaImpuesto(array('db'=>$dbAdapter));
		$this->tablaImpuesto = new Contabilidad_Model_DbTable_Impuesto(array('db'=>$dbAdapter));
	}

	public function eliminarPoliza(){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->delete("Poliza");
	}
	
	public function generaGruposFacturaProveedor($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		
		$empresaProveedor; //empresa proveedora cuando el tipo no es bueno (Compras), pero es proveedor
		//Iniciamos variables
		$secuencial = 0;
		$subTotal = 0; 
		$iva = 0;
		$total = 0; 
		$idProveedor = 0; 
		$idFactura = 0; 
		$importe = 0;
		$idBanco =0;
		$numMov=0; 
		$consecutivo = 0;
		$nivel=1;
		$descripcionPol;
		$fecha; 
		$tipoES;	
		try{
			//Seleccionamos grupoFactura por fecha, tipoMovto = 4 facturaProveedor, idSucursal y estatus
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where('fecha >= ?',$stringFechaInicio)->where('fecha <=?',$stringFechaFinal)->where('idTipoMovimiento=?',4)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsGrupoFacturaP = $tablaFactura->fetchAll($select);
			//print_r("$select");
			//Verificamos que existe facturasProveedor 
			if(!is_null($rowsGrupoFacturaP)){
				foreach($rowsGrupoFacturaP as $rowFacturaP){
					//Obtenemos el idProveedor y el tipo
					$idCoP = $rowFacturaP["idCoP"];
					$tablaProveedores = $this->tablaProveedores;
					$select = $tablaProveedores->select()->from($tablaProveedores, array('idProveedores','idTipoProveedor'))->where("idProveedores = ?", $idCoP);
					$rowProveedor = $tablaProveedores->fetchRow($select);
					//print_r("$select"); //Verificamos que el proveedor exista
					if(!is_null($rowProveedor)){
						$tipo = $rowProveedor->idTipoProveedor;
						//Buscamos si es empresaProveedor
						$tablaProveedoresEmpresa = $this->tablaProveedorEmpresa;
						$select = $tablaProveedoresEmpresa->select()->from($tablaProveedoresEmpresa)->where("idProveedores =?", $idCoP);
						$rowProveedoresEmpresa = $tablaProveedoresEmpresa->fetchRow($select); 
						//print_r("$select");
						$idsProveedor = explode(",", $rowProveedoresEmpresa->idProveedores);
						//print_r($idsProveedor); //Verificamos que el proveedor, sea un proveedor de la empresa selecciona //if(!is_null($rowProveedoresEmpresa)){
						$empresaProveedor = $rowProveedoresEmpresa["idEmpresas"];
						//print_r("El tipo es:"); //print_r($tipo); //Verificamos que el tipo sea= 5 (bueno) y que sea un proveedor empresa de lo contrario  no se relizara poliza.
						if($tipo == 5  || $empresaProveedor == $datos["idEmpresas"]){
							$idFactura = $rowFacturaP["idFactura"];
							$modulo = 1; //Asignamos 1=>"Compra"
							$numMov = $rowFacturaP["numeroFactura"];
							$subTotal = $rowFacturaP["subtotal"];
							$total = $rowFacturaP["total"];
							$fecha = $rowFacturaP["fecha"];
							//Buscamos en FacturaImpuesto el iva
							$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
							$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idFactura=?", $idFactura)->where("idTipoMovimiento =?",4);
							$rowFacturaImp =$tablaFacturaImpuesto->fetchRow($select);
							$iva = $rowFacturaImp->importe; //print_r("<br />"); print_r("iva:"); print_r($iva);
							//print_r("<br />"); //Seleccionamos en la guia contable el modulo y el tipo
							$tablaGuiaContable = $this->tablaGuiaContable;
							$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?", $tipo);
							$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
							//print_r("$select");
							if(!is_null($rowsGuiaContable)){
								foreach($rowsGuiaContable as $rowGuiaContable){
									$origen =$rowGuiaContable["origen"]; //Indica el importe corresponidente a cada registro
									switch($origen){
										case 'S':
											$importe = $subTotal;
											$origen = "SIN"; //No se porque va
											//print_r("<br />"); print_r("importe subtotal:"); //print_r($importe);print_r($importe);
										break;
										case 'I':
											$importe = $iva;
											$origen = "SIN";
											//print_r("importe iva:"); //print_r($importe);print_r("<br />");print_r($importe);
										break;
										case 'T':
											$importe = $total;
											$origen	= "PRO";
											//print_r("<br />"); print_r("importe total:"); //print_r($importe);print_r($origen);
										break;
									}//Cierra el switch origen
									//Asigna tipoES
									if($rowGuiaContable["origen"] =='I'){
										$tipoES = "D";
										//print_r("<br />");print_r($tipoES);
									}else{
										$tipoES = "D";
										//print_r("<br />"); print_r($tipoES);
									}//Cierra tipoES
									//asigna abono o cargo
									if($rowGuiaContable["cargo"]== "X"){
										$cargo = $importe;
										//print_r($cargo);
									}else{
										$cargo = "0";
									}
										
									if($rowGuiaContable["abono"]== "X"){
										$abono = $importe;
									}else{
										$abono = 0;
									}						
									//Arma descripcion
									if($rowGuiaContable["origen"] =='I' || $rowGuiaContable["origen"] == 'S'){
										$desPol = $rowGuiaContable->descripcion;
										//print_r("<br />");//print_r($desPol);
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
									//Busca ctaProveedor y valor de subcuenta.
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
									$mascara= Zend_Registry::get("mascara");
									//print_r($mascara);
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
										}else{
											$armaSub1 = $rowGuiaContable["sub1"];
										}						
									}
									if($nivel2 == 2){
										if($posicion == 2){
											$armaSub2 = $subCta;
										}else{
											$armaSub2 = $rowGuiaContable["sub2"];
											
										}						
									}
									if($nivel3 == 3){
										if($posicion == 3){
											$armaSub3 = $subCta;
										}else{
											$armaSub3 = $rowGuiaContable["sub3"];
										}						
									}
									if($nivel4 == 4){
										if($posicion == 4){
											$armaSub4 = $subCta;
										}else{
											$armaSub4 = $rowGuiaContable["sub4"];
										}						
									}
									if($nivel5 == 5){
										if($posicion == 5){
											$armaSub5 = $subCta;
										}else{
											$armaSub5 = $rowGuiaContable["sub5"];
											
										}						
									}
									//Asignamos secuencial
									$tablaPoliza = $this->tablaPoliza;
									$select = $tablaPoliza->select()->from($tablaPoliza)->where("idModulo=?",$modulo)->where("idTipoProveedor=?",$tipo)->where("idSucursal=?",$datos['idSucursal'])
									->where("idCoP=?",$idCoP)->where("numDocto=?", $numMov)->order("secuencial DESC");
									$rowPoliza = $tablaPoliza->fetchRow($select); 
									//print_r("$select");
									if(!is_null($rowPoliza)){
										$secuencial= $rowPoliza->secuencial +1;
									}else{
										$secuencial = 1;	
										
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
										'secuencial'=>$secuencial);
										//print_r($mPoliza);
										$dbAdapter->insert("Poliza", $mPoliza);
									}//cierra forach
								}//cierra if guiaContable
							}
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
			$select = $tablaFactura->select()->from($tablaFactura)->where('fecha >= ?',$stringFechaInicio)->where('fecha <=?',$stringFechaFinal)->where('idTipoMovimiento=?',2)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsGrupoFacturaC = $tablaFactura->fetchAll($select);
			if(!is_null($rowsGrupoFacturaC)){
				foreach($rowsGrupoFacturaC as $rowGrupoFacturaC){
					$idSucursal = $rowGrupoFacturaC["idSucursal"];
					$idFactura = $rowGrupoFacturaC["idFactura"];
					$numMov = $rowGrupoFacturaC["numeroFactura"];
					$subTotal = $rowGrupoFacturaC["subtotal"];
					$total = $rowGrupoFacturaC["total"];
					$fecha = $rowGrupoFacturaC["fecha"];
					$idCoP = $rowGrupoFacturaC["idCoP"];
					//Buscamos en FacturaImpuesto el iva
					$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
					$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idFactura=?", $idFactura)->where("idTipoMovimiento =?",2);
					$rowFacturaImp =$tablaFacturaImpuesto->fetchRow($select);
					$iva = $rowFacturaImp->importe;
					//print_r("<br />");
					//Buscamos la cuenta de cliente
					$tablaClientes = $this->tablaClientes;
					$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente = ?", $idCoP);
					$rowCliente = $tablaClientes->fetchRow($select);
					//print_r("$select");
					if(!is_null($rowCliente)){
						//Definimos el modulo y el tipo
						$tipo = 5;
						$modulo = 5;
						//Genera PolizaC
						$tablaGuiaContable = $this->tablaGuiaContable;
						$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
						$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
						//print_r("$select");
						if(!is_null($rowsGuiaContable)){
							foreach($rowsGuiaContable as $rowGuiaContable){
								$origen = $rowGuiaContable->origen;
								switch($origen){
									case 'S':
										$importe = $subTotal;
										$origen = "SIN";
										//print_r("<br />");
										break;
									case 'I':
										$importe = $iva;
										$origen = "SIN";
										break;
									case 'T':
										$importe = $total;
										if($tipo == 5 && $rowGuiaContable->abono == "X"){
											$origen	= "CLT";	
										}else{
											if($tipo == 5 && $rowGuiaContable->cargo == "X" ){
												$origen = "CLT";
											}else{
												$origen= "BAN";
											}
										}
									break;
								}
								//asigna abono o cargo
								if($rowGuiaContable["cargo"]== "X"){
									$cargo = $importe;
									
								}else{
									$cargo = "0";
								}
								if($rowGuiaContable["abono"]== "X"){
									$abono = $importe;
								}else{
									$abono = 0;
								}						
								//Arma descripcion
								if($rowGuiaContable["origen"] == 'I' || $rowGuiaContable["origen"] == 'S'){
									$desPol = $rowGuiaContable->descripcion;
									//print_r("<br />");
								}else{
									//Crear descripcion
									switch($modulo){	
										case '1':
											$desPol = "Factura " .$numMov;
											break;
										case '5':
											$desPol = "Factura" .$numMov ;
											break;
										case '3':
											$desPol = "Pago Factura " .$numMov;
											break;
										default:
											$delPol = $armaConsulta = $this->armaDescripcion($banco, $rowGuiaContable->descripcion);
									}//Cierra switch en casso de armar descripcion
								}//Cierra  if arma descripcion
								if($origen == "CLT"){
									$tablaClientes = $this->tablaClientes;
									$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?",$idCoP);
									$rowCliente = $tablaClientes->fetchRow($select);
									$subCta = $rowCliente["cuenta"];
									$posicion = 1;
								}else{
									$subCta = "0000";
									$posicion = 0;
								}//Cierra if origen 
								//Creamos switch para Armar_Cuenta
								$mascara= Zend_Registry::get("mascara");
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
									}else{
										$armaSub1 = $rowGuiaContable["sub1"];
									}						
								}
								if($nivel2 == 2){
									if($posicion == 2){
										$armaSub2 = $subCta;
									}else{
										$armaSub2 = $rowGuiaContable["sub2"];	
									}						
								}
								if($nivel3 == 3){
									if($posicion == 3){
										$armaSub3 = $subCta;
									}else{
										$armaSub3 = $rowGuiaContable["sub3"];
									}						
								}
								if($nivel4 == 4){
									if($posicion == 4){
										$armaSub4 = $subCta;
									}else{
										$armaSub4 = $rowGuiaContable["sub4"];
									}						
								}
								if($nivel5 == 5){
									if($posicion == 5){
										$armaSub5 = $subCta;
									}else{
										$armaSub5 = $rowGuiaContable["sub5"];
									}						
								}
								$secuencial = 0;	
								$tablaPoliza = $this->tablaPoliza;
								$select = $tablaPoliza->select()->from($tablaPoliza)->where("idModulo=?",$modulo)->where("idTipoProveedor=?",$tipo)
								->where("idSucursal=?",$datos['idSucursal'])->where("idCoP=?",$idCoP)->where("numDocto=?", $numMov)->order("secuencial DESC");
								$rowPoliza = $tablaPoliza->fetchRow($select); 
								if(!is_null($rowPoliza)){
									$secuencial= $rowPoliza->secuencial +1;
								}else{
									$secuencial = 1;
								}		
								//Guarda en Poliza
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
									'fecha'=>$fecha,
									'descripcion'=>$desPol,
									'tipoES'=>"D",
									'cargo'=>$cargo,
									'abono'=>$abono,
									'numdocto'=>$numMov,
									'secuencial'=>$secuencial
								);
								
								$dbAdapter->insert("Poliza", $mPoliza);
							}
						}//cierra if guiaContable
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
			$dbAdapter->rollBack();
		}	
	}
		
	public function generaGruposNotaCredito($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		try{
			//Seleccionamos grupoFactura por fecha, tipoMovto = 17 Nota Credito, idSucursal y estatus
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where('fecha >= ?',$stringFechaInicio)->where('fecha <=?',$stringFechaFinal)->where('idTipoMovimiento=?',17)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsGrupoFacturaC = $tablaFactura->fetchAll($select);
			if(!is_null($rowsGrupoFacturaC)){
				foreach($rowsGrupoFacturaC as $rowGrupoFacturaC){
					$idSucursal = $rowGrupoFacturaC["idSucursal"];
					$idFactura = $rowGrupoFacturaC["idFactura"];
					$numMov = $rowGrupoFacturaC["numeroFactura"];
					$subTotal = $rowGrupoFacturaC["subtotal"];
					$total = $rowGrupoFacturaC["total"];
					$fecha = $rowGrupoFacturaC["fecha"];
					$idCoP = $rowGrupoFacturaC["idCoP"];
					//Buscamos en FacturaImpuesto el iva
					$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
					$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idFactura=?", $idFactura)->where("idTipoMovimiento =?",17);
					$rowFacturaImp =$tablaFacturaImpuesto->fetchRow($select);
					$iva = $rowFacturaImp->importe; //print_r("<br />"); print_r("iva:"); print_r($iva);
					//print_r("<br />");print_r("$select");
					$tablaClientes = $this->tablaClientes;
					$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente = ?", $idCoP);
					$rowCliente = $tablaClientes->fetchRow($select);
					//print_r("$select");
					if(!is_null($rowCliente)){
						$tipo = 5;
						$modulo = 9;
						$tablaGuiaContable = $this->tablaGuiaContable;
						$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
						$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
						//print_r("<br />");print_r("$select");
						if(!is_null($rowsGuiaContable)){
							foreach($rowsGuiaContable as $rowGuiaContable){
								$origen = $rowGuiaContable->origen;
								switch($origen){
									case 'S':
										$importe = $subTotal;
										$origen = "SIN";
									break;
									case 'I':
										$importe = $iva;
										$origen = "SIN";
									break;
									case 'T':
										$importe = $total;
										if($tipo == 5 && $rowGuiaContable->abono == "X"){
											$origen	= "CLT";	
										}else{
											if($tipo == 5 && $rowGuiaContable->cargo == "X" ){
											$origen = "CLT";
										}else{
											$origen= "BAN";
										}
									}	
									break;
								}
							
								if($rowGuiaContable["cargo"]== "X"){
									$cargo = $importe;
								}else{
									$cargo = "0";
								}
								if($rowGuiaContable["abono"]== "X"){
									$abono = $importe;
								}else{
									$abono = 0;
								}						
								//Arma descripcion
								if($rowGuiaContable["origen"] == 'I' || $rowGuiaContable["origen"] == 'S'){
									$desPol = $rowGuiaContable->descripcion;
								}else{
									switch($modulo){
										case '1':
											$desPol = "Factura " .$numMov;
										break;
										case '9':
											$desPol = "Factura" .$numMov ;
										break;
										case '3':
											$desPol = "Pago Factura " .$numMov;
										break;
										default:
										$delPol = $armaConsulta = $this->armaDescripcion($banco, $rowGuiaContable->descripcion);
									}//Cierra switch en casso de armar descripcion
								}//Cierra  if arma descripcion
								if($origen == "CLT"){
									$tablaClientes = $this->tablaClientes;
									$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?",$idCoP);
									$rowCliente = $tablaClientes->fetchRow($select);
									$subCta = $rowCliente["cuenta"];
									//$subCta = 0150;
									$posicion = 1;
								}else{
									$subCta = "0000";
									$posicion = 0;
								}//Cierra if origen <cliente></cliente>
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
									}else{
										$armaSub1 = $rowGuiaContable["sub1"];
									}						
								}
								if($nivel2 == 2){
									if($posicion == 2){
										$armaSub2 = $subCta;
									}else{
										$armaSub2 = $rowGuiaContable["sub2"];
									}						
								}
								if($nivel3 == 3){
									if($posicion == 3){
										$armaSub3 = $subCta;
									}else{
										$armaSub3 = $rowGuiaContable["sub3"];
									}						
								}
								if($nivel4 == 4){
									if($posicion == 4){
										$armaSub4 = $subCta;
									}else{
										$armaSub4 = $rowGuiaContable["sub4"];
									}						
								}
								if($nivel5 == 5){
									if($posicion == 5){
										$armaSub5 = $subCta;
									}else{
										$armaSub5 = $rowGuiaContable["sub5"];
									}						
								}
								$secuencial = 0;	
								$tablaPoliza = $this->tablaPoliza;
								$select = $tablaPoliza->select()->from($tablaPoliza)->where("idModulo=?",$modulo)->where("idTipoProveedor=?",$tipo)->where("idSucursal=?",$datos['idSucursal'])
								->where("idCoP=?",$idCoP)->where("numDocto=?", $numMov)->order("secuencial DESC");
								$rowPoliza = $tablaPoliza->fetchRow($select); 
								//print_r("$select");
								if(!is_null($rowPoliza)){
									$secuencial= $rowPoliza->secuencial +1;
								}else{
									$secuencial = 1;	
								}		
								//Guarda en Poliza
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
									'fecha'=>$fecha,/**/
									'descripcion'=>$desPol,
									'tipoES'=>"E",
									'cargo'=>$cargo,
									'abono'=>$abono,
									'numdocto'=>$numMov,
									'secuencial'=>$secuencial
								);
								//print_r($mPoliza);
								$dbAdapter->insert("Poliza", $mPoliza);
							}//cierra forach
						}//cierra if guiaContable
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
	public function generacxc($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		
		try{
			//Seleccionamos grupoCuentasxc por fecha, tipoMovto = 16  Cobro Factura, idSucursal y estatus
			$tablaCtsxc = $this->tablaCuentasxc;
			$select = $tablaCtsxc->select()->from($tablaCtsxc)->where('fechaPago >= ?',$stringFechaInicio)
			->where('fechaPago <=?',$stringFechaFinal)->where('idTipoMovimiento=?',16)->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsCuentaxc = $tablaCtsxc->fetchAll($select);
			//print_r($select->__toString());
			if(!is_null($rowsCuentaxc)){
				foreach($rowsCuentaxc as $rowcxc){
					$idCoP = $rowcxc["idCoP"];
					$tablaClientes = $this->tablaClientes;
					$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente = ?", $idCoP);
					$rowCliente = $tablaClientes->fetchRow($select);
					//Verificamos que el cliente exista
					if(!is_null($rowCliente)){
						$tipo = 5;
						$modulo = 3;
						//Asignamos variables
						$banco = $rowcxc["idBanco"];
						$idSucursal = $rowcxc["idSucursal"];
						$numeroFolio = $rowcxc["numeroFolio"];
						$fecha = $rowcxc["fechaPago"];
						$subtotal = $rowcxc["subtotal"];
						$total = $rowcxc["total"];
						$secuencial = $rowcxc["secuencial"];
						//Buscamos en FacturaImpuesto el iva
						$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
						$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idFactura=?", $rowcxc->idFactura)->where("idTipoMovimiento =?",16);
						$rowFacturaImp =$tablaFacturaImpuesto->fetchRow($select);
						//print_r("<br />"); //print_r("$select");
						$iva = $rowFacturaImp->importe;
						//Iniciamos polizaP
						$tablaGuiaContable = $this->tablaGuiaContable;
						$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
						$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
						//print_r("<br />"); //print_r("$select");
						foreach($rowsGuiaContable as $rowGuiaContable){
							$origen = $rowGuiaContable->origen;
							//print_r($origen);
							switch($origen){
								case 'S':
									$importe = $subTotal;
									$origen = "SIN"; 
								break;
								case 'I':
									$importe = $iva;
									$origen = "SIN";
									$descripcionPol = $rowGuiaContable->descripcion;
									break;
								case 'T':
									$importe = $total;
									if($tipo == 5 && $rowGuiaContable->abono == "X" && $modulo = 3 ){
										$origen	= "CLT";
										//print_r("origen es:");print_r($origen);
									}else{
										if($tipo == 5  &&  $rowGuiaContable->cargo == "X" ){
											$origen = "BAN";
										}
									}
									
								break;
							}
							//asigna abono o cargo
							if($rowGuiaContable["cargo"]== "X"){
								$cargo = $importe;
							}else{
								$cargo = 0;
							}
							if($rowGuiaContable["abono"]== "X"){
								$abono = $importe;
							}else{
								$abono = 0;
							}
							//Arma descripcion
							if($rowGuiaContable->origen =='I' || $rowGuiaContable->origen == "S"){
								$desPol = $rowGuiaContable->descripcion;
							}else{
								switch($modulo){
									case '1':
										$desPol = "Factura " .$numeroFolio;
									break;
									case '5':
										$desPol = "Factura" .$numeroFolio ;
									break;
									case '3':
										$desPol = "Cobro Factura " .$numeroFolio;
									break;
									default:
									$delPol = $armaConsulta = $this->armaDescripcion($banco, $rowGuiaContable->descripcion);
								}//Cierra switch en caso de armar descripcion
							}//Cierra  if arma descripcion
							//Busca ctaCliente y valor de subcuenta. El proveedor  el nivel es 1
							switch($origen){
								case 'BAN':
									$tablaBancos = $this->tablaBancos;
									$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$banco);
									$rowBanco = $tablaBancos->fetchRow($select);
									if($rowBanco->tipo ==="CA"){
										$cta = 101;
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}else{
										$cta = $rowGuiaContable["cta"];
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}
								break;
								case 'CLT':
									$tablaClientes = $this->tablaClientes;
									$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?",$idCoP);
									$rowCliente = $tablaClientes->fetchRow($select);
									$cta = $rowGuiaContable["cta"];
									$subCta = $rowCliente["cuenta"];
									$posicion = 1;
								break;
								default:
									$cta = $rowGuiaContable["cta"];
									$subCta = "0000";
									$posicion = 0;
							}
							//Creamos switch para Armar_Cuenta
							$mascara= Zend_Registry::get("mascara");
							//print_r($mascara);
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
								}else{
									$armaSub1 = $rowGuiaContable["sub1"];
										
								}						
							}
							if($nivel2 == 2){
								if($posicion == 2){
									$armaSub2 = $subCta;
								}else{
									$armaSub2 = $rowGuiaContable["sub2"];
								}						
							}
							if($nivel3 == 3){
								if($posicion == 3){
									$armaSub3 = $subCta;
								}else{
									$armaSub3 = $rowGuiaContable["sub3"];
								}						
							}
							if($nivel4 == 4){
								if($posicion == 4){
									$armaSub4 = $subCta;
								}else{
									$armaSub4 = $rowGuiaContable["sub4"];
								}						
							}
							if($nivel5 == 5){
								if($posicion == 5){
									$armaSub5 = $subCta;
								}else{
									$armaSub5 = $rowGuiaContable["sub5"];
								}						
							}
							$mPoliza = array(
								'idModulo'=>$modulo,
								'idTipoProveedor'=>$rowGuiaContable["idTipoProveedor"],
								'idSucursal'=>$datos['idSucursal'],
								'idCoP'=>$idCoP,
								'cta'=>$cta,
								'sub1'=>$armaSub1,
								'sub2'=>$armaSub2,
								'sub3'=>$armaSub3,
								'sub4'=>$armaSub4,
								'sub5'=>$armaSub5,
								'tipoES'=>"I",
								'fecha'=>$fecha,
								'descripcion'=>$desPol,
								'cargo'=>$cargo,
								'abono'=>$abono,
								'numdocto'=>$numeroFolio,
								'secuencial'=>1
							);
							//print_r($mPoliza);
							$dbAdapter->insert("Poliza", $mPoliza);
						}//cierra forache $rowGuiaContable
					}//if cliente
				}//foreach grupo cuentasxc
			}//if not null $rowsCuentaxc
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
			print_r($select->__toString());
			if(!is_null($rowsCxp)){
				foreach($rowsCxp as $rowCxp){
					$idCoP = $rowCxp["idCoP"];
					$tablaProveedores = $this->tablaProveedores;
					$select = $tablaProveedores->select()->from($tablaProveedores, array('idProveedores','idTipoProveedor'))->where("idProveedores = ?", $idCoP);
					$rowProveedor = $tablaProveedores->fetchRow($select);
					//print_r("$select"); //Verificamos que el proveedor exista
					if(!is_null($rowProveedor)){
						//Nomina
						$tipo = $rowProveedor->idTipoProveedor;
						if($tipo == 5){//Asignamos el modulo dependiento de tipo Proveedor
							$modulo = 2;
						}else{
							$modulo = 4;
						}
						//Asignamos variables
						$banco = $rowCxp["idBanco"];
						$idSucursal = $rowCxp["idSucursal"];
						$numeroFolio = $rowCxp["numeroFolio"];
						$fecha = $rowCxp["fechaPago"];
						$subtotal = $rowCxp["subtotal"];
						$total = $rowCxp["total"];
						$secuencial = $rowCxp["secuencial"];
						//Buscamos en FacturaImpuesto el iva
						$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
						$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idFactura=?", $rowCxp->idFactura)->where("idTipoMovimiento =?",15);
						$rowFacturaImp =$tablaFacturaImpuesto->fetchRow($select);
						//print_r("<br />"); print_r("$select");
						$iva = $rowFacturaImp->importe; //print_r("<br />"); print_r("iva:"); print_r($iva);
						//print_r("<br />");
						$tablaGuiaContable = $this->tablaGuiaContable;
						$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
						$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
						print_r("<br />"); print_r("$select");
						foreach($rowsGuiaContable as $rowGuiaContable){
							$origen = $rowGuiaContable->origen;
							switch($origen){
								case 'S':
									$importe = $subtotal;
									$origen = "SIN"; //No se porque va
									//print_r("<br />"); print_r("importe subtotal:"); print_r($importe);
								break;
								case 'I':
									$importe = $iva;
									$origen = "SIN";
									$descripcionPol = $rowGuiaContable->descripcion;
									//print_r("<br />");print_r("importe iva:"); print_r($importe);
								break;
								case 'T':
									$importe = $total;
									if($tipo == 5 && $rowGuiaContable->cargo == "X"){
										$origen	= "PRO";
									}else{
										if($tipo === 1 || $tipo === 2 && $rowGuiaContable->cargo ==="X"){
											$origen = "SIN";
											print_r("El origen es:");
											print_r($origen);
										}elseif($rowGuiaContable->abono =="X"){
											print_r("El origen es bancos caja");	
											$origen = "BAN";
										}
									}
								break;
							}
							
							if($rowGuiaContable["cargo"]== "X"){
								$cargo = $importe;
							}else{
								$cargo = 0;
							}
							if($rowGuiaContable["abono"]== "X"){
								$abono = $importe;
							}else{
								$abono = 0;
							}
							//Arma descripcion
							if($rowGuiaContable->origen ='I' || $rowGuiaContable->origen == "S"){
								$desPol = $rowGuiaContable->descripcion;
							}else{
								if($tipo == 1 || $tipo == 2 && $rowGuiaContable->cargo == "X"){
									$desPol = $rowGuiaContable->descripcion;
								}else{
									$delPol = $armaConsulta = $this->armaDescripcion($banco, $rowGuiaContable->descripcion);
								}
							}//Cierra  if arma descripcion
							//Busca ctaProveedor y valor de subcuenta que nos va permitir saber el nivel. El proveedor  el nivel es 1
							switch($origen){
								case 'BAN':
									$tablaBancos = $this->tablaBancos;
									$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$banco);
									$rowBanco = $tablaBancos->fetchRow($select);
									//print_r("Banco error"); print_r("$select");
									if($rowBanco->tipo ==="CA"){
										//print_r("es de tipoCaja");
										$cta = 101;
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}else{
										$cta = $rowGuiaContable["cta"];
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}
								
								break;
								case 'PRO':
									$tablaProveedores = $this->tablaProveedores;
									$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?",$idCoP);
									$rowProveedor = $tablaProveedores->fetchRow($select);
									$cta = $rowGuiaContable["cta"];
									$subCta = $rowProveedor["cuenta"];
									$posicion = 1;
								break;
								case 'SIN':
									$cta = $rowGuiaContable["cta"];
									$subCta = $rowGuiaContable->sub1;
									$posicion = 1;
								break;
								default:
									$cta = $rowGuiaContable["cta"];
									$subCta = "0000";
									$posicion = 0;
								}
								$mascara= Zend_Registry::get("mascara");
								//print_r($mascara);
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
									}else{
										$armaSub1 = $rowGuiaContable["sub1"];
										
									}						
								}
								if($nivel2 == 2){
									if($posicion == 2){
										$armaSub2 = $subCta;
									}else{
										$armaSub2 = $rowGuiaContable["sub2"];
									}						
								}
								if($nivel3 == 3){
									if($posicion == 3){
										$armaSub3 = $subCta;
									}else{
										$armaSub3 = $rowGuiaContable["sub3"];
									}						
								}
								if($nivel4 == 4){
									if($posicion == 4){
										$armaSub4 = $subCta;
									}else{
										$armaSub4 = $rowGuiaContable["sub4"];
									}						
								}
								if($nivel5 == 5){
									if($posicion == 5){
										$armaSub5 = $subCta;
									}else{
										$armaSub5 = $rowGuiaContable["sub5"];
									}						
								}
								//Asignamos secuencial
								$secuencial = 0;	
								$tablaPoliza = $this->tablaPoliza;
								$select = $tablaPoliza->select()->from($tablaPoliza)->where("idModulo=?",$modulo)->where("idTipoProveedor=?",$tipo)
								->where("idSucursal=?",$datos['idSucursal'])->where("idCoP=?",$idCoP)->where("numDocto=?", $numeroFolio)->order("secuencial DESC");
								$rowPoliza = $tablaPoliza->fetchRow($select); 
								if(!is_null($rowPoliza)){
									$secuencial= $rowPoliza->secuencial +1;
								}else{
									$secuencial = 1;	
								}
								//Agregamos en tablaPoliza.
								$mPoliza = array(
									'idModulo'=>$modulo,
									'idTipoProveedor'=>$rowGuiaContable["idTipoProveedor"],
									'idSucursal'=>$datos['idSucursal'],
									'idCoP'=>$idCoP,
									'cta'=>$cta,
									'sub1'=>$armaSub1,
									'sub2'=>$armaSub2,
									'sub3'=>$armaSub3,
									'sub4'=>$armaSub4,
									'sub5'=>$armaSub5,
									'tipoES'=>"E",
									'fecha'=>$fecha,/**/
									'descripcion'=>$desPol,
									'cargo'=>$cargo,
									'abono'=>$abono,
									'numdocto'=>$numeroFolio,
									'secuencial'=>$secuencial);
								$dbAdapter->insert("Poliza", $mPoliza);
							}//cierra forach
						}
				}//Cierra foreach que recorre grupo cuentasxp
			}//Cierra if busca grupoCuentasxp	
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
	
	public function generacxc_Fo($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		try{
			//Buscamos en grupo cuentasxp, fondeo = 3
			$tablaCXC = $this->tablaCuentasxc;
			$select = $tablaCXC->select()->from($tablaCXC)->where('fechaPago >= ?',$stringFechaInicio)->where('fechaPago <=?',$stringFechaFinal)->where('idTipoMovimiento=?',3)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsCXCF = $tablaCXC->fetchAll($select);
			//print_r($select->__toString()); //Verificamos que existe facturasProveedor 
			if(!is_null($rowsCXCF)){
				foreach($rowsCXCF as $rowCXCF){
					$idCoP = $rowCXCF["idCoP"];
					$tablaClientes = $this->tablaClientes;
					$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente = ?", $idCoP);
					$rowCliente = $tablaClientes->fetchRow($select);
					//Verificamos que el cliente exista
					if(!is_null($rowCliente)){
						$modulo = 7;
						$tipo = 28;
						$idSucursal = $rowCXCF->idSucursal;
						$numeroFolio  = $rowCXCF->numeroFolio;
						$subTotal = $rowCXCF->subtotal;
						$total = $rowCXCF->total;
						$fecha = $rowCXCF->fechaPago;
						$banco = $rowCXCF->idBanco;
						$consecutivo = $rowCXCF->secuencial;
						//Buscamos en GuiaContable
						$tablaGuiaContable = $this->tablaGuiaContable;
						$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
						$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
						//print_r("<br />");print_r("$select");
						foreach($rowsGuiaContable as $rowGuiaContable){
							$origen = $rowGuiaContable->origen;
							switch($origen){
								case 'T':
									$importe = $total;
									$origen = "BAN";		
								break;
							}
							if($rowGuiaContable["cargo"]== "X"){
								$cargo = $importe;
							}else{
								$cargo = 0;
							}
							if($rowGuiaContable["abono"]== "X"){
								$abono = $importe;	
							}else{
								$abono = 0;
							}	
							//Busca ctaCliente y valor de subcuenta que nos va permitir saber el nivel. El proveedor  el nivel es 1
							switch($origen){
								case 'BAN':
									$tablaBancos = $this->tablaBancos;
									$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$banco);
									$rowBanco = $tablaBancos->fetchRow($select);
									//print_r("$select");
									if($rowBanco->tipo ==="CA"){
										$cta = 101;
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}else{
										$cta = $rowGuiaContable["cta"];
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}
								break;
								case 'CLT':
									$tablaClientes = $this->tablaClientes;
									$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?",$idCoP);
									$rowCliente = $tablaClientes->fetchRow($select);
									$cta = $rowGuiaContable["cta"];
									$subCta = $rowCliente["cuenta"];
									$posicion = 1;
								break;
								default:
									$cta = $rowGuiaContable["cta"];
									$subCta = "0000";
									$posicion = 0;
							}
							$mascara= Zend_Registry::get("mascara");
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
								}else{
									$armaSub1 = $rowGuiaContable["sub1"];
								}						
							}
							if($nivel2 == 2){
								if($posicion == 2){
									$armaSub2 = $subCta;
								}else{
									$armaSub2 = $rowGuiaContable["sub2"];
								}						
							}
							if($nivel3 == 3){
								if($posicion == 3){
									$armaSub3 = $subCta;
								}else{
									$armaSub3 = $rowGuiaContable["sub3"];
								}						
							}
							if($nivel4 == 4){
								if($posicion == 4){
									$armaSub4 = $subCta;
								}else{
									$armaSub4 = $rowGuiaContable["sub4"];
								}						
							}
							if($nivel5 == 5){
								if($posicion == 5){
									$armaSub5 = $subCta;
								}else{
									$armaSub5 = $rowGuiaContable["sub5"];
								}						
							}
							if($rowGuiaContable["abono"]== "X"){
								$mPoliza = array(
									'idModulo'=>$modulo,
									'idTipoProveedor'=>$rowGuiaContable["idTipoProveedor"],
									'idSucursal'=>$datos['idSucursal'],
									'idCoP'=>$idCoP,
									'cta'=>$cta,
									'sub1'=>$subCta,
									'sub2'=>$armaSub2,
									'sub3'=>$armaSub3,
									'sub4'=>$armaSub4,
									'sub5'=>$armaSub5,
									'tipoES'=>"E",
									'fecha'=>$fecha,
									'descripcion'=>$rowGuiaContable["descripcion"],
									'cargo'=>$cargo,
									'abono'=>$abono,
									'numdocto'=>$numeroFolio,
									'secuencial'=>1);
									print_r($mPoliza);
								$dbAdapter->insert("Poliza", $mPoliza);
							}
						}//cierra forach
					}//if $rowCliente 				
				}//foreach $rowCXCF	
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
		public function generacxp_Fo($datos){
			
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$dbAdapter->beginTransaction();
			$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
			$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
			$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
			$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
			
			try{
			//Buscamos en grupo cuentasxp, fondeo = 3
			$tablaCXP = $this->tablaCuentasxp;
			$select = $tablaCXP->select()->from($tablaCXP)->where('fechaPago >= ?',$stringFechaInicio)->where('fechaPago <=?',$stringFechaFinal)->where('idTipoMovimiento=?',3)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsCXPF = $tablaCXP->fetchAll($select);
			print_r($select->__toString());
			//Verificamos que existe facturasProveedor 
			if(!is_null($rowsCXPF)){
				foreach($rowsCXPF as $rowCXPF){
					//Obtenemos proveedor y tipo
					$idCoP = $rowCXPF["idCoP"];
					$tablaProveedores = $this->tablaProveedores;
					$select = $tablaProveedores->select()->from($tablaProveedores, array('idProveedores','idTipoProveedor'))->where("idProveedores = ?", $idCoP);
					$rowProveedor = $tablaProveedores->fetchRow($select);
					//print_r("$select"); //Verificamos que el proveedor exista
					if(!is_null($rowProveedor)){
						$tipo = $rowProveedor->idTipoProveedor;
						//print_r($tipo);
						if($rowCXPF->idSucursal != $datos["idSucursal"]){//Verificar que sea por idSucursal
							echo "El proveedor no es proveedor de la empresa";
						}
						$tipo = 28;
						$modulo = 7 ;//traspaso
						$banco = $rowCXPF->idBanco;
						$idSucursal = $rowCXPF->idSucursal;
						$numeroFolio = $rowCXPF->numeroFolio;
						$fecha = $rowCXPF->fechaPago;
						$subTotal = $rowCXPF->subtotal;
						$total = $rowCXPF->total;
						$consec =  $rowCXPF->secuencial;
						//GeneraPolizaFOC //Seleccionamos en la guia contable el modulo y el tipo
						$tablaGuiaContable = $this->tablaGuiaContable;
						$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?", $tipo);
						$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
						//print_r("$select");
						//Comprobamos que esta el modulo y el tipo en guia contable
						if(!is_null($rowsGuiaContable)){
							foreach($rowsGuiaContable as $rowGuiaContable){
								$origen = $rowGuiaContable->origen;
								switch($origen){
								case 'T':
									$importe = $total;
									$origen = "BAN";
								break;
								}//switch origen guiaContable
								if($rowGuiaContable["cargo"]== "X"){
									$cargo = $importe;
								}else{
									$cargo = 0;
								}
										
								if($rowGuiaContable["abono"]== "X"){
									$abono = $importe;
								}else{
									$abono = 0;
								}
								//Arma descripcion
								//Busca ctaProveedor y valor de subcuenta que nos va permitir saber el nivel. El proveedor  el nivel es 1
								switch($origen){
								case 'BAN':
									$tablaBancos = $this->tablaBancos;
									$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$banco);
									$rowBanco = $tablaBancos->fetchRow($select);
									if($rowBanco->tipo ==="CA"){
										print_r("es de tipoCaja");
										$cta = 101;
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}else{
										$cta = $rowGuiaContable["cta"];
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}
									break;
								case 'PRO':
									$tablaProveedores = $this->tablaProveedores;
									$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?",$idCoP);
									$rowProveedor = $tablaProveedores->fetchRow($select);
									$cta = $rowGuiaContable["cta"];
									$subCta = $rowProveedor["cuenta"];
									$posicion = 1;
									break;
								default:
									$cta = $rowGuiaContable["cta"];
									$subCta = "0000";
									$posicion = 0;
								}
								//BANCO
								/*if($rowBanco["tipo"] == "CA"){
										print_r("Es operacion caja");
										$posicion = 101;
										print_r("<br />");
										print_r($posicion);
										$subCta = $rowBanco["cuentaContable"];
									}else{
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}*/
									//Buscamos tipo Operacion de banco
									print_r($tipoBanco);
									print_r($tipoBanco);
									print_r("<br />");		
									/*switch($tipoBanco){
									case 'OP':
										//$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									break;
									case 'CA':
									$posicion = 101;
									//$subCta = $rowBanco["cuentaContable"];
								default:
									//$subCta = "0000";
									$posicion = 0;
								}*/
									if($tipoBanco == "CA" ){
											$cta = 101;
											$subCta = $rowBanco["cuentaContable"];
										}else{
											$cta = $rowGuiaContable["cta"];
											$subCta  =  $rowBanco["cuentaContable"];
										}
									
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
											/*}elseif($nivel1 == 101){
												$armaSub1 = $rowGuiaContable["sub1"];
												print_r($armaSub1);*/
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
										if($nivel5 === 5){
											if($posicion == 5){
												$armaSub5 = $subCta;
												print_r("subcuenta5");
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
										->where("numDocto=?", $numeroFolio)
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
										if($rowGuiaContable["cargo"]== "X"){
											
										
										$mPoliza = array(
										'idModulo'=>$modulo,
										'idTipoProveedor'=>$rowGuiaContable["idTipoProveedor"],
										'idSucursal'=>$datos['idSucursal'],
										'idCoP'=>$idCoP,
										'cta'=>$cta,
										'sub1'=>$subCta,
										'sub2'=>$armaSub2,
										'sub3'=>$armaSub3,
										'sub4'=>$armaSub4,
										'sub5'=>$armaSub5,
										'tipoES'=>"S",
										'fecha'=>$fecha,/**/
										'descripcion'=>$rowGuiaContable["descripcion"],
										'cargo'=>$cargo,
										'abono'=>$abono,
										'numdocto'=>$numeroFolio,
										'secuencial'=>$secuencial
										);
										print_r($mPoliza);
										$dbAdapter->insert("Poliza", $mPoliza);
										}
								
							}//Cierra foreach de guiaContable
						}//Cierr if GuiaContable		
					}
				}
			}else{
				echo "Fondeo no encontrado";
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
		
	public function generacxpRemisiones($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		
		try{
			//Seleccionamos grupoRemisión por fecha, tipoMovto = 12 RemisionEntrada, idSucursal y estatus
			$tablaCXP = $this->tablaCuentasxp;
			$select = $tablaCXP->select()->from($tablaCXP)->where('fechaPago >= ?',$stringFechaInicio)->where('fechaPago <=?',$stringFechaFinal)->where('idTipoMovimiento=?',12)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsGrupoRCXP= $tablaCXP->fetchAll($select);
			//print_r("$select");
			if(!is_null($rowsGrupoRCXP)){
				foreach($rowsGrupoRCXP as $rowGrupoRCXP){
					//Obtenemos el idProveedor y el tipo
					$idCoP = $rowGrupoRCXP["idCoP"];
					$tablaProveedores = $this->tablaProveedores;
					$select = $tablaProveedores->select()->from($tablaProveedores, array('idProveedores','idTipoProveedor'))->where("idProveedores = ?", $idCoP);
					$rowProveedor = $tablaProveedores->fetchRow($select);
					//Verificamos que el proveedor exista
					if(!is_null($rowProveedor)){
						$tipo = $rowProveedor->idTipoProveedor;
						//print_r($tipo);
						if($tipo == 5){
							$modulo = 2; //cxp
						}elseif($tipo == 1){//Asimilidos
							$modulo = 4; //Gastos
						}else{
							$modulo = 4; //Gastos
						}
						$banco = $rowGrupoRCXP->idBanco;
						if($banco != 46 && $idCoP != 103 ){
							$idSucursal = $rowGrupoRCXP->idSucursal;
							$numMov = $rowGrupoRCXP->numeroFolio;
							$fecha = $rowGrupoRCXP->fechaPago;
							$iva = 0;
							$subTotal = $rowGrupoRCXP->subtotal;
							$total = $rowGrupoRCXP->total;
							$consec = $rowGrupoRCXP->secuencial;
							//Genera_Poliza_P_R. Seleccionamos en la guia contable el modulo y el tipo
							$tablaGuiaContable = $this->tablaGuiaContable;
							$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?", $tipo);
							$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
							//print_r("$select"); //Comprobamos que esta el modulo y el tipo en guia contable
							if(!is_null($rowsGuiaContable)){
								foreach($rowsGuiaContable as $rowGuiaContable){
									$origen =$rowGuiaContable["origen"]; //Indica el importe corresponidente a cada registro
									switch($origen){
										case 'S':
											$importe = $total;
											$origen = "SIN"; //No se porque va
										break;
										case 'I':
											$importe = $iva;
											$origen = "SIN";
										break;
										case 'T':
											$importe = $total;
											if($tipo == 5 && $rowGuiaContable->cargo == "X"){
												$origen = "PRO";
											}else{
												if(($tipo == 1 || $tipo == 2) && $rowGuiaContable->cargo == "X"){
													$origen = "SIN";
												}else{
													$origen = "BAN";
												}
											}
										break;
									}//Cierra el switch origen
									//Asigna tipoES
									if($rowGuiaContable["origen"] =='I'){
										$tipoES = "I";
									}else{
										$tipoES = "D";
									}//Cierra tipoES
									//asigna abono o cargo
									if($rowGuiaContable["cargo"]== "X"){
										$cargo = $importe;
									}else{
										$cargo = "0";
									}
									if($rowGuiaContable["abono"]== "X"){
										$abono = $importe;
									}else{
										$abono = 0;
									}						
									//Arma descripcion
									if($rowGuiaContable["origen"] =='I' || $rowGuiaContable["origen"] =='S'){
										$desPol = $rowGuiaContable->descripcion;
									}else{	
										//Crear descripcion
										if($tipo == 2 || $tipo == 1 && $rowGuiaContable["cargo"] =='X'){
											$desPol = $rowGuiaContable->descripcion;
										}else{
											$desPol = $rowGuiaContable->descripcion;
										}
									}//Cierra  if arma descripcion
									//Busca ctaProveedor y valor de subcuenta que nos va permitir saber el nivel. El proveedor  el nivel es 1	
									switch($origen){
										case 'BAN':
											$tablaBancos = $this->tablaBancos;
											$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$banco);
											$rowBanco = $tablaBancos->fetchRow($select);
											//print_r("$select");
											if($rowBanco->tipo =="CA"){
												//print_r("es de tipoCaja");
												$cta = 101;
												$subCta = $rowBanco["cuentaContable"];
												$posicion = 1;
											}else{
												$cta = $rowGuiaContable["cta"];
												$subCta = $rowBanco["cuentaContable"];
												$posicion = 1;
											}
										break;
										case 'PRO':
											$tablaProveedores = $this->tablaProveedores;
											$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?",$idCoP);
											$rowProveedor = $tablaProveedores->fetchRow($select);
											$cta = $rowGuiaContable["cta"];
											$subCta = $rowProveedor["cuenta"];
											$posicion = 1;
										break;
										case 'SIN':
											$cta = $rowGuiaContable["cta"];
											$subCta = $rowGuiaContable["sub1"];
											$posicion = 1;
										break;
										default:
											$cta = $rowGuiaContable["cta"];
											$subCta = "0000";
											$posicion = 1;
									}
									$mascara= Zend_Registry::get("mascara");
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
										}else{
											$armaSub1 = $rowGuiaContable["sub1"];
										}							
									}
									if($nivel2 == 2){
										if($posicion == 2){
											$armaSub2 = $subCta;
										}else{
											$armaSub2 = $rowGuiaContable["sub2"];
										}						
									}
									if($nivel3 == 3){
										if($posicion == 3){
											$armaSub3 = $subCta;
										}else{
											$armaSub3 = $rowGuiaContable["sub3"];
										}						
									}
									if($nivel4 == 4){
										if($posicion == 4){
											$armaSub4 = $subCta;
										}else{
											$armaSub4 = $rowGuiaContable["sub4"];
											}						
										}
									if($nivel5 == 5){
										if($posicion == 5){
											$armaSub5 = $subCta;
										}else{
											$armaSub5 = $rowGuiaContable["sub5"];
										}						
									}
									//Asignamos secuencial
									if($importe != 0){
										$secuencial = 0;	
										$tablaPoliza = $this->tablaPoliza;
										$select = $tablaPoliza->select()->from($tablaPoliza)->where("idModulo=?",$modulo)
										->where("idTipoProveedor=?",$tipo)->where("idSucursal=?",$datos['idSucursal'])->where("idCoP=?",$idCoP)
										->where("numDocto=?", $numMov)->order("secuencial DESC");
										$rowPoliza = $tablaPoliza->fetchRow($select); 
										if(!is_null($rowPoliza)){
											$secuencial= $rowPoliza->secuencial +1;
										}else{
											$secuencial = 1;	
										}
										//Agregamos en tablaPoliza.
										$mPoliza = array(
											'idModulo'=>$modulo,
											'idTipoProveedor'=>$rowGuiaContable["idTipoProveedor"],
											'idSucursal'=>$datos['idSucursal'],
											'idCoP'=>$idCoP,
											'cta'=>$cta,
											'sub1'=>$subCta,
											'sub2'=>$armaSub2,
											'sub3'=>$armaSub3,
											'sub4'=>$armaSub4,
											'sub5'=>$armaSub5,
											'tipoES'=>$tipoES,
											'fecha'=>$fecha,
											'descripcion'=>$desPol,
											'tipoES'=>"E",
											'cargo'=>$cargo,
											'abono'=>$abono,
											'numdocto'=>$numMov,
											'secuencial'=>$secuencial
										);
									$dbAdapter->insert("Poliza", $mPoliza);
									}//if de importe
								}//cierra forach Guia Contable
							}
						}//Cierra if proveedor
					}//if Banco sucursal Caja Cafe	y proveedor central de Abastos
				}
			}else{
				echo "Remisión no registrada";
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
		public function generacxcRemisiones($datos){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$dbAdapter->beginTransaction();
			$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
			$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
			$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
			$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
			try{
				//Seleccionamos grupoRemisión por fecha, tipoMovto = 13 RemisionEntrada, idSucursal y estatus
				$tablaCXC = $this->tablaCuentasxc;
				$select = $tablaCXC->select()->from($tablaCXC)->where('fechaPago >= ?',$stringFechaInicio)->where('fechaPago <=?',$stringFechaFinal)->where('idTipoMovimiento=?',13)
				->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
				$rowsGrupoRCXC = $tablaCXC->fetchAll($select);
				//Verificamos que existe Remision
				if(!is_null($rowsGrupoRCXC)){
					foreach($rowsGrupoRCXC as $rowGrupoRCXC){
						//Obtenemos el idProveedor y el tipo
						$idCoP = $rowGrupoRCXC["idCoP"];
						$tablaClientes = $this->tablaClientes;
						$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente = ?", $idCoP);
						$rowCliente = $tablaClientes->fetchRow($select);
						//Verificamos que el cliente exista
						if(!is_null($rowCliente)){
							$tipo = 5;
							$modulo = 3; //Venta o 3cxc
							$banco = $rowGrupoRCXC->idBanco;
							$idSucursal = $rowGrupoRCXC->idSucursal;
							$numMov = $rowGrupoRCXC->numeroFolio;
							$fecha = $rowGrupoRCXC->fecha;
							$iva = 0;
							$subTotal = $rowGrupoRCXC->subtotal;
							$total = $rowGrupoRCXC->total;
							$consec = $rowGrupoRCXC->secuencial;
							//Genera_Poliza_P_R. Seleccionamos en la guia contable el modulo y el tipo
							$tablaGuiaContable = $this->tablaGuiaContable;
							$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?", $tipo);
							$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
							//print_r("$select");
							//Comprobamos que esta el modulo y el tipo en guia contable
							if(!is_null($rowsGuiaContable)){
								foreach($rowsGuiaContable as $rowGuiaContable){
										$origen = $rowGuiaContable["origen"]; //Indica el importe corresponidente a cada registro
										switch($origen){
											case 'S':
												$importe = $total;
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
												if($tipo == 5 && $rowGuiaContable->cargo == "X"){
													$origen = "PRO";
												}else{
													if($tipo ==2 || $tipo == 1 && $rowGuiaContable->cargo == "X"){
														$origen = "SIN";
													}else{
														printf("El origen es Ban");
														$origen= "BAN";
													}
												}
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
										if($rowGuiaContable["cargo"] == "X"){
											$cargo = $importe;
											print_r("El cargo, no esta vacio");
											print_r($cargo);
										}else{
											$cargo = "0";
										}
										
										if($rowGuiaContable["abono"]== "X"){
											$abono = $importe;
											print_r("El abono, no esta vacio");
											print_r($abono);
										}else{
											$abono = 0;
										}						
										//Arma descripcion
										if($rowGuiaContable["origen"] =='I' || $rowGuiaContable["origen"] =='S'){
											$desPol = $rowGuiaContable->descripcion;
											print_r("<br />");
											print_r("<br />");print_r("<br />");
											print_r($desPol);
										}else{	
											//Crear descripcion
											if($tipo == 2 || $tipo == 1 && $rowGuiaContable["cargo"] =='X'){
												$desPol = $rowGuiaContable->descripcion;
											}else{
												//seleccionas tipo banco
												$tablaBanco = $this->tablaBancos;
												$select = $tablaBanco->select()->from($tablaBanco)->where("idBanco=?",$banco);
												$rowBanco = $tablaBanco->fetchRow($select);
												print_r("$select");
												if(!is_null($rowBanco)){
													if($rowBanco->tipo == "CA"){
														$desPol = "CAJA";
													
													}else{
														$desPol = $rowGuiaContable->descripcion;
													}
												}
											}
										}//Cierra  if arma descripcion
										//print_r($origen);
										//Busca ctaProveedor y valor de subcuenta que nos va permitir saber el nivel. El proveedor  el nivel es 1	
										switch($origen){
										case 'BAN':
											$tablaBancos = $this->tablaBancos;
											$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$banco);
											$rowBanco = $tablaBancos->fetchRow($select);
											$subCta = $rowBanco["cuentaContable"];
											$posicion = 1;
											break;
										case 'CLT':
											$tablaClientes = $this->tablaClientes;
											$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?",$idCoP);
											$rowCliente = $tablaClientes->fetchRow($select);
											$subCta = $rowCliente["cuenta"];
											print_r("la cuenta es:");
											print_r($subCta);
											print_r("la cuenta es:");
											$posicion = 1;
											break;
										default:
											$subCta = "0000";
											$posicion = 0;
										}
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
												print_r("armaSub1");
												print_r("<br />");
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
										if($importe != 0){
											print_r("El importe es vacio");
										
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
										'tipoES'=>"E",
										'cargo'=>$cargo,
										'abono'=>$abono,
										'numdocto'=>$numMov,
										'secuencial'=>$secuencial
										);
										print_r($mPoliza);
										$dbAdapter->insert("Poliza", $mPoliza);
										}//if de importe
									}//cierra forach Guia Contable
							}
							
						}//Cierra if proveedor	
					}
				}else{
					echo "Remisión no registrada";
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
	public function genera_Anticipo_Clientes($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		try{
			//Seleccionamos grupoCuentasxc por fecha,tipoMovto = 19 Anticipo Cliente
			$tablaCtsxc = $this->tablaCuentasxc;
			$select = $tablaCtsxc->select()->from($tablaCtsxc)->where('fecha >= ?',$stringFechaInicio)->where('fecha <=?',$stringFechaFinal)->where('idTipoMovimiento=?',19)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsCuentaxc = $tablaCtsxc->fetchAll($select);
			//print_r($select->__toString());
			if(!is_null($rowsCuentaxc)){
				foreach($rowsCuentaxc as $rowcxc){
					$idCoP = $rowcxc["idCoP"];
					$tablaClientes = $this->tablaClientes;
					$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente = ?", $idCoP);
					$rowCliente = $tablaClientes->fetchRow($select);
					if(!is_null($rowCliente)){
						$tipo = 5;
						$modulo = 10;
						$banco = $rowcxc["idBanco"];
						$idSucursal = $rowcxc["idSucursal"];
						$numeroFolio = $rowcxc["numeroFolio"];
						$fecha = $rowcxc["fechaPago"];
						$subtotal = $rowcxc["subtotal"];
						$total = $rowcxc["total"];
						$secuencial = $rowcxc["secuencial"];
						$tablaGuiaContable = $this->tablaGuiaContable;
						$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
						$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
						foreach($rowsGuiaContable as $rowGuiaContable){
							$origen = $rowGuiaContable->origen;
							switch($origen){
								case 'S':
									$importe = $subTotal;
									$origen = "SIN"; //No se porque va
									
								break;
								case 'I':
									$importe = $iva;
									$origen = "SIN";
									$descripcionPol = $rowGuiaContable->descripcion;
									
								break;
								case 'T':
									$importe = $total;
									if($tipo == 5 && $rowGuiaContable->abono == "X" && $modulo = 10 ){
										$origen	= "CLT";
									}else{
										if($tipo == 5  &&  $rowGuiaContable->cargo == "X" ){
											$origen = "BAN";
										}
									}	
								break;
								}
								
								if($rowGuiaContable["cargo"]== "X"){
									$cargo = $importe;
								}else{
									$cargo = 0;
								}
								if($rowGuiaContable["abono"]== "X"){
									$abono = $importe;
								}else{
									$abono = 0;
								}
								if($rowGuiaContable->origen ='I' || $rowGuiaContable->origen == "S"){
									$desPol = $rowGuiaContable->descripcion;
								}else{
									if($tipo == 1 || $tipo == 2 && $rowGuiaContable->cargo == "X"){
										$desPol = $rowGuiaContable->descripcion;
									}else{
										$delPol = $armaConsulta = $this->armaDescripcion($banco, $rowGuiaContable->descripcion);
									}
								}
								//Busca ctaCliente y valor de subcuenta que nos va permitir saber el nivel. El proveedor  el nivel es 1
								switch($origen){
									case 'BAN':
										$tablaBancos = $this->tablaBancos;
										$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$banco);
										$rowBanco = $tablaBancos->fetchRow($select);
										if($rowBanco->tipo ==="CA"){
											$cta = 101;
											$subCta = $rowBanco["cuentaContable"];
											$posicion = 1;
										}else{
											$cta = $rowGuiaContable["cta"];
											$subCta = $rowBanco["cuentaContable"];
											$posicion = 1;
										}
									break;
									case 'CLT':
										$tablaClientes = $this->tablaClientes;
										$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?",$idCoP);
										$rowCliente = $tablaClientes->fetchRow($select);
										$cta = $rowGuiaContable["cta"];
										$subCta = $rowCliente["cuenta"];
										$posicion = 1;
									break;
									default:
										$cta = $rowGuiaContable["cta"];
										$subCta = "0000";
										$posicion = 0;
								}
								$mascara= Zend_Registry::get("mascara");
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
									}else{
										$armaSub1 = $rowGuiaContable["sub1"];
										
									}						
								}
								if($nivel2 == 2){
									if($posicion == 2){
										$armaSub2 = $subCta;
									}else{
										$armaSub2 = $rowGuiaContable["sub2"];
									}						
								}
								if($nivel3 == 3){
									if($posicion == 3){
										$armaSub3 = $subCta;
									}else{
										$armaSub3 = $rowGuiaContable["sub3"];
									}						
								}
								if($nivel4 == 4){
									if($posicion == 4){
										$armaSub4 = $subCta;
									}else{
										$armaSub4 = $rowGuiaContable["sub4"];
									}						
								}
								if($nivel5 == 5){
									if($posicion == 5){
										$armaSub5 = $subCta;
									}else{
										$armaSub5 = $rowGuiaContable["sub5"];
									}						
								}
								$mPoliza = array(
									'idModulo'=>$modulo,
									'idTipoProveedor'=>$rowGuiaContable["idTipoProveedor"],
									'idSucursal'=>$datos['idSucursal'],
									'idCoP'=>$idCoP,
									'cta'=>$cta,
									'sub1'=>$armaSub1,
									'sub2'=>$armaSub2,
									'sub3'=>$armaSub3,
									'sub4'=>$armaSub4,
									'sub5'=>$armaSub5,
									'tipoES'=>"I",
									'fecha'=>$fecha,
									'descripcion'=>$desPol,
									'cargo'=>$cargo,
									'abono'=>$abono,
									'numdocto'=>$numeroFolio,
									'secuencial'=>1);
								$dbAdapter->insert("Poliza", $mPoliza);
							}//cierra forach
						}//if cliente
					}//foreach grupo cuentasxc
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
	
	public function genera_Anticipo_Proveedores($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		try{
			//Seleccionamos grupoCuentasxp por fecha, tipoMovto = 18 Anticipo Proveedor, idSucursal y estatus
			$tablaCtsxp = $this->tablaCuentasxp;
			$select = $tablaCtsxp->select()->from($tablaCtsxp)->where('fecha >= ?',$stringFechaInicio)->where('fecha <=?',$stringFechaFinal)->where('idTipoMovimiento=?',18)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsCxp= $tablaCtsxp->fetchAll($select);
			//print_r("Anticipo proveedor"); print_r($select->__toString());
			if(!is_null($rowsCxp)){
				foreach($rowsCxp as $rowCxp){
					$idCoP = $rowCxp["idCoP"];
					$tablaProveedores = $this->tablaProveedores;
					$select = $tablaProveedores->select()->from($tablaProveedores, array('idProveedores','idTipoProveedor'))->where("idProveedores = ?", $idCoP);
					$rowProveedor = $tablaProveedores->fetchRow($select);
					//print_r("$select"); //Verificamos que el proveedor exista
					if(!is_null($rowProveedor)){
						//Nomina
						$tipo = $rowProveedor->idTipoProveedor;
						if($tipo == 5){//Asignamos el modulo dependiento de tipo Proveedor
							$modulo = 11;
						}else{
							$modulo = 11;
							$tipo = 5;
						}
						//Asignamos variables
						$banco = $rowCxp["idBanco"];
						$idSucursal = $rowCxp["idSucursal"];
						$numeroFolio = $rowCxp["numeroFolio"];
						$fecha = $rowCxp["fechaPago"];
						$subtotal = $rowCxp["subtotal"];
						$total = $rowCxp["total"];
						$secuencial = $rowCxp["secuencial"];
						$tablaGuiaContable = $this->tablaGuiaContable;
						$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
						$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
						//print_r("<br />"); print_r("$select");
						foreach($rowsGuiaContable as $rowGuiaContable){
							$origen = $rowGuiaContable->origen;
							switch($origen){
								case 'S':
									$importe = $subTotal;
									$origen = "SIN"; //No se porque va
								break;
								case 'I':
									$importe = $iva;
									$origen = "SIN";
									$descripcionPol = $rowGuiaContable->descripcion;
								break;
								case 'T':
									$importe = $total;
									if($tipo == 5 && $rowGuiaContable->cargo == "X"){
										$origen	= "PRO";
									}else{
										if($tipo == 1 || $tipo == 2 && $rowGuiaContable->cargo == "X"){
											$origen = "SIN";
										}else{
											$origen = "BAN";
										}
									}
										
								break;
							}
							if($rowGuiaContable["cargo"]== "X"){
								$cargo = $importe;
							}else{
								$cargo = 0;
							}
							if($rowGuiaContable["abono"]== "X"){
								$abono = $importe;
							}else{
								$abono = 0;
							}
							//Arma descripcion
							if($rowGuiaContable->origen ='I' || $rowGuiaContable->origen == "S"){
								$desPol = $rowGuiaContable->descripcion;
							}else{
								if($tipo == 1 || $tipo == 2 && $rowGuiaContable->cargo == "X"){
									$desPol = $rowGuiaContable->descripcion;
								}else{
									$delPol = $armaConsulta = $this->armaDescripcion($banco, $rowGuiaContable->descripcion);
								}
							}//Cierra  if arma descripcion
							//Busca ctaProveedor y valor de subcuenta que nos va permitir saber el nivel. El proveedor  el nivel es 1
							switch($origen){
								case 'BAN':
									$tablaBancos = $this->tablaBancos;
									$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$banco);
									$rowBanco = $tablaBancos->fetchRow($select);
									if($rowBanco->tipo ==="CA"){
										$cta = 101;
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}else{
										$cta = $rowGuiaContable["cta"];
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}
								break;
								case 'PRO':
									$tablaProveedores = $this->tablaProveedores;
									$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?",$idCoP);
									$rowProveedor = $tablaProveedores->fetchRow($select);
									$cta = $rowGuiaContable["cta"];
									$subCta = $rowProveedor["cuenta"];
									$posicion = 1;
								break;
								default:
									$cta = $rowGuiaContable["cta"];
									$subCta = "0000";
									$posicion = 0;
								}
								$mascara= Zend_Registry::get("mascara");
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
									}else{
										$armaSub1 = $rowGuiaContable["sub1"];
									}						
								}
								if($nivel2 == 2){
									if($posicion == 2){
										$armaSub2 = $subCta;
									}else{
										$armaSub2 = $rowGuiaContable["sub2"];
									}						
								}
								if($nivel3 == 3){
									if($posicion == 3){
										$armaSub3 = $subCta;
									}else{
										$armaSub3 = $rowGuiaContable["sub3"];
									}						
								}
								if($nivel4 == 4){
									if($posicion == 4){
										$armaSub4 = $subCta;
									}else{
										$armaSub4 = $rowGuiaContable["sub4"];
									}						
								}
								if($nivel5 == 5){
									if($posicion == 5){
										$armaSub5 = $subCta;
									}else{
										$armaSub5 = $rowGuiaContable["sub5"];
									}						
								}
								$secuencial = 0;	
								$tablaPoliza = $this->tablaPoliza;
								$select = $tablaPoliza->select()->from($tablaPoliza)->where("idModulo=?",$modulo)->where("idTipoProveedor=?",$tipo)
								->where("idSucursal=?",$datos['idSucursal'])->where("idCoP=?",$idCoP)->where("numDocto=?", $numeroFolio)->order("secuencial DESC");
								$rowPoliza = $tablaPoliza->fetchRow($select); 
								if(!is_null($rowPoliza)){
									$secuencial= $rowPoliza->secuencial +1;
								}else{
									$secuencial = 1;	
								}
								$mPoliza = array(
									'idModulo'=>$modulo,
									'idTipoProveedor'=>$rowGuiaContable["idTipoProveedor"],
									'idSucursal'=>$datos['idSucursal'],
									'idCoP'=>$idCoP,
									'cta'=>$cta,
									'sub1'=>$armaSub1,
									'sub2'=>$armaSub2,
									'sub3'=>$armaSub3,
									'sub4'=>$armaSub4,
									'sub5'=>$armaSub5,
									'tipoES'=>"E",
									'fecha'=>$fecha,
									'descripcion'=>$desPol,
									'cargo'=>$cargo,
									'abono'=>$abono,
									'numdocto'=>$numeroFolio,
									'secuencial'=>$secuencial);
								$dbAdapter->insert("Poliza", $mPoliza);
							}//cierra forach
						}
					}//Cierra foreach que recorre grupo cuentasxp
				}//Cierra if busca grupoCuentasxp	
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
	
	public function genera_Cuentasxp_PagoImpuesto($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		try{
			//Seleccionamos grupoCuentasxp por fecha, tipoMovto = 10 Pago Impuesto, idSucursal y estatus
			$tablaCtsxp = $this->tablaCuentasxp;
			$select = $tablaCtsxp->select()->from($tablaCtsxp)->where('fechaPago >= ?',$stringFechaInicio)->where('fechaPago <=?',$stringFechaFinal)->where('idTipoMovimiento=?',10)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsCxp= $tablaCtsxp->fetchAll($select);
			//print_r("Pago Impuesto"); print_r($select->__toString());
			if(!is_null($rowsCxp)){
				foreach($rowsCxp as $rowCxp){
					$idCoP = $rowCxp["idCoP"];
					$tablaProveedores = $this->tablaProveedores;
					$select = $tablaProveedores->select()->from($tablaProveedores, array('idProveedores','idTipoProveedor'))->where("idProveedores = ?", $idCoP);
					$rowProveedor = $tablaProveedores->fetchRow($select);
					//print_r("$select"); //Verificamos que el proveedor exista
					if(!is_null($rowProveedor)){	
						//Nomina
						$modulo = 8; //Impuestos
						$tipo = 4;
						//Buscamos importeImpuesto
						$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
						$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idCuentasxp=?", $rowCxp->idCuentasxp)->where("idTipoMovimiento =?",10);
						$rowFacturaImp = $tablaFacturaImpuesto->fetchRow($select);
						//print_r("<br />"); print_r("$select");
						$tipoImpuesto = $rowFacturaImp["idImpuesto"];
						//print_r("<br />"); print_r($tipoImpuesto);
						$tablaImpuesto = $this->tablaImpuesto;
						$select = $tablaImpuesto->select()->from($tablaImpuesto)->where("idImpuesto=?", $rowFacturaImp->idImpuesto);
						$rowImp =$tablaImpuesto->fetchRow($select);
						//print_r("$select"); 
						$desImpuesto = $rowImp["abreviatura"];
						//print_r("<br />"); print_r($tipoImpuesto);
						$banco = $rowCxp["idBanco"];
						$idSucursal = $rowCxp["idSucursal"];
						$numeroFolio = $rowCxp["numeroFolio"];
						$fecha = $rowCxp["fechaPago"];
						$subtotal = $rowCxp["subtotal"];
						$total = $rowCxp["total"];
						$secuencial = $rowCxp["secuencial"];
						$tablaGuiaContable = $this->tablaGuiaContable;
						$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
						$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
						//print_r("<br />");print_r("$select");
						foreach($rowsGuiaContable as $rowGuiaContable){
							$origen = $rowGuiaContable->origen;
							switch($origen){
								case 'S':
									$importe = $subTotal;
									$origen = "SIN"; 
								break;
								case 'I':
									$importe = $iva;
									$origen = "SIN";
								break;
								case 'T':
									$importe = $total;
									if($tipo == 5 && $rowGuiaContable->cargo == "X"){
										$origen	= "PRO";
									}else{
										if($tipo == 4 && $rowGuiaContable->abono == "X"){
											$origen = "BAN";
										}else{
											$origen = "SIN";
										}
									}
									
								break;
							}
							if($rowGuiaContable["cargo"]== "X"){
								$cargo = $importe;
							}else{
								$cargo = 0;
							}
							if($rowGuiaContable["abono"]== "X"){
								$abono = $importe;
							}else{
								$abono = 0;
							}
							//Arma descripcion
							if($rowGuiaContable->origen =='T' && $rowGuiaContable->abono == "X"){
									$desPol = $rowGuiaContable["descripcion"];
							}else{
								$desPol ="Pago " . " ". $desImpuesto;
							}//Cierra  if arma descripcion
							//Busca ctaProveedor y valor de subcuenta que nos va permitir saber el nivel. El proveedor  el nivel es 1
							switch($origen){
								case 'BAN':
									$tablaBancos = $this->tablaBancos;
									$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$banco);
									$rowBanco = $tablaBancos->fetchRow($select);
									if($rowBanco->tipo ==="CA"){
										print_r("es de tipoCaja");
										$cta = 101;
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}else{
										$cta = $rowGuiaContable["cta"];
										$subCta = $rowBanco["cuentaContable"];
										$posicion = 1;
									}
								break;
								case 'PRO':
								break;
								case 'SIN':
									switch($tipoImpuesto){
										case '5':
											$cta = $rowGuiaContable["cta"];
											$subCta = 5000;
											$posicion = 1;
										break;
										case '8':
											$cta = $rowGuiaContable["cta"];
											$subCta = 6000;
											$posicion = 1;
									
										break;
										case '9':
											$cta = $rowGuiaContable["cta"];
											$subCta = 5100;
											$posicion = 1;
										break;
										default:
											$cta = $rowGuiaContable["cta"];
											$subCta = "0000";
											$posicion = 1;
									}
							}	
							$mascara= Zend_Registry::get("mascara");
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
								}else{
									$armaSub1 = $rowGuiaContable["sub1"];
								}						
							}
							if($nivel2 == 2){
								if($posicion == 2){
									$armaSub2 = $subCta;
								}else{
									$armaSub2 = $rowGuiaContable["sub2"];
								}						
							}
							if($nivel3 == 3){
								if($posicion == 3){
									$armaSub3 = $subCta;
								}else{
									$armaSub3 = $rowGuiaContable["sub3"];
								}						
							}
							if($nivel4 == 4){
								if($posicion == 4){
									$armaSub4 = $subCta;
								}else{
									$armaSub4 = $rowGuiaContable["sub4"];
								}						
							}
							if($nivel5 == 5){
								if($posicion == 5){
									$armaSub5 = $subCta;
								}else{
									$armaSub5 = $rowGuiaContable["sub5"];
								}						
							}
							//Asignamos secuencial
							$secuencial = 0;	
							$tablaPoliza = $this->tablaPoliza;
							$select = $tablaPoliza->select()->from($tablaPoliza)->where("idModulo=?",$modulo)->where("idTipoProveedor=?",$tipo)
							->where("idSucursal=?",$datos['idSucursal'])->where("idCoP=?",$idCoP)->where("numDocto=?", $numeroFolio)
							->order("secuencial DESC");
							$rowPoliza = $tablaPoliza->fetchRow($select); 
							if(!is_null($rowPoliza)){
								$secuencial= $rowPoliza->secuencial +1;
							}else{
								$secuencial = 1;	
							}
							$mPoliza = array(
								'idModulo'=>$modulo,
								'idTipoProveedor'=>$rowGuiaContable["idTipoProveedor"],
								'idSucursal'=>$datos['idSucursal'],
								'idCoP'=>$idCoP,
								'cta'=>$cta,
								'sub1'=>$armaSub1,
								'sub2'=>$armaSub2,
								'sub3'=>$armaSub3,
								'sub4'=>$armaSub4,
								'sub5'=>$armaSub5,
								'tipoES'=>"E",
								'fecha'=>$fecha,
								'descripcion'=>$desPol,
								'cargo'=>$cargo,
								'abono'=>$abono,
								'numdocto'=>$numeroFolio,
								'secuencial'=>$secuencial);
							$dbAdapter->insert("Poliza", $mPoliza);
						}//cierra forach	
					}
				}//Cierra foreach que recorre grupo cuentasxp
			}//Cierra if busca grupoCuentasxp	
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

	public function genera_ProvisionNomina($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		
		try{
			//Seleccionamos grupoProvisionNomina por fecha, tipoMovto = 20 
			$tablaFacura = $this->tablaFactura;
			$select = $tablaFacura->select()->from($tablaFacura)->where('fecha >= ?',$stringFechaInicio)->where('fecha <=?',$stringFechaFinal)->where('idTipoMovimiento=?',20)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsFactura= $tablaFacura->fetchAll($select);
			//print_r("Provision Nomina");print_r($select->__toString());
			if(!is_null($rowsFactura)){
				foreach($rowsFactura as $rowFactura){
					$idCoP = $rowFactura["idCoP"];
					$tablaProveedores = $this->tablaProveedores;
					$select = $tablaProveedores->select()->from($tablaProveedores, array('idProveedores','idTipoProveedor'))->where("idProveedores = ?", $idCoP);
					$rowProveedor = $tablaProveedores->fetchRow($select);
					//print_r("$select");
					if(!is_null($rowProveedor)){
						$tablaCXP = $this->tablaCuentasxp;
						$select = $tablaCXP->select()->from($tablaCXP)->where("idFactura = ? ",$rowFactura->idFactura);
						$rowCXP = $tablaCXP->fetchRow($select);
						//print_r("<br />"); print_r("$select");
						$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
						$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idFactura=?", $rowFactura->idFactura)
						->where("idTipoMovimiento =?",20)->where("idImpuesto=?", 5);
						$rowFacturaImp = $tablaFacturaImpuesto->fetchRow($select);
						//print_r("$select");
						if($rowFacturaImp->idImpuesto == 5 ){
							$imss = $rowFacturaImp->importe;
						}
						$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
						$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idFactura=?", $rowFactura->idFactura)
						->where("idTipoMovimiento =?",20)->where("idImpuesto=?", 3);
						$rowFacturaImp = $tablaFacturaImpuesto->fetchRow($select);
						if($rowFacturaImp->idImpuesto == 3 ){
							$isr = $rowFacturaImp->importe;
						}
						$exento = $rowFactura->importePagado;
						$sueldo = $rowFactura->subtotal;
						$nomina = $rowCXP["total"];
						$modulo = 4;
						$tipo = 29;
						$banco = $rowCXP["idBanco"];
						$numMov = $rowFactura["numeroFactura"];
						$idSucursal = $rowFactura["idSucursal"];
						$numeroFolio = $rowFactura["numeroFactura"];
						$fecha = $rowFactura["fecha"];
						$tablaGuiaContable = $this->tablaGuiaContable;
						$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
						$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
						//print_r("<br />"); print_r("$select");
						//Comprobamos que esta el modulo y el tipo en guia contable
						if(!is_null($rowsGuiaContable)){
							foreach($rowsGuiaContable as $rowGuiaContable){
								$origen = $rowGuiaContable["origen"]; //Indica el importe corresponidente a cada registro
								switch($origen){
									case 'S':
										$importe = $exento;
										$origen = "SIN"; //No se porque va
									break;
									case 'I':
										if($rowGuiaContable["descripcion"]== "ISR NOMINA"){
											$importe = $isr;
										}else{
											$importe = $imss;
										}
									break;
									case 'T':
										if($rowGuiaContable["cargo"]== "X"){
											$importe = $sueldo;
										}else{
											$importe = $nomina;	
										}
										if($rowGuiaContable["cargo"]== "X" && $rowGuiaContable["descripcion"] == "NOMINA"){
											$importe = $nomina;
										}
										if($rowGuiaContable["abono"]== "X" && $rowGuiaContable["descripcion"] == "BANCOS"){
											$origen = "BAN";
										}
									break;
								}//Cierra el switch origen
								if($rowGuiaContable["origen"] ==='I'  || $rowGuiaContable["descripcion"]==="ISR NOMINA"){
									$tipoES = "D";
								}else{
									$tipoES = "D";
								}//Cierra tipoES
								if($rowGuiaContable["cargo"]== "X"){
									$cargo = $importe;
								}else{
									$cargo = "0";
								}
								if($rowGuiaContable["abono"]== "X"){
									$abono = $importe;
								}else{
									$abono = 0;
								}						
								switch($origen){
									case 'BAN':
										$tablaBancos = $this->tablaBancos;
										$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco=?",$banco);
										$rowBanco = $tablaBancos->fetchRow($select);
										if($rowBanco->tipo ==="CA"){
											$cta = 101;
											$subCta = $rowBanco["cuentaContable"];
											$posicion = 1;
										}else{
											$cta = $rowGuiaContable["cta"];
											$subCta = $rowBanco["cuentaContable"];
											$posicion = 1;
										}
									break;
									case 'PRO':
										$tablaProveedores = $this->tablaProveedores;
										$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?",$idCoP);
										$rowProveedor = $tablaProveedores->fetchRow($select);
										$cta = $rowGuiaContable["cta"];
										$subCta = $rowGuiaContable["sub1"];
										$posicion = 1;
									break;
									default:
										$cta = $rowGuiaContable["cta"];
										$subCta = $rowGuiaContable["sub1"];
										$posicion = 0;
								}
								$mascara= Zend_Registry::get("mascara");
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
									}else{
										$armaSub1 = $rowGuiaContable["sub1"];
									}						
								}
								if($nivel2 == 2){
									if($posicion == 2){
										$armaSub2 = $subCta;
									}else{
										$armaSub2 = $rowGuiaContable["sub2"];
									}						
								}
								if($nivel3 == 3){
									if($posicion == 3){
										$armaSub3 = $subCta;
									}else{
										$armaSub3 = $rowGuiaContable["sub3"];
									}						
								}
								if($nivel4 == 4){
									if($posicion == 4){
										$armaSub4 = $subCta;
									}else{
										$armaSub4 = $rowGuiaContable["sub4"];
									}						
								}
								if($nivel5 == 5){
									if($posicion == 5){
										$armaSub5 = $subCta;
									}else{
										$armaSub5 = $rowGuiaContable["sub5"];
									}						
								}
								$secuencial = 0;	
								$tablaPoliza = $this->tablaPoliza;
								$select = $tablaPoliza->select()->from($tablaPoliza)->where("idModulo=?",$modulo)->where("idTipoProveedor=?",$tipo)->where("idSucursal=?",$datos['idSucursal'])
								->where("idCoP=?",$idCoP)->where("numDocto=?", $numMov)->order("secuencial DESC");
								$rowPoliza = $tablaPoliza->fetchRow($select); 
								if(!is_null($rowPoliza)){
									$secuencial= $rowPoliza->secuencial +1;
								}else{
									$secuencial = 1;	
								}
								$mPoliza = array(
									'idModulo'=>$modulo,
									'idTipoProveedor'=>$rowGuiaContable["idTipoProveedor"],
									'idSucursal'=>$datos['idSucursal'],
									'idCoP'=>$idCoP,
									'cta'=>$cta,
									'sub1'=>$subCta,
									'sub2'=>$armaSub2,
									'sub3'=>$armaSub3,
									'sub4'=>$armaSub4,
									'sub5'=>$armaSub5,
									'tipoES'=>$tipoES,
									'fecha'=>$fecha,
									'descripcion'=>$rowGuiaContable["descripcion"],
									'tipoES'=>$tipoES,
									'cargo'=>$cargo,
									'abono'=>$abono,
									'numdocto'=>$numMov,
									'secuencial'=>$secuencial);
								$dbAdapter->insert("Poliza", $mPoliza);		
								}//foreach $rowGuiaContable
							}//	if $rowsGuiaContable
					}//is not null rowProveedor
				}//foreach rowsFactura
			}//if grupo provisionNomina
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
	
	public function genera_PagoNomina($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
			
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		
		try{
			//Seleccionamos grupoProvisionNomina por fecha, tipoMovto = 20 
			$tablaFacura = $this->tablaFactura;
			$select = $tablaFacura->select()->from($tablaFacura)->where('fecha >= ?',$stringFechaInicio)->where('fecha <=?',$stringFechaFinal)->where('idTipoMovimiento=?',20)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsFactura= $tablaFacura->fetchAll($select);
			print_r("Provision Nomina");
			print_r($select->__toString());
			if(!is_null($rowsFactura)){
				foreach($rowsFactura as $rowFactura){
					$idCoP = $rowFactura["idCoP"];
					$tablaProveedores = $this->tablaProveedores;
					$select = $tablaProveedores->select()->from($tablaProveedores, array('idProveedores','idTipoProveedor'))->where("idProveedores = ?", $idCoP);
					$rowProveedor = $tablaProveedores->fetchRow($select);
					print_r("$select");
					if(!is_null($rowProveedor)){
						$tablaCXP = $this->tablaCuentasxp;
						$select = $tablaCXP->select()->from($tablaCXP)->where("idFactura = ? ",$rowFactura->idFactura);
						$rowCXP = $tablaCXP->fetchRow($select);
						print_r("<br />");
						print_r("$select");
						$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
						$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idFactura=?", $rowFactura->idFactura)
						->where("idTipoMovimiento =?",20)->where("idImpuesto=?", 5);
						$rowFacturaImp = $tablaFacturaImpuesto->fetchRow($select);
						print_r("$select");
						if($rowFacturaImp->idImpuesto == 5 ){
							$imss = $rowFacturaImp->importe;
						}
						$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
						$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idFactura=?", $rowFactura->idFactura)
						->where("idTipoMovimiento =?",20)->where("idImpuesto=?", 3);
						$rowFacturaImp = $tablaFacturaImpuesto->fetchRow($select);
						if($rowFacturaImp->idImpuesto == 3 ){
							$isr = $rowFacturaImp->importe;
						}
							$exento = $rowFactura->importePagado;
							$sueldo = $rowFactura->subtotal;
							$nomina = $rowCXP["total"];
							//definimos variables
							$modulo = 8;
							$tipo = 29;
							$banco = $rowCXP["idBanco"];
							print_r("<br />");
							print_r($banco);
							print_r("<br />");
							print_r("<br />");	
							$numMov = $rowFactura["numeroFactura"];
							$idSucursal = $rowFactura["idSucursal"];
							$numeroFolio = $rowFactura["numeroFactura"];
							$fecha = $rowFactura["fecha"];
						
							$tablaGuiaContable = $this->tablaGuiaContable;
							$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
							$rowsGuiaContable = $tablaGuiaContable->fetchAll($select);
							print_r("<br />");
							print_r("$select");
							//Comprobamos que esta el modulo y el tipo en guia contable
							if(!is_null($rowsGuiaContable)){
								foreach($rowsGuiaContable as $rowGuiaContable){
									$origen = $rowGuiaContable["origen"]; //Indica el importe corresponidente a cada registro
										switch($origen){
											case 'S':
												$importe = $exento;
												$origen = "SIN"; //No se porque va
												print_r("<br />");
												print_r("importe subtotal:"); //print_r($importe);
												print_r($importe);
											break;
											case 'I':
												if($rowGuiaContable["descripcion"]== "ISR NOMINA"){
													$importe = $isr;
												}else{
													$importe = $imss;
												}
											break;
											case 'T':
												if($rowGuiaContable["cargo"]== "X"){
													$importe = $sueldo;
													
												}else{
													$importe = $nomina;	
												}
												$origen	= "PRO";
												print_r("<br />");
												print_r("<br />");
												print_r("importe total:"); //print_r($importe);
												print_r($origen);
												print_r("<br />");
												print_r($importe); //print_r($origen);
											break;
										}//Cierra el switch origen
										//Asigna tipoES
										if($rowGuiaContable["origen"] ==='I'  || $rowGuiaContable["descripcion"]==="ISR NOMINA"){
											$tipoES = "D";
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
											$cargo = "0";
										}
										
										if($rowGuiaContable["abono"]== "X"){
											$abono = $importe;
											print_r("El abono, no esta vacio");
											print_r($abono);
										}else{
											$abono = 0;
										}						
										/*//Arma descripcion
										if($rowGuiaContable["origen"] =='I' || $rowGuiaContable["origen"] == 'S'){
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
										}//Cierra  if arma descripcion*/
										//print_r($origen);
										//Busca ctaProveedor y valor de subcuenta que nos va permitir saber el nivel. El proveedor  el nivel es 1
										if($origen == "PRO"){
											/*$tablaProveedores = $this->tablaProveedores;
											$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?",$idCoP);
											$rowProveedor = $tablaProveedores->fetchRow($select);*/
											$subCta = $rowGuiaContable["sub1"];
											$posicion = 1;
										}else{
											$subCta = "0000";
											$posicion = 0;
										}//Cierra if origen proveedor
										//Creamos switch para Armar_Cuenta
										print_r("La posicio  es:");
										print_r($posicion);
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
												print_r("armaSub1");
												print_r("<br />");
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
										'descripcion'=>$rowGuiaContable["descripcion"],
										'tipoES'=>$tipoES,
										'cargo'=>$cargo,
										'abono'=>$abono,
										'numdocto'=>$numMov,
										'secuencial'=>$secuencial
										);
										print_r($mPoliza);
										$dbAdapter->insert("Poliza", $mPoliza);
										
								}//foreach $rowGuiaContable
							}//	if $rowsGuiaContable
					}//is not null rowProveedor
				}//foreach rowsFactura
			}//if grupo provisionNomina
		
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
							
							/*if($temNumDocto < 5){
								print_r("El numero de factura es menor que 5");
								/*foreach ($temNumDocto as $temNumDocto) {
									$numMovto = " ".$numMovto;
									$temNumDocto= $temNumDocto + 1;
								}
							}else{
								print_r("el numdocto es mayor o igual a 5");
							}*/
							while ($temNumDocto < 5) {
								$numMovto = " ".$numMovto;
								$temNumDocto = $temNumDocto + 1;
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
							
							while ($temImporte < 10) {
								$importe = " ".$importe;
								$temImporte = $temImporte + 1;
							}
									//$temImporte =strlen($importe);
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
									fwrite($archivo,"M1" .$coma .$d1 .$d2 .$coma .$coma .$coma .$espacio. $espacio .$coma .$coma .$coma .$coma .$numMovto.$espacio.$coma.$coma.$coma.$coma.$coma.$coma.$debeHaber.$coma.$importe.$espacio.$coma.$coma ."0".$espacio .$coma ."0.0" .$espacio .$espacio . str_pad($mensaje,97).$espacio.PHP_EOL);		
							}
						}//cierra foreach $rowsPoliza	
					}//Cierra if rowsPoliza 	
				}//Cierra foreach
			}//cierra if agrupa poliza
		}//cierra funcion crear_Texto
	}