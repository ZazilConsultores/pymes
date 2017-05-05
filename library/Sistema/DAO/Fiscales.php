<?php
/**
 * 
 */
class Sistema_DAO_Fiscales implements Sistema_Interfaces_IFiscales {
	
	private $tablaFiscales;
	private $tablaEmpresa;
	private $tablaEmpresas;
	private $tablaClientes;
	private $tablaProveedores;
	private $tablaTipoProveedor;
	private $tablaClientesEmpresa;
	private $tablaProveedoresEmpresa;
	
	private $tablaFiscalesDomicilios;
	private $tablaDomicilio;
	private $tablaFiscalesTelefonos;
	private $tablaTelefono;
	private $tablaFiscalesEmail;
	private $tablaEmail;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		
		$this->tablaFiscales = new Sistema_Model_DbTable_Fiscales(array('db'=>$dbAdapter));
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas(array('db'=>$dbAdapter));
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes(array('db'=>$dbAdapter));
		$this->tablaProveedores = new Sistema_Model_DbTable_Proveedores(array('db'=>$dbAdapter));
		
		$this->tablaClientesEmpresa = new Sistema_Model_DbTable_ClientesEmpresa(array('db'=>$dbAdapter));
		$this->tablaProveedoresEmpresa = new Sistema_Model_DbTable_ProveedoresEmpresa(array('db'=>$dbAdapter));
		
		$this->tablaDomicilio = new Sistema_Model_DbTable_Domicilio(array('db'=>$dbAdapter));
		$this->tablaFiscalesDomicilios = new Sistema_Model_DbTable_FiscalesDomicilios(array('db'=>$dbAdapter));
		$this->tablaTelefono = new Sistema_Model_DbTable_Telefono(array('db'=>$dbAdapter));
		$this->tablaFiscalesTelefonos = new Sistema_Model_DbTable_FiscalesTelefonos(array('db'=>$dbAdapter));
		$this->tablaEmail = new Sistema_Model_DbTable_Email(array('db'=>$dbAdapter));
		$this->tablaFiscalesEmail = new Sistema_Model_DbTable_FiscalesEmail(array('db'=>$dbAdapter));
		$this->tablaTipoProveedor = new Sistema_Model_DbTable_TipoProveedor(array('db'=>$dbAdapter));
	}
	
	public function obtenerFiscales($idFiscales){
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales = ?", $idFiscales);
		$rowFiscal = $tablaFiscales->fetchRow($select);
		$modelFiscal = new Sistema_Model_Fiscales($rowFiscal->toArray());
		
		return $modelFiscal;
	}
	
	public function obtenerFiscalesCuentaContable($idFiscales){
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()
		->setIntegrityCheck(false)
		->from($tablaFiscales, array('Fiscales.idFiscales','rfc','razonSocial'))
		->join('Empresa', 'Fiscales.idFiscales = Empresa.idFiscales', ('Empresa.idEmpresa'))
		->join('Proveedores', 'Empresa.idEmpresa = Proveedores.idEmpresa',array('idProveedores','idTipoProveedor','cuenta'))
		->where("Fiscales.idFiscales = ?", $idFiscales);
		$rowFiscales = $tablaFiscales->fetchAll($select);
		return $tablaFiscales->fetchRow($select);
		
	}
	
	public function obtenerFiscalesTipoProveedor($idFiscales){
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()
		->setIntegrityCheck(false)
		->from($tablaFiscales, array('Fiscales.idFiscales','rfc','razonSocial'))
		->join('Empresa', 'Fiscales.idFiscales = Empresa.idFiscales', ('Empresa.idEmpresa'))
		->join('Proveedores', 'Empresa.idEmpresa = Proveedores.idEmpresa',array('idProveedores','idTipoProveedor','cuenta'))
		->where("Fiscales.idFiscales = ?", $idFiscales);
		$rows = $tablaFiscales->fetchAll($select);
		
		$modelsTipo = array();
		$tablaTipoProve = $this->tablaTipoProveedor;
		
		foreach ($rows as $row) {
			$select = $tablaTipoProve->select()->from($tablaTipoProve)->where("idTipoProveedor=?",$row->idTipoProveedor);
			//print_r($select->__toString());
			$row = $tablaTipoProve->fetchRow($select);
			$modelTProv = new Sistema_Model_TipoProveedor($row->toArray());
			$modelsTipo[] = $modelTProv;
		}
		
		return $modelsTipo;
		
	}
	
	
	
	public function obtenerFiscalesCuentaContableCli($idFiscales){
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()
		->setIntegrityCheck(false)
		->from($tablaFiscales, array('Fiscales.idFiscales','rfc','razonSocial'))
		->join('Empresa', 'Fiscales.idFiscales = Empresa.idFiscales', ('Empresa.idEmpresa'))
		->join('Clientes', 'Empresa.idEmpresa = Clientes.idEmpresa',array('idCliente','cuenta'))
		->where("Fiscales.idFiscales = ?", $idFiscales);
		 return $tablaFiscales->fetchRow($select);
	}
	
	public function obtenerFiscalesEmpresas() {
		$tablaEmpresas = $this->tablaEmpresas;
		$rowsEmpresas = $this->tablaEmpresas->fetchAll();
		
		$idsEmpresa = array();
		foreach ($rowsEmpresas as $rowEmpresa) {
			$idsEmpresa[] = $rowEmpresa->idEmpresa;
		}
		
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa IN (?)", $idsEmpresa);
		// Todas las empresas administrables
		$rowsEmpresa = $tablaEmpresa->fetchAll($select);
		$idsFiscales = array();
		foreach ($rowsEmpresa as $rowEmpresa) {
			$idsFiscales[] = $rowEmpresa->idFiscales;
		}
		
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales IN (?)", $idsFiscales);
		$rowsFiscales = $tablaFiscales->fetchAll($select);
		//print_r($rowsFiscales->toArray());
		return $rowsFiscales->toArray();
	}
	
	/**
	 * Obtenemos un array de los datos fiscales de la Tabla Clientes.
	 */
	public function obtenerFiscalesClientes() {
		$rowsClientes = $this->tablaClientes->fetchAll();
		//Extraemos los id's de empresa T.Empresa
		$idsEmpresa = array();
		
		foreach ($rowsClientes as $rowCliente) {
			
		}
		
		
	}
	
	public function obtenerFiscalesProveedores() {
		
	}
	
	public function obtenerDomiciliosPorIdFiscal($idFiscales){
		$tablaFiscalesDomicilio = $this->tablaFiscalesDomicilios;
		$select = $tablaFiscalesDomicilio->select()->from($tablaFiscalesDomicilio)->where("idFiscales = ?", $idFiscales);
		//$rowDF = $tablaFiscalesDomicilio->fetchRow($select);
		$rowsDF = $tablaFiscalesDomicilio->fetchAll($select);
		//print_r($rowsDF);
		//---------------------------------------------------------
		$modelsDomicilio = array();
		$tablaDomicilio = $this->tablaDomicilio;
		
		foreach ($rowsDF as $rowDF) {
			$select = $tablaDomicilio->select()->from($tablaDomicilio)->where("idDomicilio=?",$rowDF->idDomicilio);
			//print_r($select->__toString());
			$rowD = $tablaDomicilio->fetchRow($select);
			$modelDomicilio = new Sistema_Model_Domicilio($rowD->toArray());
			$modelsDomicilio[] = $modelDomicilio;
		}
		
		return $modelsDomicilio;
	}
	
	/**
	 * Obtiene todos los telefonos de la empresa con idFiscales proporcionado
	 */
	public function obtenerTelefonosFiscales($idFiscales){
		$tablaFiscalesTelefonos = $this->tablaFiscalesTelefonos;
		$select = $tablaFiscalesTelefonos->select()->from($tablaFiscalesTelefonos)->where("idFiscales = ?", $idFiscales);
		$rowsTF = $tablaFiscalesTelefonos->fetchAll($select);
		//---------------------------------------------------------
		$tablaTelefono = $this->tablaTelefono;
		$modelsTelefonos = array();
		foreach ($rowsTF as $row) {
			$select = $tablaTelefono->select()->from($tablaTelefono)->where("idTelefono = ?",$row->idTelefono);
			$rowT = $tablaTelefono->fetchRow($select);
			$modelTelefono = new Sistema_Model_Telefono($rowT->toArray());
			$modelsTelefonos[] = $modelTelefono;
		}
		
		return $modelsTelefonos;
	}
	
	public function obtenerEmailsFiscales($idFiscales){
		$tablaFiscalesEmails = $this->tablaFiscalesEmail;
		$select = $tablaFiscalesEmails->select()->from($tablaFiscalesEmails)->where("idFiscales = ?", $idFiscales);
		$rowsEF = $tablaFiscalesEmails->fetchAll($select);
		//---------------------------------------------------------
		//print_r($rowsEF->toArray());
		$tablaEmails = $this->tablaEmail;
		$modelsEmails = array();
		foreach ($rowsEF as $row) {
			$select = $tablaEmails->select()->from($tablaEmails)->where("idEmail = ?",$row->idEmail);
			$rowE = $tablaEmails->fetchRow($select);
			$modelEmail = new Sistema_Model_Email($rowE->toArray());
			$modelsEmails[] = $modelEmail;
		}
		return $modelsEmails;
	}
	
	public function crearFiscales(Sistema_Model_Fiscales $fiscales){
		$tablaFiscales = $this->tablaFiscales;
		$fiscales->setHash($fiscales->getHash());
		$tablaFiscales->insert($fiscales->toArray());
		
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("hash = ?", $fiscales->getHash());
		$rowFiscal = $tablaFiscales->fetchRow($select);
		$fiscales = new Sistema_Model_Fiscales($rowFiscal->toArray());
		return $fiscales; 
	}
	
	public function actualizarFiscales($idFiscales, $datos) {
		$tablaFiscales = $this->tablaFiscales;
		$where = $tablaFiscales->getAdapter()->quoteInto("idFiscales=?", $idFiscales);
		$tablaFiscales->update($datos, $where);
	}
	
	public function actualizarFiscalesCuentaContable($idFiscales, $rfc, $razonSocial,$tipoProveedor, $cuenta) {
		
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()->from($tablaFiscales);
		$where = $tablaFiscales->getAdapter()->quoteInto("idFiscales=?", $idFiscales);
		$tablaFiscales->update(array("rfc" => $rfc,"razonSocial" => $razonSocial), $where);
		$rowFisacales = $tablaFiscales->fetchRow($where);
		if(!is_null($rowFisacales)){
			$tablaEmpresa = $this->tablaEmpresa;
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales =?", $rowFisacales["idFiscales"]);
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
			if(!is_null($rowEmpresa)){
				$tablaProveedor = $this->tablaProveedores;
				$select = $tablaProveedor->select()->from($tablaProveedor);
				$idEmpresa = $rowEmpresa["idEmpresa"];
				$where = $tablaProveedor->getAdapter()->quoteInto("idEmpresa=?", $idEmpresa);
				$tablaProveedor->update(array("cuenta"=>$cuenta,"idTipoProveedor"=>$tipoProveedor), $where);
			}
		}
	}

	public function actualizarFiscalesCuentaContableCli($idFiscales, $rfc, $razonSocial, $cuenta) {
		
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()->from($tablaFiscales);
		$where = $tablaFiscales->getAdapter()->quoteInto("idFiscales=?", $idFiscales);
		$tablaFiscales->update(array("rfc" => $rfc,"razonSocial" => $razonSocial), $where);
		$rowFisacales = $tablaFiscales->fetchRow($where);
		//print_r("$select");
		if(!is_null($rowFisacales)){
			$tablaEmpresa = $this->tablaEmpresa;
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales =?", $rowFisacales["idFiscales"]);
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
			if(!is_null($rowEmpresa)){
				$tablaClientes = $this->tablaClientes;
				$select = $tablaClientes->select()->from($tablaClientes);
				$idEmpresa = $rowEmpresa["idEmpresa"];
				$where = $tablaClientes->getAdapter()->quoteInto("idEmpresa=?", $idEmpresa);
				$tablaClientes->update(array("cuenta"=>$cuenta), $where);
			}
		}
	}
	
	public function agregarDomicilioFiscal($idFiscales, Sistema_Model_Domicilio $domicilio){
		$tablaFiscalesDomicilios = $this->tablaFiscalesDomicilios;
		$registro = array();
		$registro["idFiscales"] = $idFiscales;
		$registro["idDomicilio"] = $domicilio->getIdDomicilio();
		$registro["esSucursal"] = "N";
		
		$tablaFiscalesDomicilios->insert($registro);
	}
	
	public function agregarTelefonoFiscal($idFiscales, Sistema_Model_Telefono $telefono){
		$tablaFiscalesTelefonos = $this->tablaFiscalesTelefonos;
		$registro = array();
		$registro["idFiscales"] = $idFiscales;
		$registro["idTelefono"] = $telefono->getIdTelefono();
		
		$tablaFiscalesTelefonos->insert($registro);
	}
	
	public function agregarEmailFiscal($idFiscales, Sistema_Model_Email $email){
		$tablaFiscalesEmail = $this->tablaFiscalesEmail;
		$registro = array();
		$registro["idFiscales"] = $idFiscales;
		$registro["idEmail"] = $email->getIdEmail();
		
		$tablaFiscalesEmail->insert($registro);
	}
	
	public function esSucursal($idDomicilio,$idFiscales)
	{
		$tablaFiscalesDomicilio = $this->tablaFiscalesDomicilios;
		$select = $tablaFiscalesDomicilio->select()->from($tablaFiscalesDomicilio)->where("idDomicilio=?",$idDomicilio)->where("idFiscales=?",$idFiscales);
		$rowDF = $tablaFiscalesDomicilio->fetchRow($select);
		
		if($rowDF->esSucursal){
			return true;
		}else{
			return false;
		}
		
	}
	
	//	Restructuracion de funciones
	/**
	 * Obtenemos registro de la tabla en forma de array php, null si no existe registro con id especificado.
	 * @param int $idFiscales
	 * @return mixed array | null
	 */
	public function getFiscalesById($idFiscales){
		
	}
	
	public function getFiscalesByIdEmpresa($idEmpresa){
		
	}
	
	/**
	 * Obtenemos todos los registros que sean empresas administrables en el sistema.
	 * @return mixed array( n * array() ) | null
	 */
	public function getFiscalesEmpresas(){
		$tablaEmpresas = $this->tablaEmpresas;
		$select = $tablaEmpresas->select()->from($tablaEmpresas,array("idEmpresa"));
		$rowsEmpresas = $tablaEmpresas->fetchAll($select);
		$idsEmpresa = array();
		foreach ($rowsEmpresas as $rowEmpresas) {
			$idsEmpresa[] = $rowEmpresas->idEmpresa;
		}
		//print_r($idsEmpresa);
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa, array("idFiscales"))->where("idEmpresa IN (?)", $idsEmpresa);
		$rowsEmpresa = $tablaEmpresa->fetchAll($select);
		
		$idsFiscales = array();
		foreach ($rowsEmpresa as $rowEmpresa) {
			$idsFiscales[] = $rowEmpresa->idFiscales;
		}
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales IN (?)", $idsFiscales);
		$rowsFiscales = $tablaFiscales->fetchAll($select);
		
		if(is_null($rowsFiscales)){
			return null;
		}else{
			return $rowsFiscales->toArray();
		}
		
	}
	
	public function getFiscalesClientes() {
		$tablaClientes = $this->tablaClientes;
		$select = $tablaClientes->select()->from($tablaClientes, array("idEmpresa"));
		$rowsClientes = $tablaClientes->fetchAll($select);
		
		$idsEmpresa = array();
		foreach ($rowsClientes as $rowCliente) {
			$idsEmpresa[] = $rowCliente->idEmpresa;
		}
		
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa, array("idFiscales"))->where("idEmpresa IN (?)",$idsEmpresa);
		$rowsEmpresa = $tablaEmpresa->fetchAll($select);
		
		$idsFiscales = array();
		foreach ($rowsEmpresa as $rowEmpresa) {
			$idsFiscales[] = $rowEmpresa->idFiscales;
		}
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales IN (?)", $idsFiscales)->order(array('razonSocial ASC'));
		$rowsFiscales = $tablaFiscales->fetchAll($select);
		
		//print_r($rowsFiscales->toArray());
		//$json = Zend_Json::encode($rowsFiscales);
		//print_r($json);
		
		if(is_null($rowsFiscales)){
			return null;
		}else{
			return $rowsFiscales->toArray();
		}
		
	}
	
	public function getFiscalesProveedores(){
		$tablaProveedores = $this->tablaProveedores;
		$select = $tablaProveedores->select()->from($tablaProveedores, array("idEmpresa"));
		$rowsProveedores = $tablaProveedores->fetchAll($select);
		
		$idsEmpresa = array();
		foreach ($rowsProveedores as $rowProveedor) {
			$idsEmpresa[] = $rowProveedor->idEmpresa;
		}
		
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa,array("idFiscales"))->where("idEmpresa IN (?)",$idsEmpresa);
		$rowsEmpresa = $tablaEmpresa->fetchAll($select);
		
		$idsFiscales = array();
		foreach ($rowsEmpresa as $rowEmpresa) {
			$idsFiscales[] = $rowEmpresa->idFiscales;
		}
		
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales IN (?)", $idsFiscales)->order(array('razonSocial ASC'));
		$rowsFiscales = $tablaFiscales->fetchAll($select);
		
		if (is_null($rowsFiscales)) {
			return null;
		}else{
			return $rowsFiscales->toArray();
		}
		
		
	}
	
	/*Clientes*/
	public function getFiscalesClientesByIdFiscalesEmpresa($idFiscales) {
		// Obtenemos el IdEmpresa de la empresa del idFiscales proporcionado
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales=?",$idFiscales);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);
		// Obtenemos el IdEmpresas de la empresa mediante el IdEmpresa
		$tablaEmpresas = $this->tablaEmpresas;
		$select = $tablaEmpresas->select()->from($tablaEmpresas)->where("idEmpresa=?",$rowEmpresa->idEmpresa);
		$rowEmpresas = $tablaEmpresas->fetchRow($select);
		// Obtenemos todos los ids de Cliente de la tabla ClientesEmpresa
		$tablaClientesEmpresa = $this->tablaClientesEmpresa;
		$select = $tablaClientesEmpresa->select()->from($tablaClientesEmpresa)->where("idEmpresas=?",$rowEmpresas->idEmpresas);
		$rowClientesEmpresa = $tablaClientesEmpresa->fetchRow($select);
		
		$idsCliente = explode(",", $rowClientesEmpresa->idsClientes);
		if(! is_null($rowClientesEmpresa->idsClientes) && ! empty($idsCliente)) {
			$tablaClientes = $this->tablaClientes;
			$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente IN (?)", $idsCliente);
			$rowsClientes = $tablaClientes->fetchAll($select);
			
			$idsEmpresa = array();
			foreach ($rowsClientes as $rowCliente) {
				$idsEmpresa[] = $rowCliente->idEmpresa;
			}
			
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa IN (?)", $idsEmpresa);
			$rowsEmpresa = $tablaEmpresa->fetchAll($select);
			
			$idsFiscales = array();
			foreach ($rowsEmpresa as $rowEmpresa) {
				$idsFiscales[] = $rowEmpresa->idFiscales;
			}
			//print_r($idsEmpresa);
			$tablaFiscales = $this->tablaFiscales;
			$select = $tablaFiscales->select()->from($tablaFiscales,array('rfc','razonSocial'))->where("idFiscales IN (?)", $idsFiscales);
			$rowsFiscales = $tablaFiscales->fetchAll($select);

			if (is_null($rowsFiscales)) {
				return NULL;
			}else{
				return $rowsFiscales->toArray();
			}
		}else{
			return NULL;
		}
						
	}
	/*pro*/
	public function getFiscalesProveedoresByIdFiscalesEmpresa ($idFiscales){
		// Obtenemos el IdEmpresa de la empresa del idFiscales proporcionado
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales=?",$idFiscales);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);
		// Obtenemos el IdEmpresas de la empresa mediante el IdEmpresa
		$tablaEmpresas = $this->tablaEmpresas;
		$select = $tablaEmpresas->select()->from($tablaEmpresas)->where("idEmpresa=?",$rowEmpresa->idEmpresa);
		$rowEmpresas = $tablaEmpresas->fetchRow($select);
		// Obtenemos todos los ids de Proveedor de la tabla proveedoresEmpresa
		$tablaProveedoresEmpresa = $this->tablaProveedoresEmpresa;
		$select = $tablaProveedoresEmpresa->select()->from($tablaProveedoresEmpresa)->where("idEmpresas=?",$rowEmpresas->idEmpresas);
		$rowProveedorEmpresa = $tablaProveedoresEmpresa->fetchRow($select);
		
		$idsProveedor = explode(",", $rowProveedorEmpresa->idProveedores);
		if(! is_null($rowProveedorEmpresa->idProveedores) && ! empty($idsProveedor)) {
			$tablaProveedores = $this->tablaProveedores;
			$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores IN (?)", $idsProveedor);
			$rowsProveedores = $tablaProveedores->fetchAll($select);
			print_r("$select");
			$idsEmpresa = array();
			foreach ($rowsProveedores as $rowProveedores) {
				$idsEmpresa[] = $rowProveedores->idEmpresa;
			}
			
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa IN (?)", $idsEmpresa);
			$rowsEmpresa = $tablaEmpresa->fetchAll($select);
			
			$idsFiscales = array();
			foreach ($rowsEmpresa as $rowEmpresa) {
				$idsFiscales[] = $rowEmpresa->idFiscales;
			}
			//print_r($idsEmpresa);
			/*$tablaFiscales = $this->tablaFiscales;
			$select = $tablaFiscales->select()->from($tablaFiscales,array('rfc','razonSocial'))->where("idFiscales IN (?)", $idsFiscales);
			$rowsFiscales = $tablaFiscales->fetchAll($select);*/
			$tablaEmpresa = $this->tablaEmpresa;
			$select= $tablaEmpresa->select()
			->setIntegrityCheck(false)
			->from($tablaEmpresa, array('idEmpresa'))
			->join('Fiscales', 'Empresa.idFiscales = Fiscales.idFiscales', array('razonSocial'))
			->join('Proveedores','Empresa.idEmpresa = Proveedores.idEmpresa')
			->order('razonSocial ASC')->where("Fiscales.idFiscales IN (?)", $idsFiscales);
			//print_r("$select");
			//return $tablaEmpresa->fetchAll($select);
			$rowsFiscales = $tablaEmpresa->fetchAll($select);
			if (is_null($rowsFiscales)) {
				return NULL;
			}else{
				return $rowsFiscales->toArray();
			}
		}else{
			return NULL;
		}
		
	}
	
	/**
	 * 
	 */
	public function getEmpresaByIdFiscales($idFiscales){
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales=?",$idFiscales);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);
		
		$tablaEmpresas = $this->tablaEmpresas;
		$select = $tablaEmpresas->select()->from($tablaEmpresas)->where("idEmpresa=?",$rowEmpresa->idEmpresa);
		$rowEmpresas = $tablaEmpresas->fetchRow($select);
		print_r("$select");
		return $rowEmpresas->toArray();
	}
	
	/**
	 * 
	 */
	public function getClienteByIdFiscales($idFiscales) {
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales=?",$idFiscales);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);
		
		$tablaClientes = $this->tablaClientes;
		$select = $tablaClientes->select()->from($tablaClientes)->where("idEmpresa=?",$rowEmpresa->idEmpresa);
		$rowCliente = $tablaClientes->fetchRow($select);
		
		return $rowCliente->toArray();
	}
	
	public function getProveedorByIdFiscales($idFiscales) {
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales=?",$idFiscales);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);
		
		$tablaProveedores = $this->tablaProveedores;
		$select = $tablaProveedores->select()->from($tablaProveedores)->where("idEmpresa=?", $rowEmpresa->idEmpresa);
		$rowProveedor = $tablaProveedores->fetchRow($select);
		
		return $rowProveedor->toArray();
	}
	
	/**
	 * Agrega un nuevo cliente en la tabla ClientesEmpresa de la bd
	 * @param $idEmpresas Id de la Empresa
	 * @param $idCliente Id del Cliente a asociar
	 */
	public function asociateClienteEmpresa($idEmpresas, $idCliente) {
		$tablaClientesE = $this->tablaClientesEmpresa;
		$select = $tablaClientesE->select()->from($tablaClientesE)->where("idEmpresas=?",$idEmpresas);
		$rowCliente = $tablaClientesE->fetchRow($select);
		
		if(! is_null($rowCliente)){
			$idsClientes = explode(",", $rowCliente->idsClientes);
			//print_r($idsClientes);
			if(! in_array($idCliente, $idsClientes)){
				//print_r("<br /> No existe el cliente, en clientes, hay que agregarlo<br />");
				$idsClientes[] = $idCliente;
				//print_r($idsClientes);
				//print_r("<br />");
				$ids = implode(",", $idsClientes);
				//print_r(implode(",", $idsClientes));
				//$where = $tablaClientesE->getAdapter()->quoteInto("idEmpresas = ?", $idEmpresas);
				//print_r($where);
				//$tablaClientesE->update(array("idsClientes" => $ids), $where);
				
				$rowCliente->idsClientes = $ids;
				$rowCliente->save();
				//$tablaClientesE->update(implode(",", $idsClientes), $where);
				
			}
		}else{
			$tablaClientesE->insert(array("idEmpresas" => $idEmpresas, "idsClientes" => implode(",", array($idCliente))));
		}
		//$tablaClientesE->insert(array("idEmpresas"=>$idEmpresas, "idCliente"=>$idCliente));
	}
	
	public function asociateProveedorEmpresa($idEmpresas, $idProveedor) {
		$tablaProveedoresE = $this->tablaProveedoresEmpresa;
		$select = $tablaProveedoresE->select()->from($tablaProveedoresE)->where("idEmpresas=?",$idEmpresas);
		$rowProveedor = $tablaProveedoresE->fetchRow($select);
		
		if(! is_null($rowProveedor)){
			$idsProveedores = explode(",", $rowProveedor->idProveedores);
			print_r($idsProveedores);
			if(! in_array($idProveedor, $idsProveedores)){
				$idsProveedores[] = $idProveedor;
				$ids = implode(",", $idsProveedores);
				$rowProveedor->idProveedores = $ids;
				$rowProveedor->save();
			}
		}else{
			$tablaProveedoresE->insert(array("idEmpresas" => $idEmpresas, "idProveedores" => implode(",", array($idProveedor))));
		}
	}
	
	public function obtenerCuenta($idFiscales){
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales = ?", $idFiscales);
		$rowFiscal = $tablaFiscales->fetchRow($select);
		$modelFiscal = new Sistema_Model_Fiscales($rowFiscal->toArray());
		
		return $modelFiscal;
	}
	
	
}
