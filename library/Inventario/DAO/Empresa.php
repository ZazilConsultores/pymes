<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Empresa implements Inventario_Interfaces_IEmpresa {
	
	private $tablaEmpresa;
	private $tablaEmpresas;
	private $tablaClientes;
	private $tablaProveedores;
	
	private $tablaFiscales;
	private $tablaDomicilio;
	private $tablaTelefono;
	private $tablaEmail;
	
	function __construct() {
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
	
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas;
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes;
		$this->tablaProveedores = new Sistema_Model_DbTable_Proveedores;
		
		$this->tablaFiscales = new Sistema_Model_DbTable_Fiscales;
		$this->tablaDomicilio = new Sistema_Model_DbTable_Domicilio;
		$this->tablaTelefono = new Sistema_Model_DbTable_Telefono;
		$this->tablaEmail = new Sistema_Model_DbTable_Email;
	}
	
	public function obtenerEmpresas() {
		$tablaEmpresas = $this->tablaEmpresas;
		$rowsEmpresas = $tablaEmpresas->fetchAll();
		
		$tablaFiscal = $this->tablaFiscales;
		$tablaDomicilio = $this->tablaDomicilio;
		
		
		$empresas = array();
		foreach ($rowsEmpresas as $rowEmpresa) {
			$empresaModel = new Sistema_Model_Empresas($rowEmpresa->toArray());
			//$empresaModel->setIdEmpresa($rowEmpresa->idEmpresa);
			// ==========================================================================
			
			
			$empresas[] = $empresaModel;
		}
		
		return $empresas;
	}
	
	public function obtenerClientes(){
		$tablaClientes=$this->tablaClientes;
		$rowClientes=$tablaClientes->fetchAll();
		
		$cliente=array();
		foreach($rowClientes as $rowCliente){
			$clienteModel = new Sistema_Model_Cliente($rowCliente->toArray());
			$clienteModel->setIdCliente($rowCliente->idCliente);
			
			$cliente[]=$clienteModel;
		}
		return $cliente;
	}
	
	public function obtenerProveedores(){
		$tablaProvedores= $this->tablaProveedores;
		$rowProveedores=$tablaProvedores->fetchAll();
		
		$proveedor = array();
		foreach ($rowProveedores as $rowProveedor){
			$proveedorModel = new Sistema_Model_Proveedor($rowProveedor->toArray());
			$proveedorModel->setIdProveedor($rowProveedor->idProveedor);
			
			$proveedor[] = $proveedorModel;
		}
		return $proveedor;
		
	}
	
	public function obtenerInformacion($idEmpresa)
	{
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where('idEmpresa = ?', $idEmpresa);
		$rowEmpresa = $tablaEmpresa->fetchRow($select);
		
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()
			->setIntegrityCheck(false)
			->from($tablaFiscales, array('rfc', 'razonSocial'))
			->join('FiscalesDomicilios', 'Fiscales.idFiscales = FiscalesDomicilios.idFiscales', array())
			->distinct()
			->join('Domicilio', "Domicilio.idDomicilio = FiscalesDomicilios.idDomicilio", array('calle', "colonia", "codigoPostal", "numeroInterior", "numeroExterior"))
			->join('FiscalesTelefonos', 'Fiscales.idFiscales = FiscalesTelefonos.idfiscales',array())
			->join('Telefono', "Telefono.idTelefono=FiscalesTelefonos.idTelefono", array('telefono'))
			->join('FiscalesEmail', 'Fiscales.idFiscales = FiscalesEmail.idFiscales',array())
			->join('Email',"Email.idEmail=FiscalesEmail.idEmail", array('email'))
			->join('Municipio', "Municipio.idMunicipio = Domicilio.idMunicipio", array('Municipio'))
			->join('Estado',"Estado.idEstado = Municipio.idEstado",array('Estado'))
			->where("Fiscales.idFiscales = ?", $rowEmpresa->idFiscales);
			
		return $tablaFiscales->fetchRow($select);			
		//return $select->__toString();
		
	}
	public function obtenerInformacionEmpresasIdFiscales()
	{
		
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()
			->setIntegrityCheck(false)
			->from($tablaFiscales, array('idFiscales','rfc', 'razonSocial'))
			->join('empresa', 'empresa.idFiscales = Fiscales.idFiscales', array())
			->join('empresas','empresas.idEmpresa = Fiscales.idFiscales', array());
			
		//	return $select->__toString();
		return $tablaFiscales->fetchAll($select);
		
	}

	
	
	public function obtenerInformacionEmpresas()
	{
		
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()
			->setIntegrityCheck(false)
			->from($tablaFiscales, array('idFiscales','rfc', 'razonSocial'))
			->join('FiscalesDomicilios', 'Fiscales.idFiscales = FiscalesDomicilios.idFiscales', array())
			->join('Domicilio', "Domicilio.idDomicilio = FiscalesDomicilios.idDomicilio", array('calle', "colonia", "codigoPostal", "numeroInterior", "numeroExterior"))
			->join('FiscalesTelefonos', 'Fiscales.idFiscales = FiscalesTelefonos.idfiscales',array())
			->join('Telefono', "Telefono.idTelefono=FiscalesTelefonos.idTelefono", array('telefono'))
			->join('FiscalesEmail', 'Fiscales.idFiscales = FiscalesEmail.idFiscales',array())
			->join('Email',"Email.idEmail=FiscalesEmail.idEmail", array('email'))
			->join('Municipio', "Municipio.idMunicipio = Domicilio.idMunicipio", array('Municipio'))
			->join('Estado',"Estado.idEstado = Municipio.idEstado", array('Estado'))
			->where("Fiscales.idFiscales = ?", $rowEmpresa->idFiscales);
			
		//	return $select->__toString();
		return $tablaFiscales->fetchAll($select);
		
	}
	
	public function crearEmpresa($tipo, Sistema_Model_Fiscal $fiscal, Sistema_Model_Domicilio $domicilio, Sistema_Model_Telefono $telefono, Sistema_Model_Email $email){
		$tablaEmpresa = $this->tablaEmpresa;
		$tablaFiscales = $this->tablaFiscales;
		$tablaDomicilio = $this->tablaDomicilio;
		$tablaTelefono = $this->tablaTelefono;
		$tablaEmail = $this->tablaEmail;
		
		$tablaEmpresas = $this->tablaEmpresas;
		$tablaClientes = $this->tablaClientes;
		$tablaProveedores = $this->tablaProveedores;
		//   ============================================================ Insertamos Fiscales
		$hashFiscal = $fiscal->getHash();
		$fiscal->setHash($hashFiscal);
		$tablaFiscales->insert($fiscal->toArray());
		
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("hash = ?", $hashFiscal);
		$rowFiscal = $tablaFiscales->fetchRow($select);
		
		
		
		switch ($tipo) {
			case 'EM':
				
				break;
			case 'CL':
				
				break;
			case 'PR':
				
				break;
		}
		
	}
}





