<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_Fondeo implements Contabilidad_Interfaces_IFondeo{
	private $tablaMovimiento;
	
	private $tablaEmpresas;
	private $tablaClientes;
	private $tablaFiscales;
	private $tablaBancosEmpresas;
	private $tablaMultiplos;
	
	public function __construct() {
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos;
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas;
		$this->tablaFiscales = new Sistema_Model_DbTable_Fiscales;
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes;
		$this->tablaBancosEmpresas = new Contabilidad_Model_DbTable_Bancosempresa;
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos;
	}
		
	public function obtenerBancosEmpresa($idBanco){
		$tablaBancosEmpresas = $this->tablaBancosEmpresas;
		$select = $tablaBancosEmpresas->select()->from($tablaBancosEmpresas)->where("idBanco=?",$idBanco);
		$rowsBancoEmpresa = $tablaBancosEmpresas->fetchAll($select);
		
		if(!is_null($rowsBancoEmpresa)){
			return $rowsBancoEmpresa->toArray();
		}else{
			return null;
		}
		print_r($rowsBancoEmpresa);
				
	}
	
	public function obtenerBancosEmpresas(){
		$tablaBancosEmpresas = $this->tablaBancosEmpresas;
		$rowBancosEmpresas = $tablaBancosEmpresas->fetchAll();
		
		$modelBancosEmpresas= array();
		foreach ($rowBancosEmpresas as $rowBancoEmpresa) {
			$modelBancoEmpresa = new Contabilidad_Model_Bancosempresa($rowBancoEmpresa->toArray());
			$modelBancoEmpresa->setIdBancosEmpresas($rowBancoEmpresa->idBancosEmpresas);
			
			$modelBancosEmpresas[] = $modelBancoEmpresa;
		}
		return $modelBancosEmpresas;
	}

	public function guardarFondeo(array $datos){
	
		//$datos=array();
		
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		$dateIni = new Zend_Date($datos['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
	try{
		
		$secuencial=0;	
		$tablaMovimiento = $this->tablaMovimiento;
		$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$datos['numFolio'])
		//->where("idCoP=?",$datos['idCoP'])
		->where("idEmpresas=?",$datos['idEmpresas'])
		->where("numeroFolio=?",$datos['numFolio'])
		->where("fecha=?", $stringIni)
		->order("secuencial DESC");
		print_r("$select");	
		$row = $tablaMovimiento->fetchRow($select); 
		
		if(!is_null($row)){
			$secuencial= $row->secuencial +1;
			
		}else{
			$secuencial = 1;	
		}

//=================Selecciona producto y unidad=======================================
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?","195")->where("idUnidad=?","17");
		$row = $tablaMultiplos->fetchRow($select); 	
			
		//====================Operaciones para convertir unidad minima====================================================== 
			$cantidad=0;
			$precioUnitario=0;
			$cantidad = $row->cantidad * $row->cantidad;
			//$precioUnitario = 1 / $row->cantidad;
			
			print_r($cantidad);
			print_r("<br />");
			//print_r($precioUnitario);
			
			
			$mMovtos = array(
				'idTipoMovimiento'=>$datos['idTipoMovimiento'],
				'idEmpresas'=>$datos['idEmpresas'],
				//Para Fondeo idSucursal es el Proveedor
				'idSucursal'=>$datos['idSucursal'],
				//Para Fondeo idCoP es el Cliente
				'idCoP'=>$datos['idBancos'],
				'numeroFolio'=>$datos['numFolio'],
				//'idFactura'=>0,
				'idProducto' => $datos['idProducto'],
				//'idProyecto'=>$datos['idProyecto'],
				'cantidad'=>$cantidad,
				'fecha'=>$stringIni,
				'secuencial'=> $secuencial,
				'estatus'=>"A",
				'costoUnitario'=>$precioUnitario,
				'totalImporte'=>$datos['total']
				);
			$bd->insert("Movimientos",$mMovtos);
		//========================Guarda en tabla cuentasxc==================================================
			/*$mCuentasxc = array(
			
					'idTipoMovimiento'=>$datos['idTipoMovimiento'],
					'numeroReferencia'=>0,
					'idSucursal'=>$datos['idSucursal'],
					'idCoP'=>$datos['idBancoE'],
					'idProyecto'=>$stringIni,
					'descripcion'=>"Fondeo",
					'estatus'=>"A",
					'conceptoPago' => $datos[''],
					'formaLiquidar'=>$datos['formaPago'],
					'fecha'=>$datos['fecha'],
					'fechaCaptura'=>$secuencial,
					'subtotal'=>$cantidad,
					'total'=>$datos['total'],
					'numFolio'=>$datos['numFolio'],
					'idDivisa'=>$datos['idDivisa'],
					'idBanco'=>$datos['idBancoE'],
					
			);
			
			$bd->insert("Cuentasxc",$mCuentasxc);
		
		
//=============================Guarda en cuentasxp=======================================		
			$mCuentasxp = array(
					'idCuentasxp'=>$datos['descripcion'],
					'idTipoMovimiento'=>$datos['idDivisa'],
					'idEmpresa'=>$datos['idEmpresas'],
					'idCoP'=>$datos['idProveedor'],
					'idProyecto'=>'0',
					'idBanco'=>$cantidad,
					'idDivisa'=>'0',
					'numFolio'=>'0',
					'descripcion'=>$stringIni,
					'numeroReferencia'=>$precioUnitario,
					'secuencial'=>'0',
					'estatus'=>'0',
					'fecha'=>$producto['importe'],
					'fechaCaptura'=>$stringIni,
					'formaLiquidar'=>$precioUnitario,
					'conceptoPago'=>'0',
					'subtotal'=>'0',
					'total'=>$producto['importe']
				);
			$bd->insert("Cuentascxp",$mCuentasxp);*///=========================Actualiza saldo en bancos=========================================================				
			$bd->commit();
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
			$bd->rollBack();
		}
	}
}
