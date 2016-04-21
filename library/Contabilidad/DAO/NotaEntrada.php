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
			//$movimiento =$datos;
			$mMovimiento = new Contabilidad_Model_Movimientos($datos);
			print_r($datos);
			$bd->insert("Movimientos", $mMovimiento->toArray());
			
			//Insertamos en capas
			//$mCapas = new Contabilidad_Model_Capas($datos);
			
			$mCapas = array(
					'idProducto' => $datos['idProducto'],
					'idDivisa'=>$datos['idDivisa'],
					'secuencial'=>$datos['secuencial'],
					'entrada'=>$datos['cantidad'],
					'fechaEntrada'=>$datos['fecha'],
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
					'fecha'=>$datos['fecha'],
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
