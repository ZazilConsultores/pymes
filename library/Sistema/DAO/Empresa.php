
<?php
/**
 * 
 */
class Sistema_DAO_Empresa implements Sistema_Interfaces_IEmpresa {
	
	private $tablaEmpresa;
	private $tablaFiscales;
	
	private $tablaEmpresas;
	private $tablaClientes;
	private $tablaProveedores;
	
	private $tablaClientesEmpresa;
	private $tablaProveedoresEmpresa;
	
	private $tablaTipoProveedor;
	
	private $tablaDomicilio;
	private $tablaDomiciliosFiscales;
	private $tablaTelefono;
	private $tablaTelefonosFiscales;
	private $tablaEmail;
	private $tablaEmailFiscales;
	
	private $tablaSucursal;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
		
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas(array('db'=>$dbAdapter));
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes(array('db'=>$dbAdapter));
		$this->tablaProveedores = new Sistema_Model_DbTable_Proveedores(array('db'=>$dbAdapter));
		
		$this->tablaClientesEmpresa = new Sistema_Model_DbTable_ClientesEmpresa(array('db'=>$dbAdapter));
		$this->tablaProveedoresEmpresa = new Sistema_Model_DbTable_ProveedoresEmpresa(array('db'=>$dbAdapter));
		
		$this->tablaTipoProveedor = new Sistema_Model_DbTable_TipoProveedor(array('db'=>$dbAdapter));
		$this->tablaSucursal = new Sistema_Model_DbTable_Sucursal(array('db'=>$dbAdapter));
		
		$this->tablaTelefono = new Sistema_Model_DbTable_Telefono(array('db'=>$dbAdapter));
		
		$this->tablaFiscales = new Sistema_Model_DbTable_Fiscales(array('db'=>$dbAdapter));
		
		$this->tablaDomicilio = new Sistema_Model_DbTable_Domicilio(array('db'=>$dbAdapter));
	}
	
	/**
	 * Este metodo crea una empresa, el valor almacenado en $datos[0]["tipo"], 
	 * puede ser
	 */
	public function crearEmpresa(array $datos){
		
		$fecha = date('Y-m-d h:i:s', time());
		
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		
		try{
			//	Obtenemos los datos fiscales
			$fiscal = $datos[0];
			// Vemos si damos de alta una empresa EM, un cliente CL o un proveedor PR
			$tipo = $fiscal["tipo"];
			// Solo es valido cuando damos de alta una empresa (CL y PR) y un proveedor PR
			if(array_key_exists("tipoProveedor", $fiscal)){
				$tipoProveedor = $fiscal["tipoProveedor"];
				unset($fiscal["tipoProveedor"]);
			}
			$cuenta = "";
			if(array_key_exists("cuenta", $fiscal)){
				$cuenta = $fiscal["cuenta"];
				unset($fiscal["cuenta"]);
			}
			//	En la informacion fiscal tipo y tipoProveedor no van a la base de datos
			unset($fiscal["tipo"]);
			unset($fiscal["tipoProveedor"]);
			
			//	Agregamos al array de fiscales el campo fecha
			$fiscal['fecha'] = $fecha;
			print_r("<br />");
			print_r("<br />");
			if($tipo == "CL"){
				if($fiscal["rfc"] != "XAXX010101000") {
				    $select = $dbAdapter->select()->from("Fiscales")->where("rfc=?",$fiscal["rfc"]);
				    $rowFiscales = $select->query()->fetchAll();
				    //print_r(count($rowFiscales));
				    if(count($rowFiscales) > 1) {
				        throw new Exception("Error: <strong>".$fiscal["razonSocial"]."</strong> ya esta dado de alta en el sistema, RFC duplicado");
				        
				    }
				}
			}elseif($tipo == "PR"){
				if($fiscal["rfc"] != "XBXX010101000") {
				    $select = $dbAdapter->select()->from("Fiscales")->where("rfc=?",$fiscal["rfc"]);
				    $rowFiscales = $select->query()->fetchAll();
				    //print_r(count($rowFiscales));
				    if(count($rowFiscales) > 1) {
				        throw new Zend_Controller_Action_Exception("Error: <strong>".$fiscal["razonSocial"]."</strong> ya esta dado de alta en el sistema, RFC duplicado");
				    }
				}
			}
			
			//No genero error por lo que procedemos a insertar en la tabla
			
			$dbAdapter->insert("Fiscales", array("rfc"=>$fiscal['rfc'],"razonSocial"=>$fiscal['razonSocial'], "fecha"=>$fiscal['fecha']));
			// Obtenemos el id autoincrementable de la tabla Fiscales
			$idFiscales = $dbAdapter->lastInsertId("Fiscales","idFiscales");
			// Creamos registro en la tabla Empresa
			$dbAdapter->insert("Empresa", array("idFiscales"=>$idFiscales));
			// Obtenemos el Id de T.Empresa paraar en Empresas, Clientes o Proveedores 
			$idEmpresa = $dbAdapter->lastInsertId("Empresa", "idEmpresa");
			//Insertamos en empresa, cliente o proveedor
			switch ($tipo) {
				case 'EM':
					$dbAdapter->insert("Empresas", array("idEmpresa"=>$idEmpresa,"consecutivo"=>0, "regFiscal"=>$fiscal['regFiscal']));
					$dbAdapter->insert("Clientes", array("idEmpresa"=>$idEmpresa, "cuenta"=>$cuenta,"saldo"=>"0"));
					$dbAdapter->insert("Proveedores", array("idEmpresa"=>$idEmpresa,"idTipoProveedor"=>$tipoProveedor,"cuenta"=>$cuenta,"saldo"=>"0"));
					break;	
				case 'CL':
					$dbAdapter->insert("Clientes", array("idEmpresa"=>$idEmpresa,"cuenta"=>$cuenta,"saldo"=>"0"));
					break;
				case 'PR':
					$dbAdapter->insert("Proveedores", array("idEmpresa"=>$idEmpresa,"idTipoProveedor"=>$tipoProveedor,"cuenta"=>$cuenta, "saldo"=>"0"));
					break;
			}
			//Insertamos en domicilio
			unset($datos[1]["idEstado"]);
			print_r($datos[1]);
			print_r("<br />");
			$dbAdapter->insert("Domicilio", $datos[1]);
			$idDomicilio = $dbAdapter->lastInsertId("Domicilio","idDomicilio");
			$dbAdapter->insert("FiscalesDomicilios", array("idFiscales"=>$idFiscales,"idDomicilio"=>$idDomicilio,"fecha" => $fecha,"esSucursal"=>"N"));
			
			//Insertamos en telefono
			$dbAdapter->insert("Telefono", $datos[2]);
			$idTelefono = $dbAdapter->lastInsertId("Telefono", "idTelefono");
			$dbAdapter->insert("FiscalesTelefonos", array("idFiscales"=>$idFiscales,"idTelefono"=>$idTelefono, "fecha"=>date("Y-m-d h:i:s",time()) ));
			
			//Insertamos en email
			$dbAdapter->insert("Email", $datos[3]);
			$idEmail = $dbAdapter->lastInsertId("Email","idEmail");
			$dbAdapter->insert("FiscalesEmail", array("idFiscales"=>$idFiscales,"idEmail"=>$idEmail, "fecha"=>date("Y-m-d h:i:s",time())));
			
			///$dbAdapter->commit();
			
		}catch(Exception $ex){
		    $dbAdapter->rollBack();
		    print_r($ex->getMessage());
		    //throw new Zend_Controller_Action_Exception("Error: Empresa ya registrada en el sistema");
		    throw new Exception("Error: Empresa ya registrada en el sistema");
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
	
	/**
	 * Obtenemos el idEmpresas de la T.Empresas correspondiente al idEmpresa de la T.Empresa proporcionado
	 */
	public function getEmpresasByIdEmpresa($idEmpresa) {
		$tablaEmpresas = $this->tablaEmpresas;
		$select = $tablaEmpresas->select()->from($tablaEmpresas)->where("idEmpresa=?",$idEmpresa);
		$rowEmpresas = $tablaEmpresas->fetchRow($select)->toArray();
		
		return $rowEmpresas;
	}
	
	/**
	 * Obtenemos el idClientes de la T.Clientes correspondiente al idEmpresa de la T.Empresa proporcionado
	 */
	public function getClienteByIdEmpresa($idEmpresa) {
		$tablaClientes = $this->tablaClientes;
		$select = $tablaClientes->select()->from($tablaClientes)->where("idEmpresa=?",$idEmpresa);
		$rowCliente = $tablaClientes->fetchRow($select)->toArray();
		
		return $rowCliente;
	}
	
	/**
	 * Obtenemos el idProveedores de la T.Proveedores correspondiente al idEmpresa de la T.Empresa proporcionado
	 */
	public function getProveedorByIdEmpresa($idEmpresa) {
		$tablaProveedores= $this->tablaProveedores;
		$select = $tablaProveedores->select()->from($tablaProveedores)->where("idEmpresa=?",$idEmpresa);
		$rowProveedor = $tablaProveedores->fetchRow($select)->toArray();
		
		return $rowProveedor;
	}
	
	/**
	 * Obtenemos solo los Id's Fiscales de las Empresas operables.
	 */
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
	
	/**
	 * Obtenemos los registros de la T.Fiscales correspondientes a las empresas operables
	 */
	public function obtenerFiscalesEmpresas() {
		$tablaEmpresas = $this->tablaEmpresas;
		$select = $tablaEmpresas->select()->from($tablaEmpresas,array('idEmpresa'));
		$rowsEmpresas = $tablaEmpresas->fetchAll($select)->toArray();
		
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa, array('idFiscales'))->where("idEmpresa IN (?)", array_values($rowsEmpresas));
		$rowsEmpresa = $tablaEmpresa->fetchAll($select)->toArray();
		
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()->from($tablaFiscales)->where('idFiscales IN (?)', array_values($rowsEmpresa))->order(array('razonSocial ASC'));
		$fiscales = $tablaFiscales->fetchAll($select)->toArray();
		return $fiscales;
	}
	
	public function obtenerEmpresasClientes(){
		$tablaEmpresa = $this->tablaEmpresa;
		$tablaClientes = $this->tablaClientes;
		
		$rowsClientes = $tablaClientes->fetchAll();
		
		$eClientes = array();
		
		foreach ($rowsClientes as $row) {
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa = ?", $row->idEmpresa);
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
			
			$eClientes[] = $rowEmpresa->toArray();
		}
		
		return $eClientes;
	}
	
	public function obtenerEmpresasProveedores(){
		$tablaEmpresa = $this->tablaEmpresa;
		$tablaProveedores = $this->tablaProveedores;
		
		$rowsProveedores = $tablaProveedores->fetchAll();
		
		$eProveedores = array();
		
		foreach ($rowsProveedores as $row) {
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa = ?", $row->idEmpresa);
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
			
			$eProveedores[] = $rowEmpresa->toArray();
		}
		
		return $eProveedores;
	}
	
	/**
	 * Obtenemos todos los clientes asociados a la empresa (Consulta a Tabla ClientesEmpresa)
	 */
	public function obtenerClientesEmpresa($idFiscales) {
		
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales=?",$idFiscales);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);
		
		$tablaEmpresas = $this->tablaEmpresas;
		$select = $tablaEmpresas->select()->from($tablaEmpresas)->where("idEmpresa=?",$rowEmpresa->idEmpresa);
		$rowEmpresas = $tablaEmpresas->fetchRow($select);
		
		$tablaClientesEmpresa = $this->tablaClientesEmpresa;
		$select = $tablaClientesEmpresa->select()->from($tablaClientesEmpresa)->where("idEmpresas", $rowEmpresas->idEmpresas);
		$rowsClientes = $tablaClientesEmpresa->fetchAll($select);
		
		$clientesFiscales = array();
		
		if(is_null($rowsClientes)){
			return null;
		}else{
			//return $rowsClientes->toArray();
			$idsClientes = array();
			foreach ($rowsClientes as $rowCliente) {
				$idsClientes[] = $rowCliente->idCliente;
			}
			
			$tablaClientes = $this->tablaClientes;
			$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente IN (?)", array_values($idsClientes));
			print_r($select->__toString());
		}
		
		
		
		
	}
	
	/**
	 * Obtenemos todos los proveedores asociados a la empresa (Consulta a Tabla ProveedoresEmpresa)
	 */
	 public function obtenerProveedoresEmpresa($idFiscales) {
	 	$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales=?",$idFiscales);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);
		
		$tablaEmpresas = $this->tablaEmpresas;
		$select = $tablaEmpresas->select()->from($tablaEmpresas)->where("idEmpresa=?",$rowEmpresa->idEmpresa);
		$rowEmpresas = $tablaEmpresas->fetchRow($select);
		
		$tablaProveedoresEmpresa = $this->tablaProveedoresEmpresa;
		$select = $tablaProveedoresEmpresa->select()->from($tablaProveedoresEmpresa)->where("idEmpresas=?", $rowEmpresas->idEmpresas);
		$rowsProveedores = $tablaProveedoresEmpresa->fetchAll($select);
		
		if(is_null($rowsProveedores)) {
			return null;
		}else{
			return $rowsProveedores->toArray();
		}
		
	 }
	
	/**
	 * Obtiene todos los elementos de la Tabla Tipo Proveedor
	 * @return array()
	 */
	public function obtenerTipoProveedor()
	{
		$tablaTipoProveedor = $this->tablaTipoProveedor;
		$select = $tablaTipoProveedor->select()->from($tablaTipoProveedor)->order("descripcion ASC");
		$rows = $tablaTipoProveedor->fetchAll($select);
		if(is_null($rows)){
			return null;
		}else{
			return $rows->toArray();
		}
		
	}
	
	public function obtenerTipoProv($idFiscales){
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idFiscales=?",$idFiscales);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);	
	}
	/*Obtiene tipoProveedor */
	public function obtenerTipoProveedorIdTipoProveedor($idTipoProveedor){
		$tablaTipoProveedor = $this->tablaTipoProveedor;
		$select = $tablaTipoProveedor->select()->from($tablaTipoProveedor)->where("idTipoProveedor = ?",$idTipoProveedor);
		$rowTipoProveedor = $tablaTipoProveedor->fetchRow($select);
		
		$tipoProveedorModel = new Sistema_Model_TipoProveedor($rowTipoProveedor->toArray());
		$tipoProveedorModel->setIdTipoProveedor($rowTipoProveedor->idTipoProveedor);
		
		return $tipoProveedorModel;
	}
	/**
	 * Agrega una nueva sucursal al domicilio fiscal.
	 */
	public function agregarSucursal($idFiscales ,array $datos)
	{
		$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
		$dbAdapter->beginTransaction();
		
		try{
			
			$datosSucursal = $datos[0];
			$datosDomicilio = $datos[1];
			$datosTelefonos = $datos[2];
			$datosEmails = $datos[3];
			//========================================================= Insertar en Domicilio
			unset($datosDomicilio["idEstado"]);
			$dbAdapter->insert("Domicilio", $datosDomicilio);
			$idDomicilio = $dbAdapter->lastInsertId("Domicilio","idDomicilio");
			//========================================================= Insertar en Telefono
			$dbAdapter->insert("Telefono", $datosTelefonos);
			$idTelefono = $dbAdapter->lastInsertId("Telefono","idTelefono");
			//========================================================= Insertar en Email
			$dbAdapter->insert("Email", $datosEmails);
			$idEmail = $dbAdapter->lastInsertId("Email","idEmail");
			//========================================================= Insertar en Sucursal
			$datosSucursal["idFiscales"] = $idFiscales;
			$datosSucursal["idDomicilio"] = $idDomicilio;
			$datosSucursal["idsTelefonos"] = $idTelefono. ",";
			$datosSucursal["idsEmails"] = $idEmail.",";
			$dbAdapter->insert("Sucursal", $datosSucursal);
			
		
		$dbAdapter->commit();
		}catch(exception $ex){
			$dbAdapter->rollBack();
			print_r($ex->getMessage());
			//throw new Util_Exception_BussinessException("Error");	
		}
		
	}
	
	public function obtenerSucursal($idSucursal){
		$tablaSucursal = $this->tablaSucursal;
		$select = $tablaSucursal->select()->from($tablaSucursal)->where("idSucursal=?",$idSucursal)->where("idCoP=?",$idCoP);
		$rowSucursal = $tablaSucursal->fetchRow($select);
		
		if(is_null($rowSucursal)){
			return null;
		}else{
			return $rowSucursal->toArray();
		}
	}
	public function obtenerSucursales($idFiscales){
		
		
		$tablaSucursal = $this->tablaSucursal;
		$select = $tablaSucursal->select()->from($tablaSucursal)->where("idFiscales=?",$idFiscales);
		$rowsSucursales = $tablaSucursal->fetchAll($select);
		
		if(is_null($rowsSucursales)){
			return null;
		}else{
			return $rowsSucursales->toArray();
		}
		
	}
	public function obtenerSucursalesEmpresas($idEmpresas){
		
		$tablaEmpresas = $this->tablaEmpresas;
		$select = $tablaEmpresas->select()->from($tablaEmpresas)->where("idEmpresas=?",$idEmpresas);
		$rowEmpresas = $tablaEmpresas->fetchRow($select);
		//print_r("$select");
		
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa=?",$rowEmpresas->idEmpresa);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);
		//print_r("$select");
		
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales=?",$rowEmpresa->idFiscales);
		$rowFiscales = $tablaFiscales->fetchRow($select);
		
		$tablaSucursal = $this->tablaSucursal;
		$select = $tablaSucursal->select()->from($tablaSucursal)->where("idFiscales=?", $rowFiscales->idFiscales);
		$rowsSucursales = $tablaSucursal->fetchAll($select);
		
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
	 
	public function obtieneEmpresas($idEmpresa){
		$tablaEmpresas = $this->tablaEmpresas;
		$select = $tablaEmpresas->select()->from($tablaEmpresas)->where("idEmpresa=?",$idEmpresa);
		$rowEmpresas = $tablaEmpresas->fetchRow($select);
		
		try{
			//$rowEmpresas = $tablaEmpresas->fetchRow($select);
			if(is_null($rowEmpresas)){
				return null;
			}else{
				return $rowEmpresas->toArray();
			}
			
		}catch(Exception $ex){
			print_r("Excepcion Lanzada: <strong>" . $ex->getMessage()."</strong>");
		}
		
		
	} 
	public function agregarEmailSucursal($idSucursal, Sistema_Model_Email $email){
		
	}
	
	public function editarTelefonoSucursal($idSucursal, array $arrayTelefono){}
	public function editarEmailSucursal($idSucursal, array $arrayEmail){}
	
	public function eliminarTelefonoSucursal($idSucursal, $idTelefono){}
	public function eliminarEmailSucursal($idSucursal, $idEmail){}
	
	
}
