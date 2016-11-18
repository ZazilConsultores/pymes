<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_FacturaProveedor implements Contabilidad_Interfaces_IFacturaProveedor{
	
	private $tablaFactura;
	private $tablaFacturaDetalle;
	private $tablaImpuestos;
	
	private $tablaMovimiento;
	private $tablaInventario;
	private $tablaCapas;
	private $tablaMultiplos;
	private $tablaEmpresa;
	
	public function __construct() {
		$this->tablaFactura = new Contabilidad_Model_DbTable_Factura;
		$this->tablaFacturaDetalle = new Contabilidad_Model_DbTable_FacturaDetalle;
		$this->tablaImpuestos = new Contabilidad_Model_DbTable_Impuestos;
		
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos;
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas;
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario;
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos;
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
		$this->tablaProducto = new Inventario_Model_DbTable_Producto;
		
	}
	
		
	public function guardaFactura(array $encabezado, $importe, $formaPago)
	{
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		$tablaFactura = $this->tablaFactura;		
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
		$stringFecha = $fechaInicio->toString('YY-mm-dd');
		
		$tablaFactura = $this->tablaFactura;
		$select = $tablaFactura->select()->from($tablaFactura);
		 
		
		//print_r($result);
		try{
			$conceptoPago;
			
			if(($formaPago['Pagada'])==="1"){
				$conceptoPago = "LI";
				
				
			}elseif(($formaPago['Pagada'])=== "0"){
				
				$conceptoPago = "PA";
			
			}	
				
			$mFactura = array(
						'idTipoMovimiento' => $encabezado['idTipoMovimiento'],
						'idSucursal'=>$encabezado['idSucursal'],
						'idCoP'=>$encabezado['idCoP'],
						'idDivisa'=>$formaPago['idDivisa'],
						'numeroFactura'=>$encabezado['numeroFactura'],
						'folioFiscal'=>$encabezado['folioFiscal'],
						'estatus'=>"A",
						'descuento'=>$importe[0]['descuento'],
						'conceptoPago'=>$conceptoPago,
						'formaPago'=>$formaPago['formaLiquidar'],
						'fechaFactura'=> $stringFecha,
						//'fechaCancelada'=>$fechaCancelada,
						'subtotal'=>$importe[0]['subtotal'],
						'total'=>$importe[0]['total'],
						'importePago'=>0
					);
							
				print("<br />");
				$mFacturaImpuesto = array(
					//	'idFactura'=>$idFactura,
						'isrImporte'=>$importe[0]['iva'],
						'ivaImporte'=>$importe[0]['ish'],
						'ishImporte'=>$importe[0]['isr'],
						
					);	
				
			
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
	
	public function agregarFactura(array $encabezado, $formaPago,$producto)
	{
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		
		
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
		$stringFecha = $fechaInicio->toString('YY-mm-dd');
		
		
		
		try{
			//=================Selecciona producto y unidad=======================================
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
		$row = $tablaMultiplos->fetchRow($select); 
		//print_r("<br />");
			//print_r("$select");
				
		//====================Operaciones para convertir unidad minima====================================================== 
			$cantidad=0;
			$precioUnitario=0;
			$cantidad = $producto['cantidad'] * $row->cantidad;
			$precioUnitario = $producto['precioUnitario'] / $row->cantidad;
			
			//====================================secuencial
		$secuencial=0;	
		$tablaMovimiento = $this->tablaMovimiento;
		$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("idTipoMovimiento=?",$encabezado['idTipoMovimiento'])
		->where("idCoP=?",$encabezado['idCoP'])
		->where("idSucursal=?",$encabezado['idSucursal'])
		->where("numeroFolio=?",$encabezado['numeroFactura'])
		->where("fecha=?", $stringFecha)
		->order("secuencial DESC");
	
		$row = $tablaMovimiento->fetchRow($select); 
		
		if(!is_null($row)){
			$secuencial= $row->secuencial +1;
			//print_r($secuencial);
		}else{
			$secuencial = 1;	
			//print_r($secuencial);
		}
			
		// Obtenemos el id autoincrementable de la tabla Fiscales
		$idFactura = $bd->lastInsertId("Factura","idFactura");
		//print_r("El idFactura es:");
		print_r($idFactura);		
			$mMovtos = array(
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idEmpresas'=>$encabezado['idEmpresas'],
					'idSucursal'=>$encabezado['idSucursal'],
					'idCoP'=>$encabezado['idCoP'],
					'numeroFolio'=>$encabezado['numeroFactura'],
					'idFactura'=>$idFactura,
				 	'idProducto' => $producto['descripcion'],
					'idProyecto'=>$encabezado['idProyecto'],
					'cantidad'=>$cantidad,
					'fecha'=>$stringFecha,
					'secuencial'=> $secuencial,
					'estatus'=>"A",
					'costoUnitario'=>$precioUnitario,
					'totalImporte'=>$producto['importe']
				);
				print_r("<br />");
				print_r($mMovtos);
			//$bd->insert("Movimientos",$mMovtos);
			
			
			
			// Obtenemos el id autoincrementable de la tabla Fiscales
			
				//Llena tabla facturaDetalle
				$mFacturaDetalle = array(
						//'idFactura' => $idFactura,
						'idMultiplos'=>2,
						'secuencial'=>$secuencial,
						'cantidad'=>$producto['cantidad'],
						'descripcion'=>'-',
						'precioUnitario'=>$producto['precioUnitario'],
						'importe'=>$producto['importe'],
						'fechaCaptura'=>date("Y-m-d H:i:s", time()),
						
					);
				
				//print_r($mFacturaDetalle);
				//$bd->insert("FacturaDetalle",$mFacturaDetalle);
				
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