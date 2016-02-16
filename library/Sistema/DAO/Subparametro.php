<?php

class Sistema_DAO_Subparametro implements Sistema_Interfaces_ISubparametro {
	
	private $tablaSubparametro;
	private $tablaParametro;
	
	function __construct()
	{

		$this->tablaSubparametro = new Sistema_Model_DbTable_Subparametro;
		$this->tablaParametro = new Sistema_Model_DbTable_Parametro;
	}
		
	public function obtenerSubparametros($idParametro)
	{
		$tablaSubparametro= $this->tablaSubparametro;
		$where = $tablaSubparametro->getAdapter()->quoteInto("idParametro = ?", $idParametro);
		$rowsSubParametro = $tablaSubparametro->fetchAll($where);
		
		$modelSubParametros = array();
		
		foreach ($rowsSubParametro as $rowSubParametro) {
			$modelSubParametro = new Sistema_Model_Subparametro($rowSubParametro->toArray());
			
			$modelSubParametros[]= $modelSubParametro;
			}
		
		return $modelSubParametros;
		
		
	}
	
	public function obtenerSubparametro($idParametro){
		$tablaSubparametro = $this->tablaSubparametro;
		$select = $tablaSubparametro->select()->from($tablaSubparametro)->where("idSubparametro = ?",$idSubparametro);
		$rowSubparametro = $tablaSubparametro->fetchRow($select);
		
		$subparametroModel = new Sistema_Model_Subparametro($rowSubparametro->toArray());
		$subparametroModel->setIdSubparametro($rowSubparametro->idSubparametro);
		
		return $subparametroModel;
		
	}
	public function crearSubparametro(Sistema_Model_Subparametro $subparametro)
	{
		$tablasubparametro = $this->tablaSubparametro;
		$select = $tablasubparametro->select()->from($tablasubparametro)->where( "hash = ? ", $subparametro->getHash());
		$row = $tablasubparametro->fetchRow($select);
		
		if(!is_null($row)) throw new Util_Exception_BussinessException("Subparámetro: <strong>" . $subparametro->getSubparametro() . "</strong> duplicado en el sistema");
		$subparametro->setHash($subparametro->getHash());
		$subparametro->setFecha(date("Y-m-d H:i:s", time()));
		$tablasubparametro->insert($subparametro->toArray());
		
	}
	public function editarSubparametro(Sistema_Model_Subparametro $idSubParametro)
	{
		
	}
		
	}

