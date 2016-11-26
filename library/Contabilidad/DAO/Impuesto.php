<?php
   class Contabilidad_DAO_Impuesto implements Contabilidad_Interfaces_IImpuesto{
   	private $tablaImpuesto;
	private $tablaImpuestoProductos;
	private $tablaProducto;
	
	function __construct(){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaImpuesto = new Contabilidad_Model_DbTable_Impuesto(array('db'=>$dbAdapter));
		$this->tablaImpuestoProductos = new Contabilidad_Model_DbTable_ImpuestoProductos;
		$this->tablaProducto = new Inventario_Model_DbTable_Producto;	
	}
	
	public function obtenerImpuestos()
	{
		$tablaImpuestos = $this->tablaImpuesto;
		$select = $tablaImpuestos->select()->from($tablaImpuestos)->order("abreviatura");
		$rowImpuestos = $tablaImpuestos->fetchAll($select);
		
		$impuestos = array();
		foreach($rowImpuestos as $rowImpuesto){
			//$modelImpuesto = new Contabilidad_Model_Impuesto($rowImpuesto->toArray());
			//$modelImpuesto->setIdImpuesto($rowImpuesto->idImpuesto);
			$idsImpuestos[] = $rowImpuesto->idImpuesto;
		}
		//return $modelImpuestos;
		
		if (is_null($rowImpuestos)) {
			return null;
		}else{
			return $rowImpuestos->toArray();
		}
		
		
	}
	public function obtenerImpuesto($idImpuesto)
	{
		$tablaImpuesto = $this->tablaImpuesto;
		$select = $tablaImpuesto->select()->from($tablaImpuesto)->where("idImpuesto = ?", $idImpuesto);
		$rowImpuesto = $tablaImpuesto->fetchRow($select);
		
		$impuestoModel = new Contabilidad_Model_Impuesto($rowImpuesto->toArray());
		$impuestoModel->setIdImpuesto($rowImpuesto->idImpuesto);
		return $impuestoModel;	
	}
	
   	public function nuevoImpuesto(Contabilidad_Model_Impuesto $impuesto){
   		$tablaImpuesto = $this->tablaImpuesto;
		$impuesto->setEstatus('A');
		$impuesto->setFechaPublicacion(date("Y-m-d H:i:s", time()));
   		//print_r($impuesto);
   		$tablaImpuesto->insert($impuesto->toArray());
   	}
	
	public function editarImpuesto($idImpuesto,array $datos)
	{
		$tablaImpuesto = $this->tablaImpuesto;
		$where = $tablaImpuesto->getAdapter()->quoteInto("idImpuesto = ?", $idImpuesto);
		$tablaImpuesto->update($datos, $where);
		
	}
	public function obtenerImpuetoProductos($idImpuesto) {
		// Obtenemos el IdImpuesto 
		$tablaImpuesto = $this->tablaImpuesto;
		$select = $tablaImpuesto->select()->from($tablaImpuesto)->where("idImpuesto=?",$idImpuesto);
		$rowImporte = $tablaImpuesto->fetchRow($select);
		
		if (is_null($rowImporte)) {
				return NULL;
			}else{
				return $rowImporte->toArray();
			}
		 
		 /*
		// Obtenemos todos los ids de Producto de la tabla impuestoProductos
		$tablaImpuestoProducto = $this->tablaImpuestoProductos;
		$select = $tablaImpuestoProducto->select()->from($tablaImpuestoProducto)->where("idImpuesto=?",$rowImporte->idImporte);
		//$rowsClientesEmpresa = $tablaClientesEmpresa->fetchAll($select);
		$rowImpuestoProductos = $tablaImpuestoProducto->fetchRow($select);
		
		$idsProductos = explode(",", $rowImpuestoProductos->idsProducto);
		
		// Si hay ids de Cliente
		
		if(! is_null($rowImpuestoProductos->idsProducto) && ! empty($idsProductos)) {
			 //Obtenemos todos los Productos //pero para que?
			$tablaProducto = $this->tablaProducto;
			$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto IN (?)", $idsProductos);
			$rowsProducto = $tablaProducto->fetchAll($select);
			
			$idsImpuesto = array();
			foreach ($rowsProducto as $rowProducto) {
				$idsImpuesto[] = $rowProducto->idProducto;
			}*/
			
			
		//}else{
			//return NULL;
		//}
	}
   }
?>