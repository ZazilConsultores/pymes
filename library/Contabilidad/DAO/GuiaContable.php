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
		$dbAdapter->insert("Modulos", array("descripcion"=>$datos["descripcion"]));
	}
	
	public function altaTipoProvedor(array $tipoProveedor){
		$tablaTipoProveedor = $this->tablaTipoProveedores;
		$tablaTipoProveedor->insert( array("clave"=>$tipoProveedor["clave"], "descripcion"=>$tipoProveedor["descripcionTipoProveedor"] ));
		
	}
	
	public function obtenerModulo($idModulo){
		
	}
	public function obtenerModulos(){
		$tablaModulo = $this->tablaModulos;
		$rowModulos = $tablaModulo->fetchAll();
		
		if(is_null($rowModulos)){
			return null;
		}else{
			return $rowModulos->toArray();
		}
		
	}
	public function editarModulo(){
		
	}
	public function altaCuentaGuia(Contabilidad_Model_GuiaContable $cta, $subparametro){
	
		$tablaGuiaContable = $this->tablaGuiaContable;
		$guiacontable->setFechaCaptura(date("Y-m-d H:i:s", time()));
		$tablaGuiaContable->insert($guiacontable->toArray());
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
	public function editarCuentaGuia(){
		
	}
	
 }