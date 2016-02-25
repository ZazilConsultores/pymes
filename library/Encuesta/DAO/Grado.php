<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Grado implements Encuesta_Interfaces_IGrado {
	
	private $tablaGrado;
	
	public function __construct() {
		$this->tablaGrado = new Encuesta_Model_DbTable_GradoE;
		
	}
	
	public function obtenerGrados($idNivel){
		$tablaGrado = $this->tablaGrado;
		$select = $tablaGrado->select()->from($tablaGrado)->where("idNivel = ?",$idNivel);
		$rowsGrados = $tablaGrado->fetchAll($select);
		$modelGrados = array();
		foreach ($rowsGrados as $row) {
			$modelGrado = new Encuesta_Model_Grado($row->toArray());
			$modelGrados[] = $modelGrado;
		}
		
		return $modelGrados;
	}
	
	public function crearGrado(Encuesta_Model_Grado $grado){
		$tablaGrado = $this->tablaGrado;
		$grado->setHash($grado->getHash());
		$select = $tablaGrado->select()->from($tablaGrado)->where("hash = ?",$grado->getHash());
		$row = $tablaGrado->fetchRow($select);
		if(!is_null($row)) throw new Util_Exception_BussinessException("Grado: <strong>".$grado->getGrado()."</strong> no se puede dar de alta. <strong>Grado duplicado en el sistema</strong>\n");
		try{
			
			$tablaGrado->insert($grado->toArray());
		}catch(Exception $ex){
			throw new Util_Exception_BussinessException("Grado: <strong>".$grado->getGrado()."</strong> no se puede dar de alta.<br /><br /><strong>" . $ex->getMessage() . "</strong>");
		}
	}
	
	public function editarGrado($idGrado, array $datos){
		$tablaGrado = $this->tablaGrado;
		
	}
	
	public function eliminarGrado($idGrado){
		$tablaGrado = $this->tablaGrado;
		
	}
}
