<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
 class Contabilidad_DAO_GuiaContable implements Contabilidad_Interfaces_IGuiaContable {
 

	private $tablaGuiaContable;
	private $tablaModulos;
	private $tablaTipoProveedores;
	
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaGuiaContable = new Contabilidad_Model_DbTable_GuiaContable(array('db'=>$dbAdapter));
		$this->tablaModulos = new Contabilidad_Model_DbTable_Modulos(array('db'=>$dbAdapter));
		$this->tablaTipoProveedores = new Sistema_Model_DbTable_TipoProveedor(array('db'=>$dbAdapter));
		
	}	
	
	public function altaModulo($datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		try{
   			$tablaModulos =$this->tablaModulos;
   			$select = $tablaModulos->select()->from($tablaModulos)->where("descripcion=?", $datos['descripcion']);
			$rowModulo = $tablaModulos->fetchRow($select);
			if(count($rowModulo) >= 1) {
				throw new Exception("Error: Módulo <strong>".$datos["descripcion"]."</strong> ya esta dado de alta en el sistema");				
			}else{
				$dbAdapter->insert("Modulos", array("descripcion"=>$datos["descripcion"]));
			}
		}catch(Exception $ex){
			print_r($ex->getMessage());
			$dbAdapter->rollBack();		
		}
	}
	
	public function altaTipoProvedor($tipo){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		try{
   			$tablaTipo = $this->tablaTipoProveedores;
   			$select = $tablaTipo->select()->from($tablaTipo)->where("descripcion=?", $tipo['descripcion'])->orWhere("clave=?", $tipo['cta']);
			$rowTipo = $tablaTipo->fetchRow($select);
			//print_r("$select");
			if(count($rowTipo) >= 1) {
				throw new Exception("Error: Tipo <strong>".$tipo["descripcion"]."</strong> ya esta dado de alta en el sistema");				
			}else{
				$dbAdapter->insert("TipoProveedor", array("clave"=>$tipo["cta"],"descripcion"=>$tipo["descripcion"]));
			}
		}catch(Exception $ex){
			print_r($ex->getMessage());
			$dbAdapter->rollBack();		
		}
		
	}
	
	public function obtenerModulo($idModulo){
		$tablaModulo = $this->tablaModulos;
		$select = $tablaModulo->select()->from($tablaModulo)->where("idModulo = ?",$idModulo);
		$rowModulo = $tablaModulo->fetchRow($select);
		//print("$select");
		/*$moduloModel = new Contabilidad_Model_Modulos($rowModulo->toArray());
		$moduloModel->setIdModulo($rowModulo->idModulo);
		*/
		return $rowModulo;
		
	}
	
	public function obtenerModulos(){
		$tablaModulo = $this->tablaModulos;
		$select = $tablaModulo->select()->from($tablaModulo);
		$rowModulos = $tablaModulo->fetchAll($select);
		
		$modelModulos = array();
		foreach ($rowModulos as $rowModulo) {
			$modelModulo = new  Contabilidad_Model_Modulos($rowModulo->toArray());
			$modelModulo->setIdModulo($rowModulo->idModulo);
			
			$modelModulos[] = $modelModulo;
		}
		
		return $modelModulos;	
	}
	
	public function obtenerTipos(){
		$tablaTipos = $this->tablaTipoProveedores;
		$select = $tablaTipos->select()->from($tablaTipos);
		$rowTipos = $tablaTipos->fetchAll($select);
		
		$modelTipos = array();
		foreach ($rowTipos as $rowTipo) {
			$modelTipo = new  Sistema_Model_TipoProveedor($rowTipo->toArray());
			$modelTipo->setIdTipoProveedor($rowTipo->idTipoProveedor);
			
			$modelTipos[] = $modelTipo;
		}
		
		return $modelTipos;	
	}
	
	public function editarModulo($idModulo, $modulo){
		$tablaModulo = $this->tablaModulos;
		$select = $tablaModulo->select()->from($tablaModulo)->where("idModulo=?",$idModulo);
		$rowModulo = $tablaModulo->fetchRow($select);	
		if(!is_null($rowModulo)){
			$rowModulo->descripcion = $modulo["descripcion"];
			$rowModulo->save();	
		}
		
	}
	public function altaCuentaGuia(array $cta, $subparametro){
		/*$tablaGuiaContable = $this->tablaGuiaContable;
		$guiacontable->setFechaCaptura(date("Y-m-d H:i:s", time()));
		$tablaGuiaContable->insert($guiacontable->toArray());*/
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		//$dbAdapter->beginTransaction();
		try{
			
		$mGuiaContable = array(
			'idModulo'=>$subparametro['idModulo'],
			'idTipoProveedor'=>$subparametro['idTipoProveedor'],
			'cta'=>$cta['cta'],
			'sub1'=>$cta['sub1'],
			'sub2'=>$cta['sub2'],
			'sub3'=>$cta['sub3'],
			'sub4'=>$cta['sub4'],
			'sub5'=>$cta['sub5'],
			'origen'=>$subparametro['origen'],
			'descripcion'=>$cta['descripcion'],
			'cargo'=>$subparametro['cargo'],
			'abono'=>$subparametro['abono'],
			'fechaCaptura'=>date("Y-m-d H:i:s", time())
		);
		print_r($mGuiaContable);
		$dbAdapter->insert("GuiaContable", $mGuiaContable);
		}catch(Exception $ex){
			$dbAdapter->rollBack();
			print_r($ex->getMessage());
			throw new Util_Exception_BussinessException("Error: La cuenta ya registrada en el sistema");
			
		}
	}
	
	public function obtenerCuentasGuia(){
		$tablaGuiaConta = $this->tablaGuiaContable;
		$rowsGuiaContable = $tablaGuiaConta->fetchAll();
		
		$modelsGuiaContable = array();
		foreach($rowsGuiaContable as $rowGuiaContable){
			$modelGuiaContable = new Contabilidad_Model_GuiaContable($rowGuiaContable->toArray());
			$modelGuiaContable->setIdGuiaContable($rowGuiaContable->idGuiaContable);
			$modelsGuiaContable [] = $modelGuiaContable;		
		}
		return $modelsGuiaContable;
	}
	
	public function obtieneCuentaGuia($idGuiaContable){
		$tablaGuiaContable = $this->tablaGuiaContable;
		$select = $tablaGuiaContable->select()->from($tablaGuiaContable)->where("idGuiaContable=?",$idGuiaContable);
		$rowGuiaContable = $tablaGuiaContable->fetchRow($select);
		//print_r("$select");
		if(is_null($rowGuiaContable)){
			return null;
		}else{
			return $rowGuiaContable->toArray();
		}
	}
	
	public function actualizarGuiaContable($idGuiaContable, $datos) {
		$tablaGuiaContable = $this->tablaGuiaContable;
		$where = $tablaGuiaContable->getAdapter()->quoteInto("idGuiaContable=?", $idGuiaContable);
		$tablaGuiaContable->update($datos, $where);
	}
 }