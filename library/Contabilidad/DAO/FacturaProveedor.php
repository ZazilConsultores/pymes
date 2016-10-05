<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_FacturaProveedor implements Contabilidad_Interfaces_IFacturaProveedor{
	
	private $tablaFactura;
	private $tablaFacturaDetalle;
	
	private $tablaMovimiento;
	private $tablaInventario;
	private $tablaCapas;
	private $tablaMultiplos;
	private $tablaEmpresa;
	
	public function __construct() {
		$this->tablaFactura = new Contabilidad_Model_DbTable_Factura;
		$this->tablaFacturaDetalle = new Contabilidad_Model_DbTable_FacturaDetalle;
		
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos;
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas;
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario;
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos;
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
		$this->tablaProducto = new Inventario_Model_DbTable_Producto;
	}
		
	public function agregarFactura(array $encabezado, $formaPago,$impuestos,$producto)
	{
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
		$stringFecha = $fechaInicio->toString('YY-mm-dd');
		
		try{
			//////==============================
			if(($formaPago['Pagada'])=== "SI"){
				$conceptoPago = "LI";
				print_r($conceptoPago);
				
			}elseif(($formaPago['Pagada'])=== "NO"){
				
				$conceptoPago = "PA";
				print_r($conceptoPago);
			}
			//====================================
			
			
			//Validar que no se vuelva a registrar la misma factura en la tabla Movimientos
			$tablaMovimiento = $this->tablaMovimiento;
			$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("idTipoMovimiento=?",$encabezado['numeroFactura'])
			->where("idTipoMovimiento = ?",$encabezado['idTipoMovimiento'])
			->where("idCoP=?",$encabezado['idCoP'])
			->where("idSucursal=?",$encabezado['idSucursal']);
			
			/*if(!is_null($row)){}
			
			$mMovtos = array(
				'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
				'idEmpresas'=>$encabezado['idEmpresas'],
				'idSucursal'=>$encabezado['idSucursal'],
				'idCoP'=>$encabezado['idCoP'],
				//'numeroFolio'=>$encabezado['numFolio'],
				'idFactura'=>0,
				'idProducto' => $producto['descripcion'],
				//'idProyecto'=>$encabezado['idProyecto'],
				'cantidad'=>$cantidad,
				'fecha'=>$stringIni,
				'secuencial'=> $secuencial,
				'estatus'=>"A",
				'costoUnitario'=>$precioUnitario,
				'totalImporte'=>$producto['importe']
				);
			
			//print_r($mMovtos);
			$bd->insert("Movimientos",$mMovtos);*/
			
			//Validar que no se vuelva a registrar la misma factura en la tabla factura
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("numeroFactura=?",$encabezado['numeroFactura'])
			->where("idTipoMovimiento = ?",$encabezado['idTipoMovimiento'])
			->where("idCoP=?",$encabezado['idCoP'])
			->where("idSucursal=?",$encabezado['idSucursal']);
			
			//if(!is_null($row)){}
				
			//Valida que cantidad, desripcion de producti, costo e Importe no esten vacios o diferente de 0
			if(is_null('cantidad') and (is_null($producto['descripcion'])) and(is_null($producot['costoUnitario'])) and (is_null($producto['costoTotal']))){
				print_r("Los Datos estan vacios");	
			}	
		
			$tablaMovimiento = $this->tablaMovimiento;
			$select = $tablaMovimiento->select()->from($tablaMovimiento)->where("numeroFolio=?",$encabezado['numeroFactura'])
			->where("idCoP=?",$encabezado['idCoP'])
			->where("idSucursal=?",$encabezado['idSucursal'])
			//->where("fecha=?", $stringIni)
			->order("secuencial DESC");
			
			
			$mFactura = array(
						'idTipoMovimiento' => $encabezado['idTipoMovimiento'],
						'idSucursal'=>$encabezado['idSucursal'],
						'idCoP'=>$encabezado['idCoP'],
						'idDivisa'=>$formaPago['idDivisa'],
						'numeroFactura'=>$encabezado['numeroFactura'],
						'estatus'=>"A",
						'conceptoPago'=> $conceptoPago,
						'descuento'=>0,
						'condicionPago'=>1,
						'formaPago'=>$formaPago['formaLiquidar'],
						'fechaFactura'=> $stringFecha,
						//'fechaCancelada'=>$fechaCancelada,
						'subTotal'=>$impuestos['subtotal'],
						'total'=>$impuestos['total']
					);
				
				//print_r($mMovtos);
				$bd->insert("Factura",$mFactura);
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