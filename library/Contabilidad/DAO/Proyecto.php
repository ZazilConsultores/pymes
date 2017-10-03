<?php

class Contabilidad_DAO_Proyecto implements Contabilidad_Interfaces_IProyecto {
		
	private $tablaProyecto;
	private $tablaMovimiento;
	private $tablaTipoMovimiento;
	private $tablaClientes;
	private $tablaEmpresa;
	private $tablaFiscales;
	private $tablaSucursal;
	
	public function __construct()
	{
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaProyecto = new Contabilidad_Model_DbTable_Proyecto(array('db'=>$dbAdapter));
		$this->tablaMovimiento= new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
		$this->tablaTipoMovimiento= new Contabilidad_Model_DbTable_TipoMovimiento(array('db'=>$dbAdapter));
		$this->tablaClientes= new Sistema_Model_DbTable_Clientes(array('db'=>$dbAdapter));
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
		$this->tablaFiscales = new Sistema_Model_DbTable_Fiscales(array('db'=>$dbAdapter));
		$this->tablaSucursal = new Sistema_Model_DbTable_Sucursal(array('db'=>$dbAdapter));
	}
	
	public function crearProyecto(Contabilidad_Model_Proyecto $proyecto)
	{
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();		
		$fechaApertura = new Zend_Date($proyecto->getFechaApertura());	
		$stringIni = $fechaApertura->toString('yyyy-MM-dd hh:mm:ss',time());
	
		$fechaCierre = $proyecto->getFechaCierre();	
		$Ganancia = $proyecto->getCostoFinal()- $proyecto->getCostoInicial();
		$proyecto->setFechaApertura($stringIni);
		
		if(($fechaCierre=="")){
			$proyecto->setFechaCierre(date("Y-m-d H:i:s", time()));
		}else{
			$fechaCierre = new Zend_Date($proyecto->getFechaCierre());	
			$stringIni = $fechaCierre->toString('yyyy-MM-dd');
			$proyecto->setFechaCierre($stringIni);
		}
		$this->tablaProyecto->insert($proyecto->toArray());		
	}
	
	public function obtenerProyectos(){
		$tablaProyecto = $this->tablaProyecto;
		$rowProyectos = $tablaProyecto->fetchAll();
		$modelProyectos = array();
		
		
		foreach ($rowProyectos as $rowProyecto) {
			$modelProyecto = new Contabilidad_Model_Proyecto($rowProyecto->toArray());
			
			$modelProyectos[] = $modelProyecto;
			
		}
		
		return $modelProyectos;
	}
	
	public function obtenerProyecto($idSucursal){
		$tablaProyecto = $this->tablaProyecto;
		$select = $tablaProyecto->select()->from($tablaProyecto)->where("idSucursal=?",$idSucursal);
		$rowsProyectos = $tablaProyecto->fetchAll($select);
		
		if(!is_null($rowsProyectos)){
			return $rowsProyectos->toArray();
		}else{
			return null;
		}
	}
	
	public function obtieneProyectoCliente($idCoP){
		$tablaTipoMovimiento =  $this->tablaTipoMovimiento;
		$select   = $tablaTipoMovimiento->select()->from($tablaTipoMovimiento)->where("afectaInventario = ?", "-");
		$rowsTipoMovtos = $tablaTipoMovimiento->fetchAll($select);
		$idsTipoMovimiento = array ();
		foreach ($rowsTipoMovtos as $rowTipoMovimiento) {
			if(!in_array($rowTipoMovimiento->idTipoMovimiento, $idsTipoMovimiento)){
				$idsTipoMovimiento[] = $rowTipoMovimiento->idTipoMovimiento;
			}
		}
		
		
		/*$tablaMovimiento = $this->tablaMovimiento;
		$select  = $tablaMovimiento->select()->from($tablaMovimiento)->where("idCoP = ?", $idCoP)->where("idTipoMovimiento  IN (?)", $idsTipoMovimiento);
		$rowsMovimientos = $tablaMovimiento->fetchAll($select);
		print_r("$select");
		//return $rowsMovimientos->toArray();
		
		/*foreach($rowsMovimientos as $rowMovimiento){
			$tablaProyecto  = $this->tablaProyecto;
			$select = $tablaProyecto->select()->from($tablaProyecto)->where("idProyecto  =?",$rowMovimiento->idProyecto);
			$rowProyecto = $tablaProyecto->fetchRow($select);
			print_r("$select");
		}*/

		
		//return $rowsMovimientos;	
			$tablaMovimientos = $this->tablaMovimiento;
			$select= $tablaMovimientos->select()
			->setIntegrityCheck(false)
			->from($tablaMovimientos, new Zend_Db_Expr('DISTINCT(Movimientos.idFactura)as idFactura'))
			->join('Factura', 'Movimientos.idFactura = Factura.idFactura', array('total','Factura.idSucursal','Factura.idTipoMovimiento','Factura.numeroFactura','Factura.fecha'))
			->join('Proyecto', 'Movimientos.idProyecto = Proyecto.idProyecto', array('descripcion'))
			->where('Movimientos.idCoP =?', $idCoP)->where("Movimientos.idTipoMovimiento  IN (?)", $idsTipoMovimiento)->order('Factura.idTipoMovimiento')->order("Factura.numeroFactura ASC");
			//print_r("$select");
			return $tablaMovimientos->fetchAll($select);
	}
}