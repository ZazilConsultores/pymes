<?php
   class Sistema_DAO_Vendedores implements Sistema_Interfaces_IVendedores {
   
	
   	private $tablaVendedores;
	private $tablaDomicilio;
	private $tablaTelefono;
	private $tablaEmail;
	
public function __construct() {
		//$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaVendedores = new Sistema_Model_DbTable_Vendedor;	
		$this->tablaDomicilio = new Sistema_Model_DbTable_Domicilio;
		$this->tablaTelefono = new Sistema_Model_DbTable_Telefono;
		$this->tablaEmail = new Sistema_Model_DbTable_Email;
	}
	
		
	public function generarClaveVendedor(array $claves){
		//print_r($claves);
		$tablaSubparametro = $this->tablaSubparametro;
		$claveProducto = "";
		$idsSubparametro = "";
			
		foreach ($claves as $idParametro => $idSubparametro) {
			if($idSubparametro <> "0"){
				$sub = $this->obtenerSubparametro($idSubparametro);
				$claveProducto .= $sub->getClaveSubparametro();
				$idsSubparametro .=  $sub->getIdSubparametro() . ",";
			}
		}
		
		return $claveProducto;
	}
	

	 public function crearVendedor(array $datos){
		//$tablaVendedor = $this->tablaVendedores;
		//$tablaVendedor->insert($datos->toArray());
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		try {
			$nombre = $datos[0];
			//$nombre['estatus']= 'A';
			
			print_r("<br />");
			print_r("<br />");
			$domicilio = $datos[1];
			print_r($domicilio);
			print_r("<br />");
			$telefono = $datos[2];
			print_r($telefono);
			print_r("<br />");
			$email = $datos[3];
			print_r($email);
			print_r("<br />");
			
			$mnombre = array(
					'nombre' => $nombre['nombre'],
					'claveVendedor'=>$nombre['claveVendedor'],
					'comision'=>$nombre['comision'],
					'estatus'=>$nombre='A',
					'fechaAlta'=>date("Y-m-d H:i:s", time())
					
				);
			print_r($mnombre);
			
			//Insertamos en domicilio
			unset($datos[1]["idEstado"]);
			$bd->insert("Domicilio", $datos[1]);
			$idDomicilio = $bd->lastInsertId("Domicilio","idDomicilio");
			print_r("<br />");
			print_r($idDomicilio);
			//Insertamos en telefono
			$bd->insert("Telefono", $datos[2]);
			$idTelefono = $bd->lastInsertId("Telefono", "idTelefono");
			
			//Insertamos en email
			$bd->insert("Email", $datos[3]);
			$idEmail = $bd->lastInsertId("Email","idEmail");
			
			// Obtenemos el Id de T.Empresa para insertar en Empresas, Clientes o Proveedores 
			$idEmpresa = $bd->lastInsertId("Empresa", "idEmpresa");
			
			//Insertamos en Tabla vendedores
			$bd->insert("Vendedor", array("idDomicilio"=>$idDomicilio,"idTelefono"=>$idTelefono,"nombre"=>$mnombre['nombre'],"claveVendedor"=>$mnombre['claveVendedor'],"estatus"=>$mnombre['estatus'],
			"fechaAlta"=>$mnombre['fechaAlta'],"comision"=>$mnombre['comision']));
			
		$bd->commit();
		}catch(Exception $ex){
			$bd->rollBack();
			print_r($ex->getMessage());
			throw new Util_Exception_BussinessException("Error: Empresa ya registrada en el sistema");
		}
		
		
	}
public function crearEmpresa(array $datos){
		
		$fecha = date('Y-m-d h:i:s', time());
		
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		
		$bd->beginTransaction();
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
					$select = $bd->select()->from("Fiscales")->where("rfc=?",$fiscal["rfc"]);
					$rowFiscales = $select->query()->fetchAll();
					//print_r(count($rowFiscales));
					if(count($rowFiscales) > 1) {
						throw new Exception("Error: <strong>".$fiscal["razonSocial"]."</strong> ya esta dado de alta en el sistema, RFC duplicado");
						
					}
				}
			}elseif($tipo == "PR"){
				if($fiscal["rfc"] != "XBXX010101000") {
					$select = $bd->select()->from("Fiscales")->where("rfc=?",$fiscal["rfc"]);
					$rowFiscales = $select->query()->fetchAll();
					//print_r(count($rowFiscales));
					if(count($rowFiscales) > 1) {
						throw new Exception("Error: <strong>".$fiscal["razonSocial"]."</strong> ya esta dado de alta en el sistema, RFC duplicado");
						
					}
				}
			}
			
			//	No genero error por lo que procedemos a insertar en la tabla
			$bd->insert("Fiscales", $fiscal);
			// Obtenemos el id autoincrementable de la tabla Fiscales
			$idFiscales = $bd->lastInsertId("Fiscales","idFiscales");
			// Creamos registro en la tabla Empresa
			$bd->insert("Empresa", array("idFiscales"=>$idFiscales));
			// Obtenemos el Id de T.Empresa para insertar en Empresas, Clientes o Proveedores 
			$idEmpresa = $bd->lastInsertId("Empresa", "idEmpresa");
			//Insertamos en empresa, cliente o proveedor
			switch ($tipo) {
				case 'EM':
					$bd->insert("Empresas", array("idEmpresa"=>$idEmpresa));
					$bd->insert("Clientes", array("idEmpresa"=>$idEmpresa, "cuenta"=>$cuenta));
					$bd->insert("Proveedores", array("idEmpresa"=>$idEmpresa,"idTipoProveedor"=>$tipoProveedor));
					break;	
				case 'CL':
					$bd->insert("Clientes", array("idEmpresa"=>$idEmpresa,"cuenta"=>$cuenta));
					break;
				case 'PR':
					$bd->insert("Proveedores", array("idEmpresa"=>$idEmpresa,"idTipoProveedor"=>$tipoProveedor));
					break;
			}
			//Insertamos en domicilio
			unset($datos[1]["idEstado"]);
			$bd->insert("Domicilio", $datos[1]);
			$idDomicilio = $bd->lastInsertId("Domicilio","idDomicilio");
			$bd->insert("FiscalesDomicilios", array("idFiscales"=>$idFiscales,"idDomicilio"=>$idDomicilio,"fecha" => $fecha,"esSucursal"=>"N"));
			
			//Insertamos en telefono
			$bd->insert("Telefono", $datos[2]);
			$idTelefono = $bd->lastInsertId("Telefono", "idTelefono");
			$bd->insert("FiscalesTelefonos", array("idFiscales"=>$idFiscales,"idTelefono"=>$idTelefono));
			
			//Insertamos en email
			$bd->insert("Email", $datos[3]);
			$idEmail = $bd->lastInsertId("Email","idEmail");
			$bd->insert("FiscalesEmail", array("idFiscales"=>$idFiscales,"idEmail"=>$idEmail));
			
			$bd->commit();
			
		}catch(Exception $ex){
			$bd->rollBack();
			print_r($ex->getMessage());
			throw new Util_Exception_BussinessException("Error: Empresa ya registrada en el sistema");
			
		}
	}
	public function obtenerVendedores(){
		$tablaVendedores = $this->tablaVendedores;
		$select = $tablaVendedores->select()->from($tablaVendedores)->order("nombre");
		$rowVendedores = $tablaVendedores->fetchAll($select);
		
		$modelVendedores = array();
		
		foreach ($rowVendedores as $rowVendedor) {
			$modelVendedor = new Sistema_Model_Vendedor($rowVendedor->toArray());
			$modelVendedor->setIdVendedor($rowVendedor->idVendedor);
			
			$modelVendedores[] = $modelVendedor;
			
		}
		
		return $modelVendedores;
	}
	
	public function obtenerVendedor($idVendedor){
		$tablaVendedores = $this->tablaVendedores;
		$select = $tablaVendedores->select()->from($tablaVendedores)->where("idVendedor = ?", $idVendedor);
		$rowVendedor = $tablaVendedores->fetchRow($select);
		
		$vendedorModel = new Sistema_Model_Vendedor($rowVendedor->toArray());
		$vendedorModel->setIdVendedor($rowVendedor->idVendedor);
		
		return $vendedorModel;
		
	}
   }
