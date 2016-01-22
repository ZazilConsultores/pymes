<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Email implements Inventario_Interfaces_IEmail{
	private $tablaEmail;
	
	public function __construct()
	{
		$this->tablaEmail = new Application_Model_DbTable_Email;
	}
	
	public function obtenerEmail($idEmail){
		$tablaEmail = $this->tablaEmail;
		$select = $tablaEmail->select()->from($tablaEmail)->where("idEmail = ?", $idEmail);
		$rowEmail = $tablaEmail->fetchRow($select);
		
		$emailModel = new Application_Model_Email($rowEmail->toArray());
		$emailModel->setIdEmail($rowEmail->idEmail);
		
		return $emailModel;
	}
	
	public function obtenerEmails(){
		$tablaEmail = $this->tablaEmail;
		$rowEmails = $tablaEmail->fetchAll();
		
		$modelEmails = array();
		
		foreach ($rowEmails as $rowEmail) {
			$modelEmail = new Application_Model_Email($rowEmail->toArray());
			$modelEmail->setIdEmail($rowEmail->idEmail);
			
			$modelEmails[] = $modelEmails;
		}
		
		return $modelEmails;
	}
	
	public function crearEmail(Application_Model_Email $email){
		$tablaEmail = $this->tablaEmail;
		$tablaEmail->insert($email->toArray());
	}
	
	public function editarEmail($idEmail, Application_Model_Email $email){
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