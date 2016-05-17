<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_NotaEntrada implements Contabilidad_Interfaces_INotaEntrada{
//class Contabilidad_DAO_Divisa implements Contabilidad_Interfaces_IDivisa	
	private $tablaMovimiento;
	private $tablaInventario;
	private $tablaCapas;
	
	public function __construct() {
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos;
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas;
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario;		
	}
	
	
	public function obtenerNotaEntrada(){
	
			
	}
	
	public function crearNotaEntrada(array $datos){
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
	
		try{
		
			$mMovimiento = new Contabilidad_Model_Movimientos($datos);
			$fecha = new Zend_Date($datos["fecha"],'yyyy-MM-dd hh-mm-ss');
			$bd->insert("Movimientos", $mMovimiento->toArray());
			$mMovtos = array(
					'idProducto' => $datos['idProducto'],
					'idTipoMovimiento'=>$datos['idTipoMovimiento'],
					'idEmpresa'=>$datos['idEmpresa'],
					'idProyecto'=>$datos['idProyecto'],
					'numFactura'=>$datos['numFactura'],
					'cantidad'=>$datos['cantidad'],
					'fecha'=>($fecha->toString('yyyy-MM-dd hh-mm-ss')),
					'estatus'=>"A",
					'secuencial'=> '1',
					'costoUnitario'=>$datos['costoUnitario'],
					'esOrigen'=>$datos['esOrigen'],
					'totalImporte'=>$datos['totalImporte']
					
				);
			
				print_r();
			$bd->insert("Movimientos",$mMovtos);
			
			$mCapas = array(
					'idProducto' => $datos['idProducto'],
					'idDivisa'=>$datos['idDivisa'],
					'secuencial'=>1,
					'entrada'=>$datos['cantidad'],
					'fechaEntrada'=>($fecha->toString('yyyy-MM-dd hh-mm-ss')),
					'costoUnitario'=>$datos['costoUnitario'],
					'costoTotal'=>$datos['totalImporte']
				);
			$bd->insert("Capas",$mCapas);
			
			//Insertamos en Inventario
			//$mInventario = new Contabilidad_Model_Inventario($datos);			
			$mInventario = array(
					'idProducto' => $datos['idProducto'],
					'idDivisa'=>$datos['idDivisa'],
					'idEmpresa'=>$datos['idEmpresa'],
					'existencia'=>$datos['cantidad'],
					'apartado'=>'0',
					'existenciaReal'=>$datos['cantidad'],
					'maximo'=>'0',
					'minimo'=>'0',
					'fecha'=>($fecha->toString('yyyy-MM-dd hh-mm-ss')),
					'costoUnitario'=>$datos['costoUnitario'],
					'porcentajeGanancia'=>'0',
					'cantidadGanancia'=>'0',
					'costoCliente'=>$datos['costoUnitario']
				);
			$bd->insert("Inventario",$mInventario);
			
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
