<?php
/**
 * 
 */
class Sistema_DAO_Empresa implements Sistema_Interfaces_IEmpresa {
	
	private $tablaEmpresa;
	
	private $tablaEmpresas;
	private $tablaClientes;
	private $tablaProveedores;
	
	private $tablaDomicilio;
	private $tablaDomiciliosFiscales;
	private $tablaTelefono;
	private $tablaTelefonosFiscales;
	private $tablaEmail;
	private $tablaEmailFiscales;
	
	public function __construct() {
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas;
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes;
		$this->tablaProveedores = new Sistema_Model_DbTable_Proveedores;
	}
	
	public function crearEmpresa(array $datos){
		
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		try{
			$fiscal = $datos[0];
			$mFiscal = new Sistema_Model_Fiscales($fiscal);
			$mFiscal->setHash($mFiscal->getHash());
			$bd->insert("Fiscales", $mFiscal->toArray());
			$idFiscales = $bd->lastInsertId("Fiscales","idFiscales");
			$bd->insert("Empresa", array("idFiscales"=>$idFiscales));
			$idEmpresa = $bd->lastInsertId("Empresa", "idEmpresa");
			//Insertamos en empresa, cliente o proveedor
			switch ($fiscal['tipo']) {
				case 'EM':
					$bd->insert("Empresas", array("idEmpresa"=>$idEmpresa));
					break;	
				case 'CL':
					$bd->insert("Clientes", array("idEmpresa"=>$idEmpresa));
					break;
				case 'PR':
					$bd->insert("Proveedores", array("idEmpresa"=>$idEmpresa,"idTipoProveedor"=>$fiscal["tipoProveedor"]));
					break;
			}
			//Insertamos en domicilio
			$domicilio = $datos[1];
			$mDomicilio = new Sistema_Model_Domicilio($domicilio);
			$mDomicilio->setHash($mDomicilio->getHash());
			$bd->insert("Domicilio", $mDomicilio->toArray());
			$idDomicilio = $bd->lastInsertId("Domicilio","idDomicilio");
			$bd->insert("FiscalesDomicilios", array("idDomicilio"=>$idDomicilio,"idFiscales"=>$idFiscales,"esSucursal"=>"N"));
			//Insertamos en telefono
			$telefono = $datos[2];
			$mTelefono = new Sistema_Model_Telefono($telefono);
			$mTelefono->setHash($mTelefono->getHash());
			$bd->insert("Telefono", $mTelefono->toArray());
			$idTelefono = $bd->lastInsertId("Telefono", "idTelefono");
			$bd->insert("FiscalesTelefonos", array("idFiscales"=>$idFiscales,"idTelefono"=>$idTelefono));
			//Insertamos en email
			$email = $datos[3];
			$mEmail = new Sistema_Model_Email($email);
			$mEmail->setHash($mEmail->getHash());
			$mEmail->setFecha(date("Y-m-d H:i:s", time()));
			$bd->insert("Email", $mEmail->toArray());
			$idEmail = $bd->lastInsertId("Email","idEmail");
			$bd->insert("FiscalesEmail", array("idFiscales"=>$idFiscales,"idEmail"=>$idEmail));
			$bd->commit();
		}catch(Exception $ex){
			print_r("<br />");
			print_r("================");
			print_r("<br />");
			print_r("Excepcion Lanzada");
			print_r("<br />");
			print_r("================");
			print_r("<br />");
			print_r($ex->getMessage());
			print_r("<br />");
			print_r("<br />");
			$bd->rollBack();
		}
	}
	
	public function obtenerIdFiscalesEmpresas(){
		//Obtenemos todas las empresas
		$tablaEmpresas = $this->tablaEmpresas;
		$rowsEmpresas = $tablaEmpresas->fetchAll();
		
		$tablaEmpresa = $this->tablaEmpresa;
		
		$idFiscales = array();
		
		foreach ($rowsEmpresas as $row) {
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa = ?", $row->idEmpresa);
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
			
			$idFiscales[] = $rowEmpresa->idFiscales;
		}
		
		return $idFiscales;
	}
	
	public function obtenerIdFiscalesClientes(){
		$tablaClientes = $this->tablaClientes;
		$rowsClientes = $tablaClientes->fetchAll();
		
		$tablaEmpresa = $this->tablaEmpresa;
		
		$idFiscales = array();
		
		foreach ($rowsClientes as $row) {
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa = ?", $row->idEmpresa);
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
			
			$idFiscales[] = $rowEmpresa->idFiscales;
		}
		
		return $idFiscales;
	}
	
	public function obtenerIdFiscalesProveedores(){
		$tablaProveedores = $this->tablaProveedores;
		$rowsProveedores = $tablaProveedores->fetchAll();
		
		$tablaEmpresa = $this->tablaEmpresa;
		
		$idFiscales = array();
		
		foreach ($rowsProveedores as $row) {
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa = ?", $row->idEmpresa);
			$rowEmpresa = $tablaEmpresa->fetchAll($select);
			
			$idFiscales[] = $rowEmpresa->idFiscales;
		}
		
	}
}
