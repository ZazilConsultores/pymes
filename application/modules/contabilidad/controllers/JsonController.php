<?php

class Contabilidad_JsonController extends Zend_Controller_Action
{
	
	private $empresaDAO;
	private $fiscalesDAO;
	private $productosDAO;
	private $impuestoProductosDAO;
	private $facturaClienteDAO;
	private $pagoProveedorDAO;


    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
        
        $this->empresaDAO = new Sistema_DAO_Empresa;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		$this->facturaDAO = new Contabilidad_DAO_FacturaProveedor;
		$this->productosDAO = new Inventario_DAO_Producto;
		$this->vendedorDAO = new Sistema_DAO_Vendedores;
		$this->impuestoProductosDAO = new Contabilidad_DAO_Impuesto;
		$this->facturaClienteDAO = new Contabilidad_DAO_FacturaCliente;
		$this->pagoProveedorDAO = new Contabilidad_DAO_PagoProveedor;
		
		$this->bancosEmpresaDAO = new Contabilidad_DAO_Fondeo;
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaClientesEmpresa = new Sistema_Model_DbTable_ClientesEmpresa(array('db'=>$dbAdapter));;
		

    }

    public function indexAction(){
    	
    }
	
	public function clienteseAction() {
		$idFiscales = $this->getParam("idFiscales");
		
		$fiscalesClientes = $this->fiscalesDAO->getFiscalesClientesByIdFiscalesEmpresa($idFiscales);
		if(!is_null($fiscalesClientes)){
			echo Zend_Json::encode($fiscalesClientes);
		}else{
			echo Zend_Json::encode(array());
		}
		
	}
	
	public function proveedoreseAction() {
		$idFiscales = $this->getParam("idFiscales");
		
		$fiscalesProveedores = $this->fiscalesDAO->getFiscalesProveedoresByIdFiscalesEmpresa($idFiscales);
		if(!is_null($fiscalesProveedores)){
			echo Zend_Json::encode($fiscalesProveedores);
		}else{
			echo Zend_Json::encode(array());
		}
	}
	
	public function asocclienteAction() {
		//Si llegamos aqui es por que en verdad se hace la asociacion
		$idFiscalesEmpresa = $this->getParam("idFiscalesEmpresa");
		$idFiscalesCliente = $this->getParam("idFiscalesCliente");
		
		//print_r($idFiscalesCliente . "<br />");
		//print_r($idFiscalesEmpresa . "<br />");
		
		$fiscalesDAO = $this->fiscalesDAO;
		$empresaDAO = $this->empresaDAO;
		
		$empresaEmpresa = $empresaDAO->obtenerEmpresaPorIdFiscales($idFiscalesEmpresa);
		$empresaCliente = $empresaDAO->obtenerEmpresaPorIdFiscales($idFiscalesCliente);
		
		//print_r($empresaEmpresa);
		//print_r("<br />");
		//print_r($empresaCliente);
		
		$empresa = $fiscalesDAO->getEmpresaByIdFiscales($idFiscalesEmpresa);
		$cliente = $fiscalesDAO->getClienteByIdFiscales($idFiscalesCliente);
		
		$tablaClientesEmpresa = $this->tablaClientesEmpresa;
		print_r("<br />");
		print_r($fiscalesDAO->getEmpresaByIdFiscales($idFiscalesEmpresa));
		print_r("<br />");
		print_r($fiscalesDAO->getClienteByIdFiscales($idFiscalesCliente));
	}

	

	public function bancosempresaAction() {
		$idBanco = $this->getParam("idBanco");
		$bancosEmpresa = $this->bancosEmpresaDAO->obtenerBancosEmpresa($idBanco);
		
	}
	
	//Revisar si aun se utiliza la funcion productosimpuestos
	public function productosimpuestosAction(){
		$idProducto = $this->getParam($idProducto);
		$factura = $this->facturaDAO->buscarProducto($idProducto);
		//echo Zend_Json::encode($factura);
	}
	
	public function productosAction() {
		$idProducto = $this->getParam("idProducto");
		
		$productos = $this->productosDAO->obtenerProducto($idProducto);
		if(!is_null($productos)){
			echo Zend_Json::encode($productos);
		}else{
			echo Zend_Json::encode(array());
		}
		
	}
	
	public function vendedorAction() {
		$idVendedor = $this->getParam("idVendedor");
		
		$vendedor = $this->vendedorDAO->obtenerVendedor($idVendedor);
		if(!is_null($vendedor)){
			echo Zend_Json::encode($vendedor);
		}else{
			echo Zend_Json::encode(array());
		}
		
	}
	
	
	public function impuestosAction() {
		$idImpuesto = $this->getParam("idImpuesto");
		
		$impuestoProducto = $this->impuestoProductosDAO->obtenerImpuestoProductos($idImpuesto);
		
		if(!is_null($impuestoProducto)){
			echo Zend_Json::encode($impuestoProducto);
		}else{
			echo Zend_Json::encode(array());
		}	
		
	}
	
	//Obtener ImpuestoProducto
	public function impuestoproductoAction() {
		//$idImpuesto = $this->getParam("idImpuesto");
		$idProducto = $this->getParam("idProducto");
		
		$impuestoProducto = $this->impuestoProductosDAO->obtenerImpuestoProducto($idProducto);
		
		if(!is_null($impuestoProducto)){
			echo Zend_Json::encode($impuestoProducto);
		}else{
			echo Zend_Json::encode(array());
		}		
	}
	
	//Obtenemos las Empresas para ediatar el consecutivo
	public function sucursalAction() {
		$idSucursal = $this->getParam("idSucursal");
		
		$sucursal = $this->empresaDAO->obtenerSucursal($idSucursal);
		if(!is_null($sucursal)){
			echo Zend_Json::encode($sucursal);
		}else{
			echo Zend_Json::encode(array());
		}	
	}
	
	public function facturaAction() {
		//$idImpuesto = $this->getParam("idImpuesto");
		$idSucursal = $this->getParam("idSucursal");
		
		//$pagoProveedor = $this->pagoProveedorDAO->obtieneFacturaProveedor($idSucursal);
		$pagoProveedor = $this->pagoProveedorDAO->obtieneFacturaProveedor($idSucursal);
		if(!is_null($pagoProveedor)){
			echo Zend_Json::encode($pagoProveedor);
		}else{
			echo Zend_Json::encode(array());
		}		
	}
	
	//Buscamos en cuentasxp para facturas proveedor por idSucursal
	public function pagosAction(){
		$idSucursal = $this->getParam("idSucursal");
		$idCoP = $this->getParam("idCoP");
		$numeroFactura = $this->getParam("numeroFactura");
		
		$cuentasxp = $this->pagoProveedorDAO->busca_Cuentasxp($idCoP);
		if(!is_null($cuentasxp)){
			echo Zend_Json::encode($cuentasxp);	
		}else{
			echo Zend_Json::encode(array());
		}		
	}
	
}