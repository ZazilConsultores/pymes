<?php
   class Sistema_DAO_Vendedores implements Sistema_Interfaces_IVendedores {
   
	
   	private $tablaVendedores;
	private $tablaDomicilio;
	private $tablaTelefono;
	private $tablaEmail;
	
public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaVendedores = new Sistema_Model_DbTable_Vendedor(array('db'=>$dbAdapter));	
		$this->tablaDomicilio = new Sistema_Model_DbTable_Domicilio(array('db'=>$dbAdapter));
		$this->tablaTelefono = new Sistema_Model_DbTable_Telefono(array('db'=>$dbAdapter));
		$this->tablaEmail = new Sistema_Model_DbTable_Email(array('db'=>$dbAdapter));
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
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
		
		try {
			$nombre = $datos[0];
			//$nombre['estatus']= 'A'
			
			$mnombre = array(
					'nombre' => $nombre['nombre'],
					'claveVendedor'=>$nombre['claveVendedor'],
					'comision'=>$nombre['comision'],
					'estatus'=>$nombre='A',
					'fechaAlta'=>date("Y-m-d H:i:s", time())
					
				);
			//print_r($mnombre);
			
			//Insertamos en domicilio
			unset($datos[1]["idEstado"]);
			$dbAdapter->insert("Domicilio", $datos[1]);
			$idDomicilio = $dbAdapter->lastInsertId("Domicilio","idDomicilio");
			print_r("<br />");
			//print_r($idDomicilio);
			//Insertamos en telefono
			$dbAdapter->insert("Telefono", $datos[2]);
			$idTelefono = $dbAdapter->lastInsertId("Telefono", "idTelefono");
			
			//Insertamos en email
			$dbAdapter->insert("Email", $datos[3]);
			$idEmail = $dbAdapter->lastInsertId("Email","idEmail");
			
			// Obtenemos el Id de T.Empresa para insertar en Empresas, Clientes o Proveedores 
			$idEmpresa = $dbAdapter->lastInsertId("Empresa", "idEmpresa");
			
			//Insertamos en Tabla vendedores
			$dbAdapter->insert("Vendedor", array("idDomicilio"=>$idDomicilio,"idTelefono"=>$idTelefono,"nombre"=>$mnombre['nombre'],"claveVendedor"=>$mnombre['claveVendedor'],"estatus"=>$mnombre['estatus'],
			"fechaAlta"=>$mnombre['fechaAlta'],"comision"=>$mnombre['comision'],"idEmail"=>$idEmail));
			
		$dbAdapter->commit();
		}catch(Exception $ex){
			$dbAdapter->rollBack();
			print_r($ex->getMessage());
			throw new Util_Exception_BussinessException(" Vendedor ya registrado en el sistema");
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
