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
					
		$nomina; //Guarda Cliente o proveedor
		$empresaProveedor; //empresa proveedora cuando el tipo no es bueno (Compras), pero es un proveedor
		//Iniciamos variables
		$subTotal = 0;
		$iva = 0;
		$total = 0;
		$idProveedor = 0;
		$idBanco =0;
		$numMov=0;
		$consecutivo = 0;
		$nivel=1;
		$descripcionPol;
		try{
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		$tablaFactura = $this->tablaFactura;
		$select = $tablaFactura->select()->from($tablaFactura)->where('fechaFactura >= ?',$stringFechaInicio)->where('fechaFactura <=?',$stringFechaFinal)->where('idTipoMovimiento=?',4)
		->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
		$rows = $tablaFactura->fetchAll($select);
		$idProveedores = array();
		print_r("$select");
		$modelFacturas = array();
		if(!is_null($rows)){
			foreach($rows as $row){
				$idProveedores[] = $row["idCoP"];
				foreach ($idProveedores as $idProveedor) {
					$nomina = $this->busca_Tipo($idProveedor, "P");
					$empresaProveedor = $this->busca_Proveedor($idProveedor, "P");
					print_r("<br />"); print_r("empresaProveedor:"); print_r($empresaProveedor);
					//Busca tipo 
					if($nomina = 5 && $empresaProveedor <> "0"){
						$modulo = 1; //Asignamos 1=>"Compra"
						$tipo = 5; //Ya no deberia de estar
						$idFactura = $row->idFactura;
						$numMov = $row->numeroFactura; print_r("<br />"); print_r("numFac:"); print_r($numMov);
						$subTotal = $row->subtotal; print_r("<br />"); print_r("subTotal:"); print_r($subTotal);
						$total = $row->total; print_r("<br />"); print_r("total:"); print_r($total);
						$fechaFactura = $row->fechaFactura; print_r("<br />"); print_r("fecha:"); print_r($fechaFactura);
						//Buscamos en FacturaImpuesto el iva
						$tablaFacturaImpuesto = $this->tablaFacturaImpuesto;
						$select = $tablaFacturaImpuesto->select()->from($tablaFacturaImpuesto)->where("idFactura=?", $idFactura);
						$rowFacturaImp =$tablaFacturaImpuesto->fetchRow($select);
						
						$iva = $rowFacturaImp->importe; print_r("<br />"); print_r("iva:"); print_r($iva);
						//deberia ser Funcion Genera poliza, seleccionamos en la guia contable el modulo y el tipo
						$tablaGuiaContable = $this->tablaGuiaContable;
						$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo)->where("idTipoProveedor=?",$tipo);
						$rowGuiaContable = $tablaGuiaContable->fetchAll($select);
						print_r("<br />");
						print_r("$select");
						if(!is_null($rowGuiaContable)){
							foreach($rowGuiaContable as $row){
							$origen =$row->origen;
							switch($origen){
							case 'S':
								$importe = $subTotal;
								$origen = "SIN"; //No se porque va
								//print_r("<br />");
								//print_r("importe subtotal:"); print_r($importe);
								break;
							case 'I':
								$importe = $iva;
								$origen = "SIN";
								$descripcionPol = $row->descripcion;
								//print_r("<br />");
								//print_r("importe iva:"); print_r($importe);
								//print_r("<br />");
								//print_r("ORIGEN:"); print_r($origen);
								break;
							case 'T':
								$importe = $total;
								$origen	= "PRO";
								print_r("<br />");
								//print_r("importe total:"); print_r($importe);
								//print_r("<br />");
								//print_r("ORIGEN:"); print_r($origen);
								
								//print_r("el origen es diferente");
								//print_r("<br />");
								//$subcta = "0000";
                				//$posicion = 0;
								//print_r($subcta);
								
							break;
							}
							print_r("El importe es:");
							print_r($importe);
							print_r("<br />");
							print_r($origen);
							//Arma descripcion
							if( $origen =='I' && $origen == 'S'){
								$descripcionPol = $row->descripcion;
								
							}else{
								//crea descripcion
							}
							//switch
							switch($origen){
							case 'CLT':
								$posicion = 1;
								$subcta = 0;
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
							
							print_r($origen);
							if($origen == "BAN"){
								 $ctaBanco;
							}else{
								$cta = $row->cta;
								print_r("<br />");
								print_r("la cuenta de banco o de la guia contable es:");
								print_r($cta);
							}
							//Arma Consulta
							switch($nivel){
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
			}
							//Termina ArmaConsulta
							//Agregamos a poliza;
							//$subCuenta1 =$this->arma_Cuenta(1, $posicion, $subcta, $row["sub1"], ($row->sub2), substr($row->sub3,3), substr($row->sub4,0), substr($row->sub5,0));
							$mPoliza = array(
								'idModulo'=>$modulo,
								'idTipoProveedor'=>$row->idTipoProveedor,
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
								  'fecha'=>$fechaFactura,
								'descripcion'=>$descripcionPol,
								'cargo'=>$importe,
								'abono'=>$importe,
								'numdocto'=>$numMov,
								'secuencial'=>1
						
					);
					print_r($mPoliza);
					$dbAdapter->insert("Poliza", $mPoliza);
							}//Cierre foreach
						}//cierra if rowGuiaContable
						}
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
	
	
	public function generaGruposFacturaCliente($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		
		
		
			$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
			$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
			$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
			$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
			
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where('fechaFactura >= ?',$stringFechaInicio)->where('fechaFactura <=?',$stringFechaFinal)->where('idTipoMovimiento=?',2)
			->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A");
			$rowsFacturac = $tablaFactura->fetchRow($select);
			if(!is_null($rowsFacturac)){
				$idSucursal = $rowsFacturac->idSucursal;
				$numMov = $rowsFacturac->numeroFactura;
				$subTotal = $rowsFacturac->subtotal;
				$iva = 32;
				$total = $rowsFacturac->total;
				$fecha = $rowsFacturac->fechaFactura;
				$idCliente = $rowsFacturac->idCoP;
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
		try{
					 	
			
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
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFinal = new Zend_Date($datos['fechaFinal'],'YY-MM-dd');
		$stringInicio = $fechaInicio->toString ('yyyy-MM-dd');
		$stringFinal = $fechaFinal->toString ('yyyy-MM-dd');
		
		//busqueda en cuentasxp
		$tablaCuentasxp = $this->tablaCuentasxp;
		$select = $tablaCuentasxp->select()->from($tablaCuentasxp)
		->where("fechaPago >=?",$stringInicio)
		->where("fechaPago <=?",$stringFinal)
		->where("idSucursal=?", $datos['idSucursal'])
		->where("idTipoMovimiento =?", 4)
		->where("estatus=?",'A');
		$rowCuentasxp = $tablaCuentasxp->fetchRow($select);
		//print_r("$select");
		
		if(!is_null($rowCuentasxp)){
			print_r("La consulta no esta vacía");
			do {
				//Inicializa variables
				$subTotal = 0;
				$iva = 0;
				$total = 0;
				$proveedor = 0;
				$banco = "";
				$numdocto = "";
				$consec= 0;
				//Obtenemos los datos
				$proveedor = $rowCuentasxp->idCoP;
				//print_r($proveedor);
			}while($rowCuentasxp <= 0);
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
	
	public function arma_Cuenta($nivel, $posicion, $subcta, $sub1, $sub2, $sub3, $sub4, $sub5){
		switch($nivel){
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
}