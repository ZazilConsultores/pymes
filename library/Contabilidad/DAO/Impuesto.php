<?php
   class Contabilidad_DAO_Impuesto implements Contabilidad_Interfaces_IImpuesto{
   	private $tablaImpuesto;
	private $tablaImpuestoProductos;
	private $tablaProducto;
	
	function __construct(){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaImpuesto = new Contabilidad_Model_DbTable_Impuesto(array('db'=>$dbAdapter));
		$this->tablaImpuestoProductos = new Contabilidad_Model_DbTable_ImpuestoProductos(array('db'=>$dbAdapter));
		$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
	}
	
	public function obtenerImpuestos()
	{
		$tablaImpuesto = $this->tablaImpuesto;
		$select = $tablaImpuesto->select()->from($tablaImpuesto)->order("abreviatura");
		$rowImpuestos = $tablaImpuesto->fetchAll($select);
		$modelImpuestos = array();
		foreach($rowImpuestos as $rowImpuesto){
			$modelImpuesto = new Contabilidad_Model_Impuesto($rowImpuesto->toArray());
			$modelImpuesto->setIdImpuesto($rowImpuesto->idImpuesto);
			
			$modelImpuestos[] = $modelImpuesto;
			
		}
		return $modelImpuestos;
		
		/*if (is_null($rowImpuestos)) {
			return null;
		}else{
			return $rowImpuestos->toArray();
		}*/

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
	
   	public function nuevoImpuesto(array $datos){
   		$dbAdapter =  Zend_Registry::get('dbmodgeneral');
		//$dbAdapter->beginTransaction();
		try{
   			$tablaImpuesto =$this->tablaImpuesto;
   			$select = $tablaImpuesto->select()->from($tablaImpuesto)->where("Abreviatura=?", $datos['abreviatura']);
			$rowImpuestos = $tablaImpuesto->fetchAll($select);
			if(count($rowImpuestos) >= 1) {
				throw new Exception("Error: <strong>".$datos["abreviatura"]."</strong> ya esta dado de alta en el sistema");				
			}else{
				$dbAdapter->insert("Impuesto", $datos);
			}
		}catch(Exception $ex){
			print_r($ex->getMessage());
			$dbAdapter->rollBack();
			throw new Exception("Error el Impuesto ya existe");		
		}	
   	}
	
	public function editarImpuesto($idImpuesto, array $impuesto)
	{
		$tablaImpuesto = $this->tablaImpuesto;
		$where = $tablaImpuesto->getAdapter()->quoteInto("idImpuesto = ?", $idImpuesto);
		$tablaImpuesto->update($impuesto, $where);
		//print_r("$tablaImpuesto");
	}
	
	public function obtenerImpuestoProductos($idImpuesto) {
		
		$tablaImpuestoProductos = $this->tablaImpuestoProductos;
		$select = $tablaImpuestoProductos->select()->from($tablaImpuestoProductos)->where ("idImpuesto = ?", $idImpuesto);
		$rowImpuestoProductos = $tablaImpuestoProductos->fetchAll($select);
		//print_r("$select");
		$idsProducto = array();
		
		foreach ($rowImpuestoProductos as $rowProducto) {
			$idsProducto[] = $rowProducto->idProducto;
			
		}
		
		if(!is_null($rowImpuestoProductos) && ! empty($idsProducto)){
			//Obtenemos los productos
			$tablaImpuestoProductos =$this->tablaImpuestoProductos;
			$select = $tablaImpuestoProductos->select()
			->setIntegrityCheck(false)
			->from($tablaImpuestoProductos, array('idProducto','idImpuestoProducto','idImpuesto','importe','porcentaje'))
			->join('Producto', 'ImpuestoProductos.idProducto = Producto.idProducto', array('producto'))
			->join('Impuesto', 'ImpuestoProductos.idImpuesto = Impuesto.idImpuesto', array('descripcion'));
			return $tablaImpuestoProductos->fetchAll($select);
			
		}
		
		}
		 			
		public function obtenerByImpuestos($idImpuesto){
		$tablaImpuesto = $this->tablaImpuesto;
		$select = $tablaImpuesto->select()->from($tablaImpuesto)->where("idImpuesto=?",$idImpuesto);
		$rowImpuesto = $tablaImpuesto->fetchRow($select);

		return $rowImpuesto->toArray();
		
	}
		public function obtenerByProductos($idProducto){
			$tablaProducto = $this->tablaProducto;
			$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto=?",$idProducto);
			$rowProducto = $tablaProducto->fetchRow($select);
			return $rowProducto->toArray();
		}
		
		//public function enlazarProductoImpuesto($idImpuesto, $idProducto, $importe, $porcentaje){
			//Sistema_Model_Subparametro $subparametro
			public function enlazarProductoImpuesto(Contabilidad_Model_ImpuestoProductos $impuestoProducto, $idImpuesto, $idProducto){	
			$tablaImpuestoProducto = $this->tablaImpuestoProductos;
			$select = $tablaImpuestoProducto->select()->from($tablaImpuestoProducto)->where("idImpuesto =?",$idImpuesto)
			->where("idProducto = ?", $idProducto);
			$rowImpuestoProducto = $tablaImpuestoProducto->fetchRow($select);
		
			if(is_null($rowImpuestoProducto)){
				//$tablaImpuestoProducto->insert(array("idImpuesto"=>$idImpuesto,"idProducto"=>$idProducto));
				$tablaImpuestoProducto->insert($impuestoProducto->toArray());
			}else{
				echo "El producto ya existe";
			}
		}
		
		public function obtenerImpuestoProducto($idProducto){
			$tablaImpuestoProductos = $this->tablaImpuestoProductos;
			$select = $tablaImpuestoProductos->select()->from($tablaImpuestoProductos)->where("idProducto = ?", $idProducto);
			//$rowImpuestoProductos = $tablaImpuestoProductos->fetchAll($select);
			
			//if (is_null($rowImpuestoProductos)) {
				//return null;
			//}else{
				return $rowImpuestoProductos = $tablaImpuestoProductos->fetchAll($select);
			//}
		}
	
	public function eliminarImpuestoProducto($idImpuestoProducto){
		$tablaImpuestoProductos = $this->tablaImpuestoProductos;
		$where = $tablaImpuestoProductos->getAdapter()->quoteInto("idImpuestoProducto = ?", $idImpuestoProducto);
		//print_r("$where");
		$tablaImpuestoProductos->delete($where);
	}
	
	
}
?>