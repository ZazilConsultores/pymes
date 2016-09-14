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
		$select = $tablaPlan->select()->from($tablaPlan)->where("idPlanE=?",$idPlan);
		$plan = $tablaPlan->fetchRow($select);
		return $plan->toArray();
	}
	
	public function obtenerPlanEstudiosHash($hash){
		$tablaPlan = $this->tablaPlanEstudios;
		$select = $tablaPlan->select()->from($tablaPlan)->where("hash=?",$hash);
		$row = $tablaPlan->fetchRow($select);
		
		return $row;
	}
	
	public function obtenerPlanEstudiosVigente(){
		$tablaPlan = $this->tablaPlanEstudios;
		$select = $tablaPlan->select()->from($tablaPlan)->where("vigente=?","1");
		$plan = $tablaPlan->fetchRow($select);
		if(is_null($plan)){
			throw new Util_Exception_BussinessException("Error: No hay plan de estudios vigente, seleccione un plan de estudios como vigente");
		}
		return $plan->toArray();
	}
	
	public function obtenerPlanesDeEstudio(){
		$tablaPlan = $this->tablaPlanEstudios;
		$planes = $tablaPlan->fetchAll();
		return $planes->toArray();
	}
	// =====================================================================================>>>   Insertar
	public function agregarPlanEstudios($plan){
		$obj = $this->obtenerPlanEstudiosHash($plan["hash"]);
		if(!is_null($obj)){
			throw new Util_Exception_BussinessException("Error: Plan de estudios <strong>".$plan["plan"]."</strong> ya esta en el sistema");
		}else{
			$tablaPlan = $this->tablaPlanEstudios;
			try{
				$tablaPlan->insert($plan);
			}catch(Exception $ex){
				throw new Util_Exception_BussinessException("Error: Problema al agregar nuevo plan de estudios. <br />" . $ex->getMessage());
			}
		}
		
		
	}
	// =====================================================================================>>>   Actualizar
	public function actualizarPlanEstudios($idPlan, $datos){
		$tablaPlan = $this->tablaPlanEstudios;
		$where = $tablaPlan->getAdapter()->quoteInto("idPlan=?", $idPlan);
		$tablaPlan->update($datos, $where);
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarPlanEstudios($idPlan){
		$tablaPlan = $this->tablaPlanEstudios;
		$where = $tablaPlan->getAdapter()->quoteInto("idPlan=?", $idPlan);
		$tablaPlan->delete($where);
	}
}
