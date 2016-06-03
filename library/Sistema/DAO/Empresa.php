<?php
/**
 * 
 */
class Sistema_DAO_Empresa implements Sistema_Interfaces_IEmpresa {
	
	private $tablaEmpresa;
	
	private $tablaEmpresas;
	private $tablaClientes;
	private $tablaProveedores;
	
	private $tablaTipoProveedor;
	
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
		
		$this->tablaTipoProveedor = new Sistema_Model_DbTable_TipoProveedor;
	}
	
	/**
	 * Crear empresa administrada.
	 * Este metodo crea una empresa con la que vamos a operar en el sistema.
	 * A su vez la empresa se da de alta en la Tabla Clientes y en la Tabla Proveedores.
	 * 
	 */
	public function crearEmpresa(array $datos){
		
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		print_r("Iniciando transaccion.");
		print_r("<br />");
		$bd->beginTransaction();
		try{
			print_r("En transaccion.");
			print_r("<br />");
			$fiscal = $datos[0];
			print_r($fiscal);
			print_r("<br />");
			$tipoProveedor = $fiscal["tipoProveedor"];
			unset($fiscal["tipo"]);
			unset($fiscal["tipoProveedor"]);
			print_r($fiscal);
			print_r("<br />");
			print_r("<br />");
			print_r("TipoProveedor: ".$tipoProveedor);
			print_r("<br />");
			$mFiscal = new Sistema_Model_Fiscales($fiscal);
			//$mFiscal->setHash($mFiscal->getHash());
			$bd->insert("Fiscales", $mFiscal->toArray());
			$idFiscales = $bd->lastInsertId("Fiscales","idFiscales");
			print_r("<br />");
			print_r("IdFiscales: ".$idFiscales);
			print_r("<br />");
			$bd->insert("Empresa", array("idFiscales"=>$idFiscales));
			$idEmpresa = $bd->lastInsertId("Empresa", "idEmpresa");
			//Insertamos en empresa, cliente o proveedor
			switch ($fiscal['tipo']) {
				case 'EM':
					$bd->insert("Empresas", array("idEmpresa"=>$idEmpresa));
					$bd->insert("Clientes", array("idEmpresa"=>$idEmpresa));
					$bd->insert("Proveedores", array("idEmpresa"=>$idEmpresa,"idTipoProveedor"=>$tipoProveedor));
					break;	
				case 'CL':
					$bd->insert("Clientes", array("idEmpresa"=>$idEmpresa));
					break;
				case 'PR':
					$bd->insert("Proveedores", array("idEmpresa"=>$idEmpresa,"idTipoProveedor"=>$tipoProveedor));
					break;
			}
			//Insertamos en domicilio
			$domicilio = $datos[1];
			$mDomicilio = new Sistema_Model_Domicilio($domicilio);
			//$mDomicilio->setHash($mDomicilio->getHash());
			$bd->insert("Domicilio", $mDomicilio->toArray());
			$idDomicilio = $bd->lastInsertId("Domicilio","idDomicilio");
			$bd->insert("FiscalesDomicilios", array("idDomicilio"=>$idDomicilio,"idFiscales"=>$idFiscales,"esSucursal"=>"N"));
			//Insertamos en telefono
			$telefono = $datos[2];
			$mTelefono = new Sistema_Model_Telefono($telefono);
			//$mTelefono->setHash($mTelefono->getHash());
			$bd->insert("Telefono", $mTelefono->toArray());
			$idTelefono = $bd->lastInsertId("Telefono", "idTelefono");
			$bd->insert("FiscalesTelefonos", array("idFiscales"=>$idFiscales,"idTelefono"=>$idTelefono));
			//Insertamos en email
			$email = $datos[3];
			$mEmail = new Sistema_Model_Email($email);
			//$mEmail->setHash($mEmail->getHash());
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

	/**
	 * 
	 */
	public function obtenerEmpresa($idEmpresa){
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa=?",$idEmpresa);
		
		try{
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
			if(is_null($rowEmpresa)){
				return null;
			}else{
				return $rowEmpresa->toArray();
			}
			
		}catch(Exception $ex){
			print_r("Excepcion Lanzada: <strong>" . $ex->getMessage()."</strong>");
		}
		
		
	}
	
	/**
	 * Obtiene un registro de la tabla empresa, en base al idFiscal proporcionado
	 * @param $idFiscal
	 * @return array | null
	 */
	public function obtenerEmpresaPorIdFiscales($idFiscales){
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales=?",$idFiscales);
		
		try{
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
			if(is_null($rowEmpresa)){
				return null;
			}else{
				return $rowEmpresa->toArray();
			}
			
		}catch(Exception $ex){
			print_r("Excepcion Lanzada: <strong>" . $ex->getMessage()."</strong>");
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
		
		return $idFiscales;
	}
	
	/**
	 * Obtiene todos los elementos de la Tabla Tipo Proveedor
	 * @return array()
	 */
	public function obtenerTipoProveedor()
	{
		$tablaTipoProveedor = $this->tablaTipoProveedor;
		$rows = $tablaTipoProveedor->fetchAll();
		
		if(is_null($rows)){
			return null;
		}else{
			return $rows->toArray();
		}
		
	}
}
