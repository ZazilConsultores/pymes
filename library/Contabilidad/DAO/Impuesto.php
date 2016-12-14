<?php
   class Contabilidad_DAO_Impuesto implements Contabilidad_Interfaces_IImpuesto{
   	private $tablaImpuesto;
	private $tablaImpuestoProductos;
	private $tablaProducto;
	
	function __construct(){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaImpuesto = new Contabilidad_Model_DbTable_Impuesto(array('db'=>$dbAdapter));
		$this->tablaImpuestoProductos = new Contabilidad_Model_DbTable_ImpuestoProductos(array('db'=>$dbAdapter));
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
	
	public function obtenerImpuestoProductos($idImpuesto) {
		// Obtenemos el IdImpuesto 
		$tablaImpuesto = $this->tablaImpuesto;
		$select = $tablaImpuesto->select()->from($tablaImpuesto)->where("idImpuesto=?",$idImpuesto);
		$rowsImporte = $tablaImpuesto->fetchRow($select);
		
		//Obtenemos todos los ids de los Productos en la tabla impuestoProducto
		
		$tablaImpuestoProductos = $this->tablaImpuestoProductos;
		$select = $tablaImpuestoProductos->select()->from($tablaImpuestoProductos)->where ("idImpuesto = ?", $rowsImporte->idImpuesto);
		$rowImpuestoProductos = $tablaImpuestoProductos->fetchAll($select);
		
		$idsImpuesto = array();
		foreach ($rowImpuestoProductos as $rowProducto) {
			$idsImpuesto[] = $rowProducto->idImpuesto;
	
		//print_r($idsImpuesto);
		if(!is_null($rowImpuestoProductos)){
			//Obtenemos todos los productos
			
			$tablaProducto =$this->tablaProducto;
			$select = $tablaProducto->select()->from($tablaProducto)->where("idProducto = ?", $rowProducto->idProducto);
			$rowProductos = $tablaProducto->fetchAll($select);
			print_r("$select");
			$idProducto = array();
			
			foreach($rowProductos as $row){
				$idProducto[]= $row->idProducto;
				}
			}
		}
		if (is_null($idProducto)) {
				return NULL;
			}else{
				return $idProducto;
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
		
		public function enlazarProductoImpuesto($idImpuesto, $idProducto, $importe, $porcentaje){
			print_r("El importe es:");
			print_r($importe);	
			$tablaImpuestoProducto = $this->tablaImpuestoProductos;
			$select = $tablaImpuestoProducto->select()->from($tablaImpuestoProducto)->where("idImpuesto =?",$idImpuesto)
			->where("idProducto = ?", $idProducto);
			$rowImpuestoProducto = $tablaImpuestoProducto->fetchRow($select);
			
			print_r("<br />");
			print_r("Consulta en ImpuestoProducto si el producto ya esta enlazado");
			print_r("<br />");
			if(!is_null($rowImpuestoProducto)){
				//$idsProductos = explode (",", $rowImpuestoProducto->idsProducto);
				$idProducto = $rowImpuestoProducto->idProducto;
				print_r("<br />");
				print_r("El id del producto es:");
				print_r("<br />");
				print_r($idProducto);
				if(($idProducto == $idProducto)){
					print_r("Ya existe el Producto");	
				}else{
					print_r("El producto debe agregarse");
					//$idProducto[] = $idProducto;
					//$id= implode(",", $idsProductos);
					//print_r(implode(",", $idsProductos));
					$where = $tablaImpuestoProducto->getDefaultAdapter()->quoteInto("idImpuesto", $idImpuesto);
					print_r($where);
					$tablaImpuestoProducto->update(array("idProducto"=>$idProducto), $where);
				}
				
			}else{
				$tablaImpuestoProducto->insert(array("idImpuesto"=>$idImpuesto,"idProducto"=>$idProducto));
			}
		}
   }
?>