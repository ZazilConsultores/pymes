<?php

class Sistema_DAO_Subparametro implements Sistema_Interfaces_ISubparametro {
	
	private $tablaSubparametro;
	private $tablaParametro;
	private $tablaProducto;
	
	function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		
		$this->tablaSubparametro = new Sistema_Model_DbTable_Subparametro(array('db'=>$dbAdapter));
		$this->tablaParametro = new Sistema_Model_DbTable_Parametro(array('db'=>$dbAdapter));
		$this->tablaProducto = new Inventario_Model_DbTable_Producto(array('db'=>$dbAdapter));
	}
	
	public function generarClaveProducto(array $claves){
		//print_r($claves);
		$tablaSubparametro= $this->tablaSubparametro;
		$claveProducto = "";
		$idsSubparametro = "";
			
		foreach ($claves as $idParametro => $idSubparametro) {
			if($idSubparametro <> "0"){
				$sub = $this->obtenerSubparametro($idSubparametro);
				$claveProducto .= $sub->getClaveSubparametro();
				$idsSubparametro .=  $sub->getIdSubparametro() . ",";
			}
		}
		
		//print_r($claveProducto);
		//print_r("<br />");
		//print_r($idsSubparametro);
		
		return $claveProducto;
	}
	
	
	public function generarIdsSubparametros(array $claves)
	{
		
		$tablaSubparametro= $this->tablaSubparametro;
		$claveProducto = "";
		$idsSubparametro = "";
		
		foreach ($claves as $idParametro => $idSubparametro) {
			if($idSubparametro <> "0"){
				$sub = $this->obtenerSubparametro($idSubparametro);
				$claveProducto .= $sub->getClaveSubparametro();
				$idsSubparametro .=  $sub->getIdSubparametro() . ",";
			}
		}
		
		return $idsSubparametro;
		
	}
		
	public function obtenerSubparametros($idParametro)
	{
		$tablaSubparametro= $this->tablaSubparametro;
		//$where = $tablaSubparametro->getAdapter()->quoteInto("idParametro = ?", $idparametro);
		$select = $tablaSubparametro->select()->from($tablaSubparametro)->where("idParametro=?",$idParametro)->order("subparametro");
		$rowsSubParametro = $tablaSubparametro->fetchAll($select);
		
		$modelSubParametros = array();
		
		foreach ($rowsSubParametro as $rowSubParametro) {
			$modelSubParametro = new Sistema_Model_Subparametro($rowSubParametro->toArray());
			
			$modelSubParametros[]= $modelSubParametro;
			}
		
		return $modelSubParametros;
		
	}
	
	public function obtenerSubparametro($idSubparametro)
	{
		$tablaSubparametro = $this->tablaSubparametro;
		$select = $tablaSubparametro->select()->from($tablaSubparametro)->where("idSubparametro = ?", $idSubparametro);
		$rowSubparametro = $tablaSubparametro->fetchRow($select);
		
		$subparametroModel = new Sistema_Model_Subparametro($rowSubparametro->toArray());
		$subparametroModel->setIdSubparametro($rowSubparametro->idSubparametro);
		
		return $subparametroModel;
		
	}

	public function crearSubparametro(Sistema_Model_Subparametro $subparametro)
	{
		$tablasubparametro = $this->tablaSubparametro;
		$select = $tablasubparametro->select()->from($tablasubparametro)->where( "claveSubparametro = ? ", $subparametro->getClaveSubparametro())->where( "idParametro = ? ", $subparametro->getIdParametro());
		$row = $tablasubparametro->fetchRow($select);
		//print_r("$select");
		if(!is_null($row)){
		    echo ("Subparámetro: <strong>" . $subparametro->getSubparametro() . "</strong> duplicado en el sistema"); 
		}else{
		    $subparametro->setFecha(date("Y-m-d H:i:s", time()));
		    $tablasubparametro->insert($subparametro->toArray());
		}
		
		
	}
	 
	public function editarSubparametro($idSubparametro, array $subParametro)
	{
		$tablaSubparametro = $this->tablaSubparametro;
		$where = $tablaSubparametro->getAdapter()->quoteInto("idSubparametro = ?", $idSubparametro);
		$tablaSubparametro->update($subParametro, $where);
	}
	
	public function obtenerSubparametroBebida() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '4,56%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	
	public function obtenerSubparametroPT() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '5,68%')
		->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}	
	
	public function obtenerSubparametroAbarrotes() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '4,58%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	
	public function obtenerSubparametroDesechable() //Solo subparametro 3
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '3,58%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	
	public function obtenerSubparametroCarnes() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '4,59%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	
	public function obtenerSubparametroFrutas() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '4,60%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}	
	
	public function obtenerSubparametroLacteos() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '4,61%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	public function obtenerSubparametroLicores() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '4,62%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	public function obtenerSubparametroPanaderia() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '4,63%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	
	public function obtenerSubparametroPescadosyMa() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '4,64%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	public function obtenerSubparametroSemillas() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '4,65%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	
	public function obtenerSubparametroVerduras() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '4,66%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	public function obtenerSubparametroDulceria() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '4,67%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	public function obtenerPT() //Solo subparametro 2
	{
		$tablaProducto = $this->tablaProducto;
		$select = $tablaProducto->select()->from($tablaProducto)->where("idsSubparametros LIKE ?", '5,%')->order("producto");
		$rowSubparametro = $tablaProducto->fetchAll($select);
	
		//print_r($select->__toString());
		return $rowSubparametro;
		
	}
	
	public function obtenerSubparametroProducto ($idProducto)
	{
	    /*$tablaPr= $this->tablaSubparametro;
	    $claveProducto = "";
	    $idsSubparametro = "";
	    
	    foreach ($claves as $idParametro => $idSubparametro) {
	        if($idSubparametro <> "0"){
	            $sub = $this->obtenerSubparametro($idSubparametro);
	            $claveProducto .= $sub->getClaveSubparametro();
	            $idsSubparametro .=  $sub->getIdSubparametro() . ",";
	        }
	    }
	    
	    return $idsSubparametro;*/
	    $tablaPr = $this->tablaProducto;
	    $tablaSu = $this->tablaSubparametro;
	    
	    $select = $tablaPr->select()->from($tablaPr)->where('idProducto = ?', $idProducto);
	    $rowProducto = $tablaPr->fetchRow($select);
	    $claveProducto = "";
	    if(!is_null($rowProducto)){
	       
	        $idsSub = explode(",", $rowProducto->idsSubparametros);
	       
	        $select = $tablaSu->select()->from($tablaSu)->where("idSubparametro IN (?)", $idsSub);
	        $rowsSub = $tablaSu->fetchAll($select);
	        foreach ($rowsSub as $rowSub ) {
	           
	            //$claveProducto .= $rowSub->getClaveSubparametro();
	            //$idsSubparametro .=  $rowSub->getIdSubparametro() . ",";
	        }
	    }
	    return $claveProducto;
	}
}

