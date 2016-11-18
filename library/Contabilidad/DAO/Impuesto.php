<?php
   class Contabilidad_DAO_Impuesto implements Contabilidad_Interfaces_IImpuesto{
   	private $tablaImpuesto;
	
	function __construct(){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaImpuesto = new Contabilidad_Model_DbTable_Impuesto(array('db'=>$dbAdapter));	
	}
	
	public function obtenerImpuestos()
	{
		$tablaImpuestos = $this->tablaImpuesto;
		$select = $tablaImpuestos->select()->from($tablaImpuestos)->order("abreviatura");
		$rowImpuestos = $tablaImpuestos->fetchAll($select);
		
		$modelImpuestos = array();
		foreach($rowImpuestos as $rowImpuesto){
			$modelImpuesto = new Contabilidad_Model_Impuesto($rowImpuesto->toArray());
			$modelImpuesto->setIdImpuesto($rowImpuesto->idImpuesto);
			$modelImpuestos[] = $modelImpuesto;
		}
		return $modelImpuestos;
		
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
   }
?>