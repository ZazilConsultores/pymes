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
		
		$tablaMovimientos = $this->tablaMovimiento;
			$select= $tablaMovimientos->select()
			->setIntegrityCheck(false)
			->from($tablaMovimientos, new Zend_Db_Expr('DISTINCT(Movimientos.idFactura)as idFactura'))
			->join('Factura', 'Movimientos.idFactura = Factura.idFactura', array('total','Factura.idSucursal','Factura.idTipoMovimiento','Factura.numeroFactura','Factura.fecha'))
			->join('Proyecto', 'Movimientos.idProyecto = Proyecto.idProyecto', array('descripcion'))
			->join('TipoMovimiento', 'Movimientos.idTipoMovimiento = TipoMovimiento.idTipoMovimiento', array('descripcion AS descripcionTipo' ))
			->where('Movimientos.idCoP =?', $idCoP)->where("Movimientos.idTipoMovimiento  IN (?)", $idsTipoMovimiento)->order('Factura.idTipoMovimiento')->order("Factura.numeroFactura ASC");
			//print_r("$select");
			return $tablaMovimientos->fetchAll($select);
	}
	
	public function obtieneProyectoxfecha($idProyecto,$fechaI, $fechaF){
		
		$tablaMovimientos = $this->tablaMovimiento;
		$select = $tablaMovimientos->select()->from($tablaMovimientos)->where("idProyecto=?",$idProyecto)->where('Movimientos.fecha >= ?',$fechaI)->where('Movimientos.fecha <=?',$fechaF) ;
		$rowsMovimiento = $tablaMovimientos->fetchAll($select);
		//print_r("$select");
		foreach ($rowsMovimiento as $rowMovimiento){
			if($rowMovimiento['idTipoMovimiento'] == 2){
				$tablaMovimientos  = $this->tablaMovimiento;
				$select = $tablaMovimientos->select()->setIntegrityCheck(false)
				->from($tablaMovimientos, new Zend_Db_Expr('DISTINCT(Movimientos.idFactura)as idFactura'))
				->join('Factura','Movimientos.idFactura = Factura.idFactura',array('idTipoMovimiento','numeroFactura','total'))
				->join('Proyecto','Movimientos.idProyecto = Proyecto.idProyecto')
				->join('Clientes','Movimientos.idCoP = Clientes.idCliente')
				->join('Empresa','Clientes.idEmpresa = Empresa.idEmpresa')
				->join('Fiscales','Empresa.idFiscales = Fiscales.idFiscales',  array('razonSocial'))
				->join('TipoMovimiento', 'Movimientos.idTipoMovimiento = TipoMovimiento.idTipoMovimiento', array('descripcion AS descripcionTipo'))
				->where('Movimientos.idTipoMovimiento =?', 2)->where('Movimientos.idProyecto =?',  $idProyecto)->where('Movimientos.fecha >= ?', $fechaI)->where('Movimientos.fecha <=?', $fechaF)
				->order("Factura.numeroFactura ASC");
				//print_r("$select");
				return $tablaMovimientos->fetchAll($select);	
			}
		}
	}
	
	public function obtieneProyectoProvxfecha($idProyecto,$fechaI, $fechaF){
		$tablaMovimientos = $this->tablaMovimiento;
		$select = $tablaMovimientos->select()->from($tablaMovimientos)->where("idProyecto=?",$idProyecto)->where('Movimientos.fecha >= ?',$fechaI)->where('Movimientos.fecha <=?',$fechaF)
		->where("idTipoMovimiento=?",4);
		$rowsMovimiento = $tablaMovimientos->fetchAll($select);
		//print_r("$select");
		foreach ($rowsMovimiento as $rowMovimiento){
				$tablaMovimientos  = $this->tablaMovimiento;
				$select = $tablaMovimientos->select()->setIntegrityCheck(false)
				->from($tablaMovimientos, new Zend_Db_Expr('DISTINCT(Movimientos.idFactura)as idFactura'))
				->join('Factura','Movimientos.idFactura = Factura.idFactura',array('idTipoMovimiento','numeroFactura','total','fecha'))
				->join('Proyecto','Movimientos.idProyecto = Proyecto.idProyecto')
				->join('Proveedores','Movimientos.idCoP = Proveedores.idProveedores')
				->join('Empresa','Proveedores.idEmpresa = Empresa.idEmpresa')
				->join('Fiscales','Empresa.idFiscales = Fiscales.idFiscales',  array('razonSocial'))
				->join('TipoMovimiento', 'Movimientos.idTipoMovimiento = TipoMovimiento.idTipoMovimiento', array('descripcion AS descripcionTipo'))
				->where('Movimientos.idProyecto =?', $idProyecto)->where('Movimientos.fecha >= ?',$fechaI)->where('Movimientos.fecha <=?',$fechaF)
				->where("Movimientos.idTipoMovimiento=?",4)->order("Factura.numeroFactura ASC");
				//print_r("$select");
				return $tablaMovimientos->fetchAll($select);
		}
	}

	public function obtieneProyectoRemisionClientexFecha($idProyecto,$fechaI, $fechaF){
	    $tablaMovimientos  = $this->tablaMovimiento;
	    $select = $tablaMovimientos->select()->from($tablaMovimientos)->where("idProyecto=?",$idProyecto);
	    $rowsMovimientos = $tablaMovimientos->fetchAll($select);
	    foreach ($rowsMovimientos as $rowMovimiento) {
	        if($rowMovimiento['idTipoMovimiento'] == 13 ){/*cliente*/
	            $tablaMovimientos = $this->tablaMovimiento;
	            $select  = $tablaMovimientos->select()
	            ->setIntegrityCheck(false)
	            ->from($tablaMovimientos)
	            ->join('Clientes','Movimientos.idCoP = Clientes.idCliente', array('idEmpresa'))
	            ->join('Empresa','Clientes.idEmpresa = Empresa.idEmpresa')
	            ->join('Fiscales','Empresa.idFiscales = Fiscales.idFiscales',  array('razonSocial'))
	            ->where('Movimientos.fecha >= ?',$fechaI)->where('Movimientos.fecha <=?',$fechaF)
	            ->where('Movimientos.idProyecto =?', $idProyecto)->order('Movimientos.idTipoMovimiento')->order("Movimientos.numeroFolio ASC");
	            //print_r("$select");
	            return $tablaMovimientos->fetchAll($select);
	        }
	    }	
	}
	public function obtieneProyectoRemisionProveedorxFecha($idProyecto,$fechaI, $fechaF){
		$tablaMovimientos  = $this->tablaMovimiento;
		$select = $tablaMovimientos->select()->from($tablaMovimientos)->where("idProyecto=?",$idProyecto);
		$rowsMovimientos = $tablaMovimientos->fetchAll($select);
		foreach ($rowsMovimientos as $rowMovimiento) {
			if($rowMovimiento['idTipoMovimiento'] == 12 ){/*cliente*/
				$tablaMovimientos = $this->tablaMovimiento;
				$select  = $tablaMovimientos->select()
				->setIntegrityCheck(false)
				->from($tablaMovimientos)
				->join('Proveedores','Movimientos.idCoP = Proveedores.idProveedores', array('idEmpresa'))
				->join('Empresa','Proveedores.idEmpresa = Empresa.idEmpresa')
				->join('Fiscales','Empresa.idFiscales = Fiscales.idFiscales',  array('razonSocial'))
				->where('Movimientos.fecha >= ?',$fechaI)->where('Movimientos.fecha <=?',$fechaF)
				->where('Movimientos.idProyecto =?', $idProyecto)->order('Movimientos.idTipoMovimiento')->order("Movimientos.numeroFolio ASC");
				return $tablaMovimientos->fetchAll($select);
			}
		}	
	}
	
	public function obtieneProyectoNominaProveedorxFecha($idProyecto,$fechaI, $fechaF){
		$tablaMovimientos  = $this->tablaMovimiento;
		$select = $tablaMovimientos->select()->from($tablaMovimientos)->where("idProyecto=?",$idProyecto);
		$rowsMovimientos = $tablaMovimientos->fetchAll($select);
		foreach ($rowsMovimientos as $rowMovimiento) {
			if($rowMovimiento['idTipoMovimiento'] == 20 ){/*cliente*/
				$tablaMovimientos = $this->tablaMovimiento;
				$select  = $tablaMovimientos->select()
				->setIntegrityCheck(false)
				->from($tablaMovimientos)
				->join('Proveedores','Movimientos.idCoP = Proveedores.idProveedores', array('idEmpresa'))
				->join('Empresa','Proveedores.idEmpresa = Empresa.idEmpresa')
				->join('Fiscales','Empresa.idFiscales = Fiscales.idFiscales',  array('razonSocial'))
				->where('Movimientos.fecha >= ?',$fechaI)->where('Movimientos.fecha <=?',$fechaF)
				->where('Movimientos.idProyecto =?', $idProyecto)->order('Movimientos.idTipoMovimiento')->order("Movimientos.numeroFolio ASC");
				//print_r("$select");
				return $tablaMovimientos->fetchAll($select);
			}
		}	
	}
	
	public function obtieneProyectoRemisionClienteCafeLxFecha($idProyecto,$fechaI, $fechaF){
	    $tablaMovimientos  = $this->tablaMovimiento;
	    $select = $tablaMovimientos->select()->from($tablaMovimientos)->where("idProyecto=?",$idProyecto);
	    $rowsMovimientos = $tablaMovimientos->fetchAll($select);
	    foreach ($rowsMovimientos as $rowMovimiento) {
	        if($rowMovimiento['idTipoMovimiento'] == 13 ){/*cliente*/
	            $tablaMovimientos = $this->tablaMovimiento;
	            $select  = $tablaMovimientos->select()
	            ->setIntegrityCheck(false)
	            ->from($tablaMovimientos)
	            ->join('Clientes','Movimientos.idCoP = Clientes.idCliente', array('idEmpresa'))
	            ->join('Empresa','Clientes.idEmpresa = Empresa.idEmpresa')
	            ->join('Fiscales','Empresa.idFiscales = Fiscales.idFiscales',  array('razonSocial'))
	            ->where('Movimientos.estatus =?','A')
	            ->where('Movimientos.fecha >= ?',$fechaI)->where('Movimientos.fecha <=?',$fechaF)
	            ->where('Movimientos.idProyecto =?', $idProyecto)->order('Movimientos.idTipoMovimiento')->order("Movimientos.numeroFolio ASC");
	            //print_r("$select");
	            return $tablaMovimientos->fetchAll($select);
	        }
	    }
	}
	
	public function obtieneProyectoRemisionClienteCafePxFecha($idProyecto,$fechaI, $fechaF){
	    $tablaMovimientos  = $this->tablaMovimiento;
	    $select = $tablaMovimientos->select()->from($tablaMovimientos)->where("idProyecto=?",$idProyecto);
	    $rowsMovimientos = $tablaMovimientos->fetchAll($select);
	    foreach ($rowsMovimientos as $rowMovimiento) {
	        if($rowMovimiento['idTipoMovimiento'] == 13 ){/*cliente*/
	            $tablaMovimientos = $this->tablaMovimiento;
	            $select  = $tablaMovimientos->select()
	            ->setIntegrityCheck(false)
	            ->from($tablaMovimientos)
	            ->join('Clientes','Movimientos.idCoP = Clientes.idCliente', array('idEmpresa'))
	            ->join('Empresa','Clientes.idEmpresa = Empresa.idEmpresa')
	            ->join('Fiscales','Empresa.idFiscales = Fiscales.idFiscales',  array('razonSocial'))
	            ->where('Movimientos.estatus =?','P')
	            ->where('Movimientos.fecha >= ?',$fechaI)->where('Movimientos.fecha <=?',$fechaF)
	            ->where('Movimientos.idProyecto =?', $idProyecto)->order('Movimientos.idTipoMovimiento')->order("Movimientos.numeroFolio ASC");
	            //print_r("$select");
	            return $tablaMovimientos->fetchAll($select);
	        }
	    }
	}
}