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
	private $tablaMultiplos;
	
	public function __construct() {
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos;
		$this->tablaCapas = new Contabilidad_Model_DbTable_Capas;
		$this->tablaInventario = new Contabilidad_Model_DbTable_Inventario;
		$this->tablaMultiplos = new Inventario_Model_DbTable_Multiplos;
			
		
		$this->tablaProducto = new Inventario_Model_DbTable_Producto;
	}

	public function obtenerNotaEntrada(){
	
	}
	
	public function obtenerProducto ($idProducto){
		$tablaCapas = $this->tablaCapas;
		$select = $tablaCapas->select()->from($tablaCapas)->where("idProducto= ?", getIdProducto());
		$rowsCapas = $tablaCapas->fetchAll($select);
		$modelCapas = array();
		
		if(!is_null($rowsCapas)){
			foreach ($rowsCapas as $rowCapa) {
				$modelCapas = new Contabilidad_Model_Capas($row->toArray());
				$modelCapas[] = $modelCapa;
			}
		}
		
		return $modelCapas;
	}
	
	public function agregarProducto(array $encabezado, $producto){
		//print_r($datos);
		$datos=array();
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		$dateIni = new Zend_Date($encabezado['fecha'],'YY-MM-dd');
		$stringIni = $dateIni->toString ('yyyy-MM-dd');
		
		try{
			
			$mMovtos = array(
					'idProducto' => $producto['descripcion'],
					'idTipoMovimiento'=>$encabezado['idTipoMovimiento'],
					'idEmpresa'=>$encabezado['idEmpresa'],
					'idProyecto'=>$encabezado['idProyecto'],
					'numFactura'=>$encabezado['numFactura'],
					'cantidad'=>$producto['cantidad'],
					'fecha'=>$stringIni,
					'estatus'=>"A",
					'secuencial'=> 1,
					'costoUnitario'=>$producto['precioUnitario'],
					'esOrigen'=>"E",
					'totalImporte'=>$producto['importe']
				);
			
			//print_r($mMovtos);
			//$bd->insert("Movimientos",$mMovtos);

		
		//=================Selecciona producto y unidad=======================================
		$tablaMultiplos = $this->tablaMultiplos;
		$select = $tablaMultiplos->select()->from($tablaMultiplos)->where("idProducto=?",$producto['descripcion'])->where("idUnidad=?",$producto['unidad']);
		$row = $tablaMultiplos->fetchRow($select); 
		print_r("<br />");
		//print_r("$select");
		//====================Operaciones para convertir unidad minima====================================================== 
			$cantidad=0;
			$precioUnitario=0;
			$cantidad = $producto['cantidad'] * $row->cantidad;
			$precioUnitario = $producto['precioUnitario'] / $row->cantidad;
			print_r("<br />");
			print_r($cantidad);

			print_r("<br />");
			print_r($precioUnitario);
		
		$tablaCapas = $this->tablaCapas;
		$select = $tablaCapas->select()->from($tablaCapas,'entrada')->where("idProducto=?",$producto['descripcion'])
		->where ("fechaEntrada = ?", $stringIni);
		$row = $tablaCapas->fetchRow($select);
		print_r("<br />");
		print_r("$select");

		if(!is_null($row)){
			$cantidad = $row->entrada + $cantidad;
			print ("<br />");
			print ("<br />");
			print ($cantidad);
			$where = $tablaCapas->getAdapter()->quoteInto("entrada = ?", $row->entrada);	
			$tablaCapas->update(array('entrada'=> $cantidad), $where);	
			print_r("<br />");
			print_r("<br />");
			//print_r("$tablaCapas");
		}else{
			$mCapas = array(
					'idProducto' => $producto['descripcion'],
					'idDivisa'=>$encabezado['idDivisa'],
					'secuencial'=>1,
					'entrada'=>$cantidad,
					'fechaEntrada'=>$stringIni,
					'costoUnitario'=>$precioUnitario,
					'costoTotal'=>$producto['importe']
			);
			
			$bd->insert("Capas",$mCapas);
		}
			//Insertamos en Inventario
			//$mInventario = new Contabilidad_Model_Inventario($datos);			
			$mInventario = array(
					'idProducto'=>$producto['descripcion'],
					'idDivisa'=>$encabezado['idDivisa'],
					'idEmpresa'=>$encabezado['idEmpresa'],
					'existencia'=>$producto['cantidad'],
					'apartado'=>'0',
					'existenciaReal'=>$producto['cantidad'],
					'maximo'=>'0',
					'minimo'=>'0',
					'fecha'=>$stringIni,
					'costoUnitario'=>$producto['precioUnitario'],
					'porcentajeGanancia'=>'0',
					'cantidadGanancia'=>'0',
					'costoCliente'=>$producto['importe']
				);
			//$bd->insert("Inventario",$mInventario);
			
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
