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
	
	private $tablaSucursal;
	
	public function __construct() {
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas;
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes;
		$this->tablaProveedores = new Sistema_Model_DbTable_Proveedores;
		
		$this->tablaTipoProveedor = new Sistema_Model_DbTable_TipoProveedor;
		$this->tablaSucursal = new Sistema_Model_DbTable_Sucursal;
		
		$this->tablaTelefono = new Sistema_Model_DbTable_Telefono;
	}
	
	/**
	 * Este metodo crea una empresa, el valor almacenado en $datos[0]["tipo"], 
	 * puede ser
	 */
	public function crearEmpresa(array $datos){
		//print_r("<br />");
		//print_r("<br />");
		$fecha = date('Y-m-d h:i:s', time());
		//print_r($fecha);
		print_r("<br />");
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		print_r("Iniciando transaccion.");
		print_r("<br />");
		$bd->beginTransaction();
		try{
			print_r("En transaccion.");
			print_r("<br />");
			$fiscal = $datos[0];
			$tipo = $fiscal["tipo"];
			//print_r($fiscal);
			//print_r("<br />");
			$tipoProveedor = $fiscal["tipoProveedor"];
			unset($fiscal["tipo"]);
			unset($fiscal["tipoProveedor"]);
			$fiscal['fecha'] = $fecha;
			//print_r($fiscal);
			//print_r("<br />");
			//print_r("<br />");
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
			switch ($tipo) {
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
			$bd->insert("Email", $mEmail->toArray());
			$idEmail = $bd->lastInsertId("<email></email>","idEmail");
			$bd->insert("FiscalesEmail", array("idFiscales"=>$idFiscales,"idEmail"=>$idEmail));
			//$bd->commit();
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
		$tablaEmpresa = $this->tablaEmpresa;
		$tablaProveedores = $this->tablaProveedores;
		
		$rowsProveedores = $tablaProveedores->fetchAll();
		
		$idFiscales = array();
		
		foreach ($rowsProveedores as $row) {
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa = ?", $row->idEmpresa);
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
			
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
	
	/**
	 * Agrega una nueva sucursal al domicilio fiscal.
	 */
	public function agregarSucursal($idFiscales, array $datos, $tipoSucursal)
	{
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$fecha = date('Y-m-d h:i:s', time());	
		
		try{
			$bd->beginTransaction();
			$datosSucursal = $datos[0];
			$datosDomicilio = $datos[1];
			$datosTelefonos = $datos[2];
			$datosEmails = $datos[3];
			print_r($datosSucursal);
			print_r("<br />");
			print_r("<br />");
			// ===========================================  Insertar Domicilio
			unset($datosDomicilio["idEstado"]); // Este campo no esta en la tabla domicilio
			$bd->insert("Domicilio",$datosDomicilio);
			$idDomicilio = $bd->lastInsertId("Domicilio","idDomicilio");
			// ===========================================  Insertar Telefono
			$bd->insert("Telefono",$datosTelefonos);
			$idTelefono = $bd->lastInsertId("Telefono","idTelefono");
			// ===========================================  Insertar Email
			$bd->insert("Email",$datosEmails);
			$idEmail = $bd->lastInsertId("Email","idEmail");
			// ===========================================  Insertar Sucursal
			$datosSucursal["idFiscales"] = $idFiscales;
			$datosSucursal["idDomicilio"] = $idDomicilio;
			$datosSucursal["idsTelefonos"] = $idTelefono.",";
			$datosSucursal["idsEmails"] = $idEmail.",";
			print_r("==================================================");
			print_r("<br />");
			print_r($datosSucursal);
			print_r("<br />");
			throw new Exception("Exception", 1);
			
			/*
			print_r($datosSucursal);
			print_r("<br />");
			print_r($datosDomicilio);
			print_r("<br />");
			print_r($datosTelefonos);
			print_r("<br />");
			print_r($datosEmails);
			*/
			
			//$bd->commit();
		}catch(Exception $ex){
			$bd->rollBack();
		}
	}
	
	/**
	 * Sucursales de la empresa
	 */
	public function obtenerSucursales($idFiscales){
		$tablaSucursal = $this->tablaSucursal;
		$select = $tablaSucursal->select()->from($tablaSucursal)->where("idFiscales=?",$idFiscales);
		$rowsSucursales = $tablaSucursal->fetchRow($select);
		
		if(is_null($rowsSucursales)){
			return null;
		}else{
			return $rowsSucursales->toArray();
		}
	}
	
	/**
	 * Comprueba que la empresa con IdFiscales proporcionada 
	 * sea parte de las empresas operables en el sistema.
	 */
	public function esEmpresa($idFiscales){
		$esEmpresa = false;
		
		$tablaEmpresas = $this->tablaEmpresas;
		$empresa = $this->obtenerEmpresaPorIdFiscales($idFiscales);
		
		$select = $tablaEmpresas->select()->from($tablaEmpresas)->where("idEmpresa=?",$empresa["idEmpresa"]);
		$rowEmpresas = $tablaEmpresas->fetchRow($select);
		
		if(!is_null($rowEmpresas)) $esEmpresa = true;
		
		return $esEmpresa;
	}
	
	/**
	 * Comprueba que la empresa con IdFiscales proporcionada
	 * sea parte de los clientes del sistema
	 */
	public function esCliente($idFiscales){
		$esCliente = false;
		$tablaCliente = $this->tablaClientes;
		
		$empresa = $this->obtenerEmpresaPorIdFiscales($idFiscales);
		$select = $tablaCliente->select()->from($tablaCliente)->where("idEmpresa=?",$empresa["idEmpresa"]);
		$rowCliente = $tablaCliente->fetchRow($select);
		
		if(!is_null($rowCliente)) $esCliente = true;
		
		return $esCliente;
	}
	
	/**
	 * Comprueba que la empresa con IdFiscales proporcionada
	 * sea parte de los proveedores del sistema
	 */
	public function esProveedor($idFiscales){
		$esProveedor = false;
		$tablaProveedores = $this->tablaProveedores;
		$empresa = $this->obtenerEmpresaPorIdFiscales($idFiscales);
		$select = $tablaProveedores->select()->from($tablaProveedores)->where("idEmpresa=?",$empresa["idEmpresa"]);
		$rowProveedor = $tablaProveedores->fetchRow($select);
		
		if(!is_null($rowProveedor)) $esProveedor = true;
		
		return $esProveedor;
	}
	
	/**
	 * Agrega un nuevo telefono de contacto de la sucursal proporcionada.
	 */
	public function agregarTelefonoSucursal($idSucursal, Sistema_Model_Telefono $telefono){
		$tablaSucursal = $this->tablaSucursal;
		$select = $tablaSucursal->select()->from($tablaSucursal)->where("idSucursal=?",$idSucursal);
		$rowSucursal = $tablaSucursal->fetchRow($select);
		if(!is_null($rowSucursal)){
			//Obtenemos los id'sTelefonos de la sucursal
			$telefonosSucursal = explode(",", $rowSucursal->telefonos);
			//Agregamos telefono a tablaTelefono y con el idGenerado lo agregamos a la sucursal
			//$tablaTelefono = $this->tablaTelefono;
			print_r($telefonosSucursal);
			print_r("<br />");
			$idTelefono = $this->tablaTelefono->insert($telefono->toArray());
			//$idTelefono = $tablaTelefono->get
			$telefonosSucursal[] = $idTelefono;
			$telefonosSucursal = implode(",", $telefonosSucursal);
			print_r($telefonosSucursal);
			print_r("<br />");
		}
	}
	
	/**
	 * 
	 */
	public function agregarEmailSucursal($idSucursal, Sistema_Model_Email $email){
		
	}
	
	public function editarTelefonoSucursal($idSucursal, array $arrayTelefono){}
	public function editarEmailSucursal($idSucursal, array $arrayEmail){}
	
	public function eliminarTelefonoSucursal($idSucursal, $idTelefono){}
	public function eliminarEmailSucursal($idSucursal, $idEmail){}
	
	
	
	
	
	
}
