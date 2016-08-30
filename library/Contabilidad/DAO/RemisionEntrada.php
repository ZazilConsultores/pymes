<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_RemisionEntrada implements Contabilidad_Interfaces_IRemisionEntrada{	
	private $tablaMovimiento;
	private $tablaInventario;
	private $tablaCapas;
	private $tablaMultiplos;
	private $tablaEmpresa;
	private $tablaBancos;
	
	private $tablaCuentasxp;
	
	public function __construct() {
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos;
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas;
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario;
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos;
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
		$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp;
		$this->tablaBancos = new Contabilidad_Model_DbTable_Banco;
		
		
		$this->tablaProducto = new Inventario_Model_DbTable_Producto;
	}
	
	public function obtenerProveedores(){
		$tablaEmpresa = $this->tablaEmpresa;
		$select=$tablaEmpresa->select()
		->setIntegrityCheck(false)
		->from($tablaEmpresa, array('idEmpresa'))
		->join('fiscales', 'Empresa.idFiscales = fiscales.idFiscales', array('razonSocial'))
		->join('Proveedores','Empresa.idEmpresa = Proveedores.idEmpresa');
		return $tablaEmpresa->fetchAll($select);	
	}

	public function obtenerNotaEntrada(){
	
	}
	
	public function obtenerProducto ($idProducto){
	
	}
	
	public function agregarProducto(array $encabezado, $producto, $formaPago){
		
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		$date = new Zend_Date();
		$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
		$row = $tablaMultiplos->fetchRow($select); 
		
		if(is_null($row)) throw new Util_Exception_BussinessException("Error: Favor de verificar ");
		
		try{
			$secuencial=0;	
			$tablaMovimiento = $this->tablaMovimiento;
			$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
			->where("idCoP=?",$encabezado['idCoP'])
			->where("idSucursal=?",$encabezado['idSucursal'])
			->where("fecha=?", $stringIni)
			->order("secuencial DESC");
		
			$row = $tablaMovimiento->fetchRow($select); 
		
			if(!is_null($row)){
				$secuencial= $row->secuencial +1;
			}else{
				$secuencial = 1;	
			}
			//=================Selecciona producto y unidad=======================================
			$tablaMultiplos = $this->tablaMultiplos;
			$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
			$row = $tablaMultiplos->fetchRow($select); 
		
			//====================Operaciones para convertir unidad minima====================================================== 
			$cantidad=0;
			$precioUnitario=0;
			$cantidad = $producto['cantidad'] * $row->cantidad;
			$precioUnitario = $producto['precioUnitario'] / $row->cantidad;
			
			$mMovtos = array(
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idEmpresas'=>$encabezado['idEmpresas'],
					'idSucursal'=>$encabezado['idSucursal'],
					'idCoP'=>$encabezado['idCoP'],
					'numeroFolio'=>$encabezado['numFolio'],
					//'idFactura'=>0,
					'idProducto' => $producto['descripcion'],
					'idProyecto'=>$encabezado['idProyecto'],
					'cantidad'=>$cantidad,
					'fecha'=>$stringIni,
					'secuencial'=> $secuencial,
					'estatus'=>"A",
					'costoUnitario'=>$precioUnitario,
					'totalImporte'=>$producto['importe']
				);
			
			//print_r($mMovtos);
			$bd->insert("Movimientos",$mMovtos);
			
			$secuencial=0;	
			$tablaCuentasxp = $this->tablaCuentasxp;
			$select = $tablaCuentasxp->select()->from($tablaCuentasxp)->where("numeroFolio=?",$encabezado['numFolio'])
			->where("idCoP=?",$encabezado['idCoP'])
			->where("idSucursal=?",$encabezado['idSucursal'])
			->where("fechaPago=?", $stringIni)
			->order("secuencial DESC");
			$row = $tablaMovimiento->fetchRow($select); 
			
			if(!is_null($row)){
				$secuencial= $row->secuencial +1;
			}else{
				$secuencial = 1;	
			}
			
			$mCuentasxp = array(
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idSucursal'=>$encabezado['idSucursal'],
					'idCoP'=>$encabezado['idCoP'],
					//'idFactura'=>$encabezado['idFactura'],
					'idBanco'=>$formaPago['idBanco'],
					'idDivisa'=>$formaPago['idDivisa'],
					'numeroFolio'=>$encabezado['numFolio'],
					'numeroReferencia'=>"",
					'secuencial'=>$secuencial,
					'estatus'=>"A",
					'fechaPago'=>$stringIni,
					'fechaCaptura'=>$date->toString ('yyyy-MM-dd'),
					'formaLiquidar'=>$formaPago['formaLiquidar'],
					'conceptoPago'=>$formaPago['conceptoPago'],
					'subTotal'=>0,
					'total'=>$producto['importe']
				);   
			
				print_r($mCuentasxp);
				$bd->insert("Cuentasxp",$mCuentasxp);
			
		//========================Realiza Movimiento en banco===================================
		
			$tablaBancos = $this->tablaBancos;
			$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco =?", $formaPago['idBanco']);
			$row = $tablaBancos->fetchRow($select);
		
			if(!is_null($row)){
				$where = $tablaBancos->getAdapter()->quoteInto("idBanco = ?", $formaPago['idBanco']);
				
				$importePago = $row->saldo - $producto['importe'];
				//print_r($importePago);
				$where = $tablaBancos->getAdapter()->quoteInto("idBanco = ?", $formaPago['idBanco']);
				$tablaBancos->update(array('saldo'=> $importePago,'fecha'=>$stringIni), $where);
			}
		
		//========================Secuencial==================================================
			$secuencial=0;	
			$tablaCapas = $this->tablaCapas;
			$select = $tablaCapas->select()->from($tablaCapas)
			->where("numeroFolio=?",$encabezado['numFolio'])
			->where("fechaEntrada=?", $stringIni)
			->order("secuencial DESC");
			$row = $tablaCapas->fetchRow($select); 
		
			if(!is_null($row)){
				$secuencial= $row->secuencial +1;
			}else{
				$secuencial = 1;	
			}
		
		//=================Selecciona producto y unidad=======================================
			$tablaMultiplos = $this->tablaMultiplos;
			$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
			$row = $tablaMultiplos->fetchRow($select); 
			//print_r("<br />");
				
		//====================Operaciones para convertir unidad minima====================================================== 
			$cantidad=0;
			$precioUnitario=0;
			$cantidad = $producto['cantidad'] * $row->cantidad;
			$precioUnitario = $producto['precioUnitario'] / $row->cantidad;
			
			if(!is_null($row)){
				$mCapas = array(
					'idProducto' => $producto['descripcion'],
					'idSucursal' => $encabezado['idSucursal'],
					'idDivisa'=>$formaPago['idDivisa'],
					'numeroFolio'=>$encabezado['numFolio'],
					'secuencial'=>$secuencial,
					'cantidad'=>$cantidad,
					'fechaEntrada'=>$stringIni,
					'costoUnitario'=>$precioUnitario
					
				);
				$bd->insert("Capas",$mCapas);
		}
		//Insertamos en Inventario
		//=================Selecciona producto y unidad=======================================
			$tablaMultiplos = $this->tablaMultiplos;
			$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
			$row = $tablaMultiplos->fetchRow($select); 

		//====================Operaciones para convertir unidad minima====================================================== 
			/*$cantidad=0;
			$precioUnitario=0;
			$cantidad = $producto['cantidad'] * $row->cantidad;
			$precioUnitario = $producto['precioUnitario'] / $row->cantidad;*/
			/*print_r("<br />");
			print_r($cantidad);

			print_r("<br />");
			print_r($precioUnitario);*/
		
			$tablaInventario = $this->tablaInventario;
			$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
			$row = $tablaInventario->fetchRow($select);
			//print_r("<br />");

			if(!is_null($row)){
				$cantidad = $row->existencia + $cantidad;	
				$where = $tablaInventario->getAdapter()->quoteInto("idProducto = ?", $row->idProducto);	
				$tablaInventario->update(array('existencia'=> $cantidad,'existenciaReal'=> $cantidad), $where);	
			}else{
					
			$mInventario = array(
					'idProducto'=>$producto['descripcion'],
					'idDivisa'=>$formaPago['idDivisa'],
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
					'costoCliente'=>$producto['importe']
				);
			$bd->insert("Inventario",$mInventario);
			}
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
