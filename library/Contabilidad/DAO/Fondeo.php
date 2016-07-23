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
	
	public function __construct() {
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos;
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas;
		$this->tablaFiscales = new Sistema_Model_DbTable_Fiscales;
		
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes;
		$this->tablaBancosEmpresas = new Contabilidad_Model_DbTable_Bancosempresa;
	}
		
	public function obtenerBancosEmpresa($idBanco){
		
		$tablaBancosEmpresa = $this->tablaBancosEmpresas;
		$select = $tablaBancosEmpresa->select()->from($tablaBancosEmpresa)->where("idBanco=?",$idBanco)
		->order("idEmpresa DESC");
		
		$rowsBancoEmpresa = $tablaBancosEmpresa->fetchAll($select);
		
		$modelBancosEmpresa = array();	
		
		foreach ($rowsBancoEmpresa as $rowBancoEmpresa) {
			$modelBancoEmpresa = new Contabilidad_Model_Bancosempresa ($rowBancoEmpresa->toArray());
			
			$modelBancosEmpresa[]= $modelBancoEmpresa;
			}
		
		return $modelBancosEmpresa	;
		
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

	public function guardarFondeo(){
	
		$datos=array();
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
	try{
		$secuencial=0;	
		$tablaMovimiento = $this->tablaMovimiento;
		$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numFolio=?",$encabezado['numFolio'])
		->where("idCoP=?",$encabezado['idCoP'])
		->where("idEmpresa=?",$encabezado['idEmpresa'])
		->where("numFolio=?",$encabezado['numFolio'])
		->where("fecha=?", $stringIni)
		->order("secuencial DESC");
	
		$row = $tablaMovimiento->fetchRow($select); 
		
		if(!is_null($row)){
			$secuencial= $row->secuencial +1;
			//print_r($secuencial);
		}else{
			$secuencial = 1;	
			//print_r($secuencial);
		}

//=================Selecciona producto y unidad=======================================
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
		$row = $tablaMultiplos->fetchRow($select); 
		//print_r("<br />");
		//print_r("$select");
		/*if(is_null($row)){
			throw new Util_Exception_BussinessException("Error: Multiplo Incorrecto");
		}*/
				
		//====================Operaciones para convertir unidad minima====================================================== 
			$cantidad=0;
			$precioUnitario=0;
			$cantidad = $producto['cantidad'] * $row->cantidad;
			$precioUnitario = $producto['precioUnitario'] / $row->cantidad;
			
			
			$mMovtos = array(
					'idProducto' => $producto['descripcion'],
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idEmpresa'=>$encabezado['idEmpresa'],
					'idCoP'=>$encabezado['idCoP'],
					'idProyecto'=>$encabezado['idProyecto'],
					'numFolio'=>$encabezado['numFolio'],
					'cantidad'=>$cantidad,
					'fecha'=>$stringIni,
					'estatus'=>"A",
					'secuencial'=> $secuencial,
					'costoUnitario'=>$precioUnitario,
					'esOrigen'=>"E",
					'totalImporte'=>$producto['importe']
				);
			$bd->insert("Movimientos",$mMovtos);
		//========================Guarda en tabla cuentasxc==================================================
			$mCuentasxc = array(
			
					'idTipoMovimiento'=>$datos['idTipoMovimiento'],
					'numeroReferencia'=>0,
					'idEmpresa'=>$datos['idEmpresa'],
					'idCoP'=>$datos[''],
					'idProyecto'=>$stringIni,
					'descripcion'=>$precioUnitario,
					'estatus'=>$producto[''],
					'conceptoPago' => $producto[''],
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
					'idCuentasxp'=>$producto['descripcion'],
					'idTipoMovimiento'=>$encabezado['idDivisa'],
					'idEmpresa'=>$encabezado['idEmpresa'],
					'idCoP'=>$cantidad,
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
			$bd->insert("Cuentascxp",$mCuentasxp);
//=========================Actualiza saldo en bancos=========================================================				
			//$bd->commit();
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
