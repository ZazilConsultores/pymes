<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_DAO_Empresa implements Sistema_Interfaces_IEmpresa {
	
	private $tablaEmpresa;
	private $tablaFiscal;
	
	function __construct() {
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
		$this->tablaFiscal = new Sistema_Model_DbTable_Fiscales;
	}
	
	public function obtenerEmpresa($idEmpresa){
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa = ?", $idEmpresa);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);
		$modelEmpresa = new Sistema_Model_Empresa($rowEmpresa->toArray());
		return $modelEmpresa;
	}
	
	public function obtenerEmpresaIdFiscales($idFiscales){
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales = ?", $idFiscales);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);
		$modelEmpresa = new Sistema_Model_Empresa($rowEmpresa->toArray());
		return $modelEmpresa;
	}
	
	public function obtenerEmpresas(){}
	public function crearEmpresa(Sistema_Model_Empresa $empresa){
		$tablaEmpresa = $this->tablaEmpresa;
		$empresa->setHash($empresa->getHash());
		$tablaEmpresa->insert($empresa->toArray());
	}
	
	public function crearEmpresaFiscales(Sistema_Model_Fiscal $fiscal, Sistema_Model_Domicilio $domicilio, Sistema_Model_Telefono $telefono,Sistema_Model_Email $email) {
		
		//Insertar email, telefono y domicilio
		//Insertar fiscales
		//Insertar empresa
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$db->beginTransaction();
		//Insertar email, telefono y domicilio
		//   =====================================================
		$tabla = "email";
		$email->setHash($email->getHash());
		$datos = $email->toArray();
		$db->insert($tabla, $datos);
		$sql = $db->quoteInto("select * from email where hash = ?", $email->getHash());
		$resEmail = $db->query($sql);
		//   =====================================================
		$tabla = "telefono";
		$telefono->setHash($telefono->getHash());
		$datos = $telefono->toArray();
		$db->insert($tabla, $datos);
		$sql = $db->quoteInto("select * from telefono where hash = ?", $telefono->getHash());
		$resTelefono = $db->query($sql);
		//   =====================================================
		$tabla = "domicilio";
		$domicilio->setHash($domicilio->getHash());
		$datos = $domicilio->toArray();
		$db->insert($tabla, $datos);
		$sql = $db->quoteInto("select * from domicilio where hash = ?", $domicilio->getHash());
		$resDomicilio = $db->query($sql);
		//   =====================================================
		//Insertar fiscales
		$tabla = "fiscales";
		
		$fiscal->setIdDomicilio($resDomicilio->idDomicilio);
		$fiscal->setIdsTelefonos($resTelefono->idTelefono);
		$fiscal->setIdsEmails($resEmail->idEmail);
		$fiscal->setHash($domicilio->getHash());
		
		$datos = $fiscal->toArray();
		$db->insert($tabla, $datos);
		$sql = $db->quoteInto("select * from fiscales where hash = ?", $fiscal->getHash());
		$resFiscal = $db->query($sql);
		//Insertar empresa
	}
}
