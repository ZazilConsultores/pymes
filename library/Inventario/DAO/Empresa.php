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
	
	function __construct() {
		$this->tablaEmpresa = new Application_Model_DbTable_Empresa;
	
		$this->tablaEmpresas = new Application_Model_DbTable_Empresas;
		$this->tablaClientes = new Application_Model_DbTable_Clientes;
		$this->tablaProveedores = new Application_Model_DbTable_Proveedores;
		
		$this->tablaFiscales = new Application_Model_DbTable_Fiscales;
	}
	
	public function obtenerEmpresas(){
		$tablaEmpresas = $this->tablaEmpresas;
		$rowsEmpresas = $tablaEmpresas->fetchAll();
		print_r($rowsEmpresas);
		$empresas = array();
		foreach ($rowsEmpresas as $rowEmpresa) {
			//print_r($rowEmpresa);
			$empresaModel = new Application_Model_Empresas($rowEmpresa->toArray());
			$empresaModel->setIdEmpresa($rowEmpresa->idEmpresa);
			
			$empresas[] = $empresaModel;
		}
		print_r($empresas);
		return $empresas;
	}
	
	public function obtenerClientes(){
		$tablaClientes=$this->tablaClientes;
		$rowClientes=$tablaClientes->fetchAll();
		
		$cliente=array();
		foreach($rowClientes as $rowCliente){
			$clienteModel = new Application_Model_Cliente($rowCliente->toArray());
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
			$proveedorModel = new Application_Model_DbTable_Proveedores($rowProveedor->toArray());
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

	
	
	public function obtenerInformacionEmpresas()
	{
		
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()
			->setIntegrityCheck(false)
			->from($tablaFiscales, array('rfc', 'razonSocial'))
			->join('FiscalesDomicilios', 'Fiscales.idFiscales = FiscalesDomicilios.idFiscales', array())
			->join('Domicilio', "Domicilio.idDomicilio = FiscalesDomicilios.idDomicilio", array('calle', "colonia", "codigoPostal", "numeroInterior", "numeroExterior"))
			->join('FiscalesTelefonos', 'Fiscales.idFiscales = FiscalesTelefonos.idfiscales',array())
			->join('Telefono', "Telefono.idTelefono=FiscalesTelefonos.idTelefono", array('telefono'))
			->join('FiscalesEmail', 'Fiscales.idFiscales = FiscalesEmail.idFiscales',array())
			->join('Email',"Email.idEmail=FiscalesEmail.idEmail", array('email'))
			->join('Municipio', "Municipio.idMunicipio = Domicilio.idMunicipio", array('Municipio'))
			->join('Estado',"Estado.idEstado = Municipio.idEstado", array('Estado'));
			//->where("Fiscales.idFiscales = ?", $rowEmpresa->idFiscales);
			
		return $select->__toString();
		return $this->fetchAll($select);
		
	}
}
