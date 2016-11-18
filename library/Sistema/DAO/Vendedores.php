<?php
   class Sistema_DAO_Vendedores implements Sistema_Interfaces_IVendedores{
   	private $tablaVendedores;
	private $tablaDomicilio;
	private $tablaTelefono;
	private $tablaEmail;
	
	function __construct(){
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
	

	 public function altaVendedor(array $datos){
		
		$fechaAlta = $date('Y-m-d h:i:s', time());
		$bd = Zend_Db_Table_Abstract::getDefaultAdapter();
		$bd->beginTransaction();
		
		try {
			$nombre = $datos[0];
			$nombre['fechaAlta'] = $fechaAlta;
			$nombre['estatus']= 'A';
			print_r($nombre);
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
			//Insertamos en Tabla vendedores
			$bd->insert("Vendedor", $nombre);
			
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
			
			
		//$bd->commit();
		}catch(Exception $ex){
			$bd->rollBack();
			print_r($ex->getMessage());
			throw new Util_Exception_BussinessException("Error: Empresa ya registrada en el sistema");
		}
		
	}
   }
