<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Inventario implements Inventario_Interfaces_IInventario {
	
	private $tablaInventario;
	
	public function __construct() {
		$this->tablaInventario = new  Inventario_Model_Inventario;
	}
	
	public function obtenerInventario(){
		$tablaInventario = $this->tablaInventario;
		$rowInventario = $tablaInventario>fetchAll();
		
		$modelInventarios = array();
		
		foreach ($rowInventarios as $rowInventario) {
			$modelInventario = new Inventario_Model_Inventario($rowInventario->toArray());
			$modelInventario>setIdInventario($rowInventario->idInventario);
			
			$modelInventarios[] = $modelInventarios;
		}
		
		return $modelInventarios;
	}
	
	public function crearEmail(Sistema_Model_Email $email){
		$tablaEmail = $this->tablaEmail;
		$tablaEmail->insert($email->toArray());
	}
	
	public function editarEmail($idEmail, Sistema_Model_Email $email){
		$tablaEmail = $this->tablaEmail;
		$where = $tablaEmail->getAdapter()->quoteInto("idEmail = ?", $idEmail);
		
		$tablaEmail->update($email->toArray(), $where);
	}
	
	public function eliminarEmail($idEmail){
		$tablaEmail = $this->tablaEmail;
		$where = $tablaEmail->getAdapter()->quoteInto("idEmail = ?", $idEmail);
		
		$tablaEmail->delete($where);
	}
}