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
	public function generacxp_Fo(){}
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
		
		elseif($Empresa == "C"){
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
			}*/			
		}
	}
	
	public function busca_Proveedor($Persona, $Empresa){
		
		/*$rowsFiscales = $tablaFiscales->fetchAll($select);
		
		if(is_null($rowsFiscales)){
			return null;
		}else{
			return $rowsFiscales->toArray();
		}
		 * */
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
		
		if($Empresa = "C"){
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
			
		}
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
					$armaCuenta = $this->arma_Cuenta( $subcta);
				}else{
					$armaCuenta = $this->arma_Cuenta($sub1);
				}
				break;
			case 2:
				if ($posicion = 2){
					$armaCuenta = $this->arma_Cuenta( $subcta);
				}else{
					$armaCuenta = $this->arma_Cuenta($sub2);
				}
				break;
			case 3:
				if ($posicion = 3){
					$armaCuenta = $this->arma_Cuenta( $subcta);
				}else{
					$armaCuenta = $this->arma_Cuenta($sub3);
				}
				break;
			case 4:
				if ($posicion = 4){
					$armaCuenta = $this->arma_Cuenta( $subcta);
				}else{
					$armaCuenta = $this->arma_Cuenta($sub4);
				}
				break;
			case 5:
				if ($posicion = 5){
					$armaCuenta = $this->arma_Cuenta( $subcta);
				}else{
					$armaCuenta = $this->arma_Cuenta($sub5);
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
	

	public function generaGruposFacturaProveedor($datos){
			
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		
		$nomina;
		$empresaProveedor;
		$subTotal;
		$iva;
		$idProveedor;
		$banco;
		$numMov;
		$consecutivo;
		
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFin= new Zend_Date($datos['fechaFinal'], 'YY-MM-dd');
		$stringFechaInicio = $fechaInicio->toString('yyyy-MM-dd');
		$stringFechaFinal = $fechaFin->toString('yyyy-MM-dd');
		
		$tablaFactura = $this->tablaFactura;
		$select = $tablaFactura->select()->from($tablaFactura)->where('fechaFactura >= ?',$stringFechaInicio)->where('fechaFactura <=?',$stringFechaFinal)->where('idTipoMovimiento=?',4)
		->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A")->orWhere("estatus=?","I");
		$rows = $tablaFactura->fetchAll($select);
		$idProveedores = array();
		//$facturas = $rows->toArray();
		print_r("$select");
		$modelFacturas = array();
		if(!is_null($rows)){
			foreach($rows as $row){
				$idProveedores[] = $row["idCoP"];
				foreach ($idProveedores as $idProveedor) {
					$nomina = $this->busca_Tipo($idProveedor, "P");
					$empresaProveedor = $this->busca_Proveedor($idProveedor, "P"); 
					if($nomina = 5){
						$modulo = 1; 
						$tipo = 5;
						$numMov = $row->numeroFactura;
						$iva = 12.56;
						$generaPoliza = $this->genera_Poliza_F($modulo, $tipo, $iva);
					}
				}
			}
			
			
			//return $empresaProveedor;
			
		}
		
	}
	
	public function generaGruposFacturaCliente($datos){
		
		$fechaInicio = new Zend_Date($datos['fechaInicial'],'YY-MM-dd');
		$fechaFinal = new Zend_Date($datos['fechaFinal'],'YY-MM-dd');
		$stringInicio = $fechaInicio->toString ('yyyy-MM-dd');
		$stringFinal = $fechaFinal->toString ('yyyy-MM-dd');
		
		//Busca las facturas
		$tablaFactura = $this->tablaFactura;
		$select = $tablaFactura->select()->from($tablaFactura)->where('fechaFactura >= ?',$stringInicio)->where('fechaFactura <=?',$stringFinal)->where('idTipoMovimiento=?',2)
		->where('idSucursal = ?', $datos['idSucursal'])->where('estatus=?', "A")->orWhere("estatus=?","I");
		$rows= $tablaFactura->fetchAll($select);
		//print_r("$select");
		
		$idClientes = array();
		
		if(!is_null($rows)){
			print_r("La consulta no esta vacia");
			foreach($rows as $row){
				$idClientes[] = $row["idCoP"];
				//print_r("<br />");
				
				foreach ($idClientes as $idCliente) {
					//$nomina = $this->busca_Tipo($idCliente, "C");
					$tablaClientes = $this->tablaClientes;
					$select = $tablaClientes->select()->from($tablaClientes,'idTipoCliente')
					->where("idCliente = ?", $idClientes);
					$rowCliente = $tablaClientes->fetchRow($select);
					print_r("<br />");
					print_r("$select");
					$nomina = "BUENO";
					$modulo = 6;
					$tablaGuiaContable = $this->tablaGuiaContable;
					$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idModulo = ? ",$modulo);
					$rowGuiaContable = $tablaGuiaContable->fetchRow($select);
					print_r("$select");
				}
			}
		}
	}
	
}