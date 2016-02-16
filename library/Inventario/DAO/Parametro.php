<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Parametro implements Inventario_Interfaces_IParametro{
	private $tablaParametro;
	private $tablaSubparametro;
	
	public function __construct()
	{
		$this->tablaParametro = new Sistema_Model_DbTable_Parametro;
		$this->tablaSubparametro = new Sistema_Model_DbTable_Subparametro;
	}
	
	public function obtenerParametro($idParametro){
		$tablaParametro = $this->tablaParametro;
		$select = $tablaParametro->select()->from($tablaParametro)->where("idParametro = ?", $idParametro);
		$rowParametro = $tablaParametro->fetchRow($select);
		$modelParametro = new Sistema_Model_Parametro($rowParametro->toArray());
		
		return $modelParametro;
	}
	
	public function obtenerParametros(){
		$tablaParametro = $this->tablaParametro;
		$rowsParametros = $tablaParametro->fetchAll();
		
		$modelParametros = array();
		foreach ($rowsParametros as $row) {
			$modelParametro = new Sistema_Model_Parametro($row->toArray());
			$modelParametros[] = $modelParametro;
		}
		
		return $modelParametros;
	}
	
	public function obtenerSubparametros($idParametro){
		$tablaSubparametro = $this->tablaSubparametro;
		$select = $tablaSubparametro->select()->from($tablaSubparametro)->where("idParametro = ?", $idParametro);
		$rowsSubparametros = $tablaSubparametro->fetchAll($select);
		
		$modelSubparametros = array();
		foreach ($rowsSubparametros as $row) {
			$modelSubparametro = new Sistema_Model_Subparametro($row->toArray());
			$modelSubparametros[] = $modelSubparametro;
		}
		
		return $modelSubparametros;
	}
	
	public function crearParametro(Sistema_Model_Parametro $parametro){
		$tablaParametro = $this->tablaParametro;
		$select = $tablaParametro->select()->from($tablaParametro)->where("hash = ?", $parametro->getHash());
		$row = $tablaParametro->fetchRow($select);
		
		if(!is_null($row)) throw new Util_Exception_BussinessException("Parámetro: <strong>" . $parametro->getParametro() . "</strong> duplicado en el sistema");
		$parametro->setHash($parametro->getHash());
		$parametro->setFecha(date("Y-m-d H:i:s", time()));
		$tablaParametro->insert($parametro->toArray());
	}
	
	public function editarParametro($idParametro, array $parametro){
		$tablaParametro = $this->tablaParametro;
		$where = $tablaParametro->getAdapter()->quoteInto("idParametro = ?", $idParametro);
		$tablaParametro->update($parametro, $where);
	}
}
