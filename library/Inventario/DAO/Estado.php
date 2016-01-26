<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Estado implements Inventario_Interfaces_IEstado {
	private $tablaEstado;
	
	public function __construct()
	{
		$this->tablaEstado = new Sistema_Model_DbTable_Estado;
	}
	
	public function obtenerEstado($idEstado){
		$tablaEstado = $this->tablaEstado;
		$select = $tablaEstado->select()->from($tablaEstado)->where("idEstado = ?", $idEstado);
		$rowEstado = $tablaEstado->fetchRow($select);
		
		$estadoModel = new Sistema_Model_Estado($rowEstado->toArray());
		$estadoModel->setIdEstado($rowEstado->idEstado);
		
		return $estadoModel;
	}
	
	public function obtenerEstados(){
		$tablaEstado = $this->tablaEstado;
		$rowEstados = $tablaEstado->fetchAll();
		
		$modelEstados = array();
		
		foreach ($rowEstados as $rowEstado) {
			$modelEstado = new Sistema_Model_Estado($rowEstado->toArray());
			$modelEstado->setIdEstado($rowEstado->idEstado);
			
			$modelEstados[] = $modelEstado;
		}
		
		return $modelEstados;
	}
	
	public function obtenerMunicipios($idEstado){}
	
	public function crearEstado(Sistema_Model_Estado $estado){
		$tablaEstado = $this->tablaEstado;
		$tablaEstado->insert($estado->toArray());
	}
	
	public function editarEstado($idEstado, Sistema_Model_Estado $estado){
		$tablaEstado = $this->tablaEstado;
		$where = $tablaEstado->getAdapter()->quoteInto("idEstado = ?", $idEstado);
		//$select = $tablaEstado->select()->from($tablaEstado)->where("idEstado = ?", $idEstado);
		
		$tablaEstado->update($estado->toArray(), $where);
	}
	
	public function eliminarEstado($idEstado){
		$tablaEstado = $this->tablaEstado;
		$where = $tablaEstado->getAdapter()->quoteInto("idEstado = ?", $idEstado);
		//$select = $tablaEstado->select()->from($tablaEstado)->where("idEstado = ?", $idEstado);
		
		$tablaEstado->delete($where);
	}
}
