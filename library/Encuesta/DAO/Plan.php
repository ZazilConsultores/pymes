<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Plan implements Encuesta_Interfaces_IPlan {
	
	private $tablaPlanEstudios;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodencuesta');
		
		$this->tablaPlanEstudios = new Encuesta_Model_DbTable_PlanEducativo(array('db'=>$dbAdapter));
	}
	
	// =====================================================================================>>>   Buscar
	public function obtenerPlanEstudios($idPlan){
		$tablaPlan = $this->tablaPlanEstudios;
		$select = $tablaPlan->select()->from($tablaPlan)->where("idPlanEducativo=?",$idPlan);
		$plan = $tablaPlan->fetchRow($select);
		return $plan->toArray();
	}
	
	public function obtenerPlanEstudiosVigente(){
		$tablaPlan = $this->tablaPlanEstudios;
		$select = $tablaPlan->select()->from($tablaPlan)->where("vigente=?","1");
		$rowPlan = $tablaPlan->fetchRow($select);
		
		if(is_null($rowPlan)){
			throw new Util_Exception_BussinessException("Error: No hay plan de estudios vigente, seleccione un plan de estudios como vigente");
		}
		
		return $rowPlan->toArray();
	}
	
	public function obtenerPlanesDeEstudio(){
		$tablaPlan = $this->tablaPlanEstudios;
		$planes = $tablaPlan->fetchAll();
		return $planes->toArray();
	}
	// =====================================================================================>>>   Insertar
	/**
	 * Inserta un nuevo plan de estudios en el modulo encuesta
	 */
	public function agregarPlanEstudios(array $plan){
		$tablaPlan = $this->tablaPlanEstudios;
		try{
			$tablaPlan->insert($plan);
		}catch(Exception $ex){
			throw new Util_Exception_BussinessException("Error: Problema al agregar nuevo plan de estudios. <br />" . $ex->getMessage());
		}
	}
	// =====================================================================================>>>   Actualizar
	public function actualizarPlanEstudios($idPlan, $datos){
		$tablaPlan = $this->tablaPlanEstudios;
		$where = $tablaPlan->getAdapter()->quoteInto("idPlanEducativo=?", $idPlan);
		$tablaPlan->update($datos, $where);
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarPlanEstudios($idPlan){
		$tablaPlan = $this->tablaPlanEstudios;
		$where = $tablaPlan->getAdapter()->quoteInto("idPlanEducativo=?", $idPlan);
		$tablaPlan->delete($where);
	}
}
