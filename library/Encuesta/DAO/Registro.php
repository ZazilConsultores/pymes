<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Registro implements Encuesta_Interfaces_IRegistro {
	
	private $tablaRegistro;
	
	function __construct() {
		$this->tablaRegistro = new Encuesta_Model_DbTable_Registro;
	}
	
	// =====================================================================================>>>   Buscar
	public function obtenerRegistro($idRegistro){
		$tablaRegistro = $this->tablaRegistro;
		$select = $tablaRegistro->select()->from($tablaRegistro)->where("idRegistro = ?", $idRegistro);
		$rowRegistro = $tablaRegistro->fetchRow($select);
		$modelRegistro = null;
		
		if(!is_null($rowRegistro)){
			$modelRegistro = new Encuesta_Model_Registro($rowRegistro->toArray());
		}
		
		return $modelRegistro;
	}
	
	public function obtenerRegistroReferencia($referencia){
		$tablaRegistro = $this->tablaRegistro;
		$select = $tablaRegistro->select()->from($tablaRegistro)->where("referencia = ?", $referencia);
		$rowRegistro = $tablaRegistro->fetchRow($select);
		
		$modelRegistro = new Encuesta_Model_Registro($rowRegistro->toArray());
		
		return $modelRegistro;
	}
	
	public function obtenerRegistros(){
		$tablaRegistro = $this->tablaRegistro;
		$rowsRegistros = $tablaRegistro->fetchAll();
		$modelRegistros = array();
		foreach ($rowsRegistros as $rowRegistro) {
			$modelRegistro = new Encuesta_Model_Registro($rowRegistro->toArray());
			$modelRegistros[] = $modelRegistro;
		}
		
		return $modelRegistros;
	}
	
	public function obtenerDocentes(){
		$tablaRegistro = $this->tablaRegistro;
		$select = $tablaRegistro->select()->from($tablaRegistro)->where("tipo=?","DO");
		$rowsDocentes = $tablaRegistro->fetchAll($select);
		$modelDocentes = array();
		foreach ($rowsDocentes as $row) {
			$modelDocente = new Encuesta_Model_Registro($row->toArray());
			$modelDocentes[] = $modelDocente;
		}
		
		return $modelDocentes;
	}
	// =====================================================================================>>>   Insertar
	public function crearRegistro(Encuesta_Model_Registro $registro){
		$tablaRegistro = $this->tablaRegistro;
		$tablaRegistro->insert($registro->toArray());
	}
	
	// =====================================================================================>>>   Actualizar
	public function editarRegistro($idRegistro, array $registro){
		
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarRegistro($idRegistro){
		
	}
	
	
}
