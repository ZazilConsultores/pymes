<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_NotaSalida implements Contabilidad_Interfaces_INotaSalida{
	private $tablaMovimiento;
	private $tablaInventario;
	private $tablaCapas;
	private $tablaMultiplos;
	private $tablaCardex;
	private $tablaClientes;
	
	public function __construct() {
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos;
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas;
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario;
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos;
		$this->tablaCardex = new  Contabilidad_Model_DbTable_Cardex;
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;	
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

	
	public function restarProducto(array $encabezado, $producto){
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
		$row = $tablaMultiplos->fetchRow($select); 
		//print_r($row);
		if(is_null($row)) throw new Util_Exception_BussinessException("Error: Favor de verificar Multiplo");
		
		try{
		
//*=======================Crea secuencial, convierte a unidad minima y guarda registro en tabla Movimiento=======================================
		$tablaMovimiento = $this->tablaMovimiento;
		$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numFolio'])
		->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])
		->where("idCoP=?",$encabezado['idCoP'])
		->where("idEmpresas=?",$encabezado['idEmpresas'])
		->where("fecha=?", $stringIni)
		->order("secuencial DESC");
	
		$row = $tablaMovimiento->fetchRow($select); 
		
		if(!is_null($row)){
			$secuencial= $row->secuencial +1;
			
		}else{
			$secuencial = 1;	
		}

//=======================================================
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
		$row = $tablaMultiplos->fetchRow($select); 
		//print_r("$select");
		
			$cantidad = 0;
			$precioUnitario = 0;
			
			$cantidad = $producto['cantidad'] * $row->cantidad;
			$precioUnitario = $producto['precioUnitario'] / $row->cantidad;
			
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
			
			print_r($mMovtos);
			$bd->insert("Movimientos",$mMovtos);
			
//======================Resta en capas, inventario y crea Cardex============================================================================*//
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
		$row = $tablaMultiplos->fetchRow($select); 
		
		$cantidad = 0;
		$precioUnitario = 0;
		$cantidad = $producto['cantidad'] * $row->cantidad;
		$precioUnitario = $producto['precioUnitario'] / $row->cantidad;
			
			
		$tablaInventario = $this->tablaInventario;
		$select = $tablaInventario->select()->from($tablaInventario)->where("idProducto=?",$producto['descripcion']);
		$row = $tablaInventario->fetchRow($select);
		$restaCantidad = $row->existencia - $cantidad;
		
		//print_r("Cantidad en inventario:");
		//print_r("$restaCantidad");
		

		if(!is_null($row)){
			print_r("la cantidad en inventario no es menor que 0");
			print_r("<br />");
			$tablaCapas = $this->tablaCapas;
			$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['descripcion']) 
			->order("fechaEntrada ASC");
			
			$row = $tablaCapas->fetchRow($select);
			//print_r("<br />");
			print_r("<br />");
			//print_r("$select");
			//print_r("<br />");
			$cant =  $row->cantidad - $cantidad;
			//print_r("Cant <br />");
			print_r("<br />");
			//print_r("<Cantidad en Capas />");
			print_r("<br />");
			//print_r($cant);
			print_r("<br />");
			
			
		//=====================================================================Resta 
		if(!$cant <= 0){
			
			$where = $tablaCapas->getAdapter()->quoteInto("idProducto =?",$row->idProducto,"fechaEntrada =?",$row->fechaEntrada );
			print_r("<br />");
			print_r("query seleccion producto:");		
			print_r("<br />");
			print_r("$where");
			print_r("<br />");
			print_r($cant);
			print_r("<br />");
			$tablaCapas->update(array('cantidad'=>$cant), $where);
			print_r("<br />");
			print_r("<br />");
			print_r("$where");
		}else{
		
			$where = $tablaCapas->getAdapter()->quoteInto("fechaEntrada=?", $row->fechaEntrada,"idProducto =?",$row->idProducto);	
			$tablaCapas->delete($where);
		}
		
		$tablaCapas = $this->tablaCapas;
		$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto=?",$producto['descripcion'])
		//->where("fechaEntrada )
		->order("fechaEntrada ASC");
		$row = $tablaCapas->fetchRow($select);
		
		$mCardex = array(
					'idSucursal'=>$encabezado['idSucursal'],
					'numerofolio'=>$encabezado['numFolio'],
					'idProducto'=>$producto['descripcion'],
					'idDivisa'=>1,
					'secuencialEntrada'=>$row['secuencial'],
					'fechaEntrada'=>$row['fechaEntrada'],
					'secuencialSalida'=>$mMovtos['secuencial'],
					'fechaSalida'=>$stringIni,
					'cantidad'=>$cantidad,
					'costo'=>$row['costoUnitario'],
					'costoSalida'=>$producto['importe'],
					'utilidad'=>($mMovtos['costoUnitario']-$row['costoUnitario'])* $mMovtos['cantidad']
					
			);
			print_r($mCardex);
			$bd->insert("Cardex",$mCardex);
		//===Resta cantidad en inventario
		
			$tablaInventario = $this->tablaInventario;
			$where = $tablaInventario->getAdapter()->quoteInto("idProducto=?", $producto['descripcion']);
			$tablaInventario->update(array('existencia'=>$restaCantidad, 'existenciaReal'=>$restaCantidad),$where);
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