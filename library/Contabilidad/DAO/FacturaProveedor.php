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
	
	public function convertirMultiplo (array $producto){
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
		$row = $tablaMultiplos->fetchRow($select);
	
	}
	
	//Validar que no se vuelva a registrar la misma factura en la tabla factura
	public function existeFactura($numeroFactura,$idTipoMovimiento,$idCoP, $idSucursal){	
		$tablaFactura = $this->tablaFactura;
		$select = $tablaFactura->select()->from($tablaFactura)->where("numeroFactura=?",$numeroFactura)
		->where("idTipoMovimiento = ?",$idTipoMovimiento)
		->where("idCoP=?",$idCoP)
		->where("idSucursal=?",$idSucursal);
		$rowFactura = $tablaFactura->fetchRow($select);
		
		$facturaModel = new Contabilidad_Model_Factura($rowFactura->toArray());
		$facturaModel->setNumeroFactura($numeroFactura);
		$facturaModel->setIdCoP($idCoP);
		$facturaModel->setIdTipoMovimiento($idTipoMovimiento);
		$facturaModel->setIdSucursal($idSucursal);
		
		return $facturaModel;
		
		if(is_null($row)) throw new Util_Exception_BussinessException("Error: Favor de verificar Multiplo");
		$cantidad=0;
		$precioUnitario=0;
		$cantidad = $producto['cantidad'] * $row->cantidad;
		$precioUnitario = $producto['precioUnitario'] / $row->cantidad;
	}
	
	public function convierteMultiplo($idProducto, $idUnidad){
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$idProducto)
		->where("idUnidad=?",$idUnidad);
		
		$rowMultiplo = $tablaMultiplos->fetchRow($select);
	
		$multiploModel =  new Inventario_Model_Multiplos;
		$multiploModel->setIdProducto($idProducto);
		$multiploModel->setIdUnidad($idUnidad);
		
		return $multiploModel;
		
	}
		
	public function agregarFactura(array $encabezado, $formaPago,$producto)
	{
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		$fechaInicio = new Zend_Date($encabezado['fecha'],'YY-mm-dd');
		$stringFecha = $fechaInicio->toString('YY-mm-dd');
		
		try{
			
			//====================================
			
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
			//Guarda en tabla Factura despues de haber convertido el Multiplo
			
			//=====Pagada en pagos o en un solo pago
			$conceptoPago;
			if(($formaPago['Pagada'])=== "SI"){
				$conceptoPago = "LI";
				print_r($conceptoPago);
				
			}elseif(($formaPago['Pagada'])=== "NO"){
				
				$conceptoPago = "PA";
				print_r($conceptoPago);
			}	
			$mFactura = array(
						'idTipoMovimiento' => $encabezado['idTipoMovimiento'],
						'idSucursal'=>$encabezado['idSucursal'],
						'idCoP'=>$encabezado['idCoP'],
						'idDivisa'=>$formaPago['idDivisa'],
						'numeroFactura'=>$encabezado['numeroFactura'],
						'numeroFiscal'=>$encabezado['folioFiscal'],
						'estatus'=>"A",
						'descuento'=>$producto['descuento'],
						'conceptoPago'=>$conceptoPago,
						'formaPago'=>$formaPago['formaLiquidar'],
						'fechaFactura'=> $stringFecha,
						//'fechaCancelada'=>$fechaCancelada,
						'subTotal'=>$producto['subTotal'],
						'total'=>$producto['total']
					);
				
				//print_r($mMovtos);
				$bd->insert("Factura",$mFactura);
				
				//======Llena tabla Impuestos
				$mImpuestos = array(
						'idTipoMovimiento' => $encabezado['idTipoMovimiento'],
						'idFactura'=>$encabezado['idSucursal'],
						'idProducto'=>$encabezado['idCoP'],
						'descripcion'=>$formaPago['idDivisa'],
						'abreviatura'=>$encabezado['numeroFactura'],
						'porcentaje'=>$encabezado['folioFiscal'],
						'importe'=>"A",
						
					);
				
				//print_r($mMovtos);
				$bd->insert("Factura",$mFactura);
				
				/*$mMovtos = array(
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idEmpresas'=>$encabezado['idEmpresas'],
					'idSucursal'=>$encabezado['idSucursal'],
					'idCoP'=>$encabezado['idCoP'],
					//'numeroFolio'=>$encabezado['numFolio'],
					//'idFactura'=>$mFactura['idFactura'],
					'idProducto' => $producto['descripcion'],
					//'idProyecto'=>$encabezado['idProyecto'],
					'cantidad'=>$cantidad,
					'fecha'=>$stringIni,
					'secuencial'=> $secuencial,
					'estatus'=>"A",
					'costoUnitario'=>$precioUnitario,
					'totalImporte'=>$producto['importe']
				);*/
			
			//print_r($mMovtos);
			//$bd->insert("Movimientos",$mMovtos);
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