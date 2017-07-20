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
	private $tablaImpuesto;
	private $tablaBanco;
	private $tablaEmpresa;
	private $tablaCuentasxc;
	private $tablaCuentasxp;
	
	public function __construct(){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
		$this->tablaEmpresa  = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
		$this->tablaImpuesto  = new Contabilidad_Model_DbTable_Impuesto(array('db'=>$dbAdapter));
		$this->tablaBanco = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
		$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
		$this->tablaCuentasxc = new Contabilidad_Model_DbTable_Cuentasxc(array('db'=>$dbAdapter));
		$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp(array('db'=>$dbAdapter));
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
			//$restaBanco = $this->restaBanco($fondeo);
			
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
	
	public function guardaNomina( array $empresa, $nomina){
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
		$dbAdapter->beginTransaction();
	
		$dateIni = new  Zend_Date($empresa['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		try{
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
					//'idFactura'=>0,
					'idProducto' => 199,
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
			//Guardar en factura.
			$mFactura = array(
				'idTipoMovimiento'=>$empresa['idTipoMovimiento'],
				'idSucursal'=>$empresa['idSucursal'],
				'idCoP'=>$empresa['idCoP'],
				'idDivisa'=>1,
				'numeroFactura'=>$empresa['numFolio'],
				'estatus'=>'A',
				'conceptoPago'=>'L',
				'descuento'=>0,
				'formaPago'=>'EF',
				'fechaFactura'=>$stringIni,
				'subtotal'=>$nomina['sueldo'],
				'total'=>$nomina['nominaxpagar'],
				'folioFiscal'=>0,
				'importePago'=>$nomina['nominaxpagar']
			);
			
			$dbAdapter->insert("Factura",$mFactura);
			
			/*$tablaImpuesto = $this->tablaImpuesto;
			$select = $tablaImpuesto->select()->from($tablaImpuesto)->where("idImpuesto = ?", $nomina['36']);
			$rowImpuesto = $tablaImpuesto->fetchRow($select);
			print_r("$select");*/
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura, array(new Zend_Db_Expr('max(idFactura) as idFactura')));
			$rowIdFactura = $tablaFactura->fetchRow($select);
			$idFactura = $rowIdFactura['idFactura'];
			print_r($idFactura);
			$mFacturaImpuesto = array(
				'idFactura'=>$idFactura,
				'idImpuesto'=>36,
				'importe'=>$nomina['36'],
			);
			$dbAdapter->insert("FacturaImpuesto",$mFacturaImpuesto);
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
	
	public function guardaNotaCredito(array $notaCredito, $impuestos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		$fechaInicio = new Zend_Date($notaCredito[0]['fecha'],'YY-mm-dd');
		$stringFecha = $fechaInicio->toString('YY-mm-dd');
		
		try{
			//Preguntar si se valida que la factura no exista	
			//Guarda Movimiento en tabla factura
			$mFactura = array(
				'idTipoMovimiento'=>$notaCredito[0]['idTipoMovimiento'],
				'idSucursal'=>$notaCredito[0]['idSucursal'],
				'idCoP'=>$notaCredito[0]['idCoP'],
				'idDivisa'=>$notaCredito[0]['idDivisa'],
				'numeroFactura'=>$notaCredito[0]['numFolio'],
				'estatus'=>"A",//deberia ser cancelado
				'conceptoPago'=>"LI",
				'descuento'=>$impuestos[0]['descuento'],
				'formaPago'=>"EF",
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
}