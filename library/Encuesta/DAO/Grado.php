<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Grado implements Encuesta_Interfaces_IGrado {
	
	private $tablaGradoEducativo;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodencuesta');
		
		$this->tablaGradoEducativo = new Encuesta_Model_DbTable_GradoEducativo(array('db'=>$dbAdapter));
		//$this->tablaGradoEducativo->setDefaultAdapter($dbAdapter);
	}
	
	public function obtenerGrado($idGrado){
		$tablaGrado = $this->tablaGradoEducativo;
		$select = $tablaGrado->select()->from($tablaGrado)->where("idGradoEducativo = ?",$idGrado);
		$rowGrado = $tablaGrado->fetchRow($select);
		$modelGrado = new Encuesta_Model_Grado($rowGrado->toArray());
		
		return $modelGrado;
	}
	
	public function obtenerGrados($idNivel){
		$tablaGrado = $this->tablaGradoEducativo;
		$select = $tablaGrado->select()->from($tablaGrado)->where("idNivelEducativo = ?",$idNivel);
		$rowsGrados = $tablaGrado->fetchAll($select);
		$modelGrados = array();
		foreach ($rowsGrados as $row) {
			$modelGrado = new Encuesta_Model_Grado($row->toArray());
			$modelGrados[] = $modelGrado;
		}
		
		return $modelGrados;
	}
	
	public function crearGrado(Encuesta_Model_Grado $grado){
		$tablaGrado = $this->tablaGradoEducativo;
		try{
			$tablaGrado->insert($grado->toArray());
		}catch(Exception $ex){
			throw new Util_Exception_BussinessException("Grado: <strong>".$grado->getGrado()."</strong> no se puede dar de alta.<br /><br /><strong>" . $ex->getMessage() . "</strong>");
		}
	}
	
	public function editarGrado($idGrado, array $datos){
		$tablaGrado = $this->tablaGradoEducativo;
		$where = $tablaGrado->getAdapter()->quoteInto("idGrado=?", $idGrado);
		$tablaGrado->update($datos, $where);
	}
	
	public function eliminarGrado($idGrado){
		$tablaGrado = $this->tablaGradoEducativo;
		
	}
}
