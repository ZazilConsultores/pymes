<?php
	
class Contabilidad_JsonController extends Zend_Controller_Action
{

    private $bancoDAO = null;

    private $fiscalesDAO = null;

    private $impuestoProductosDAO = null;

    private $empresaDAO = null;

    private $pagosDAO = null;
	private $cobrosDAO = null;
	private $facturaCliDAO = null;

    public function init()
    {
	    	 $auth = Zend_Auth::getInstance();
	        $dataIdentity = $auth->getIdentity();
	        /* Initialize action controller here */
	        $this->bancoDAO = new Contabilidad_DAO_Banco;
			$this->impuestoProductosDAO = new Contabilidad_DAO_Impuesto;
			$this->fiscalesDAO = new Sistema_DAO_Fiscales;
			$this->pagosDAO = new Contabilidad_DAO_PagoProveedor;
			$this->cobrosDAO = new Contabilidad_DAO_CobroCliente;
			$this->empresaDAO = new Sistema_DAO_Empresa;
			$this->facturaCliDAO = new Contabilidad_DAO_FacturaCliente;
			
			$this->_helper->layout->disableLayout();
			$this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
	        // action body
    }

    public function bancosempresaAction()
    {
	    	$idEmpresa = $this->getParam("emp");
			//print_r($idEmpresa);
			
			$bancosEmpresa = $this->bancoDAO->obtenerBancosEmpresa($idEmpresa);
			
			if(!is_null($bancosEmpresa)){
				echo Zend_Json::encode($bancosEmpresa);
			}else{
				echo Zend_Json::encode(array());
			}
    }

    public function impuestosAction()
    {
	        // action body
	        $idImpuesto = $this->getParam("idImpuesto");
			
			$impuestoProducto = $this->impuestoProductosDAO->obtenerImpuestoProductos($idImpuesto);
			
			if(!is_null($impuestoProducto)){
				echo Zend_Json::encode($impuestoProducto);
			}else{
				echo Zend_Json::encode(array());
			}
    }

    public function clienteseAction()
    {
	        // action body
	        $idFiscales = $this->getParam("idFiscales");
			
			$fiscalesClientes = $this->fiscalesDAO->getFiscalesClientesByIdFiscalesEmpresa($idFiscales);
			if(!is_null($fiscalesClientes)){
				echo Zend_Json::encode($fiscalesClientes);
			}else{
				echo Zend_Json::encode(array());
			}
			
    }

    public function proveedoreseAction()
    {
	        // action body
	        $idFiscales = $this->getParam("idFiscales");
			
			$fiscalesProveedores = $this->fiscalesDAO->getFiscalesProveedoresByIdFiscalesEmpresa($idFiscales);
			if(!is_null($fiscalesProveedores)){
				echo Zend_Json::encode($fiscalesProveedores);
			}else{
				echo Zend_Json::encode(array());
			}
    }

    public function sucursaleseAction()
    {
        // action body
        
        $idFiscales = $this->getParam("idFiscales");
			
		$sucursales = $this->empresaDAO->obtenerSucursales($idFiscales);
		//$sucursales = $this->empresaDAO->obtenerSucursalesEmpresas($idEmpresas);
		if(!is_null($sucursales)){
			echo Zend_Json::encode($sucursales);
		}else{
			echo Zend_Json::encode(array());
		}
        
    }

    public function sucursalAction()
    {
	        // action body
	        $idSucursal = $this->getParam("idSucursal");
			
			$sucursal = $this->empresaDAO->obtenerSucursal($idSucursal);
			if(!is_null($sucursal)){
				echo Zend_Json::encode($sucursal);
			}else{
				echo Zend_Json::encode(array());
			}	
    }

    public function asociaceAction()
    {
        // action body
        $idEmpresa = $this->getParam("em");
        $idCliente = $this->getParam("cl");
		// Obtenemos los registros de Empresa correspondientes
		$empresaEmpresa = $this->empresaDAO->obtenerEmpresaPorIdFiscales($idEmpresa);
		$empresaCliente = $this->empresaDAO->obtenerEmpresaPorIdFiscales($idCliente);
		// Obtenemos los registros de T.Empresas y la T.Clientes
		$empresa = $this->empresaDAO->getEmpresasByIdEmpresa($empresaEmpresa["idEmpresa"]);
		$cliente = $this->empresaDAO->getClienteByIdEmpresa($empresaCliente["idEmpresa"]);
		
		$this->fiscalesDAO->asociateClienteEmpresa($empresa['idEmpresas'], $cliente['idCliente']);
		
		echo Zend_Json::encode("Cliente asociado a Empresa!!!");
        
    }

    public function asociapeAction()
    {
        $idEmpresa = $this->getParam("em");
		$idProveedor = $this->getParam("pr");
		//Obtenemos los registros de empresa correspondiente
		$empresaEmpresa = $this->empresaDAO->obtenerEmpresaPorIdFiscales($idEmpresa);
		$empresaProveedor  = $this->empresaDAO->obtenerEmpresaPorIdFiscales($idProveedor);
		$empresa = $this->empresaDAO->getEmpresasByIdEmpresa($empresaEmpresa["idEmpresa"]);
		$proveedor = $this->empresaDAO->getProveedorByIdEmpresa($empresaProveedor["idEmpresa"]);
		$this->fiscalesDAO->asociateProveedorEmpresa($empresa['idEmpresas'], $proveedor['idProveedores']);
    }

    public function buscafacxpAction()
    {
        // action body
        $idSucursal = $this->getParam("idSucursal");
        $proveedor = $this->getParam("pro");
		
		$buscafacxp = $this->pagosDAO->busca_Cuentasxp($idSucursal, $proveedor);
		if(!is_null($buscafacxp)){
			echo Zend_Json::encode($buscafacxp);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function buscapagoxpAction()
    {
        // action body
        $idFactura = $this->getParam("idFactura");
     
		$buscapago= $this->pagosDAO->busca_PagosCXP($idFactura);
		if(!is_null($buscapago)){
			echo Zend_Json::encode($buscapago);
		}else{
			echo Zend_Json::encode(array());
		}
    }
	
	public function buscacobroAction()
    {
        $sucu = $this->getParam("sucu");
        $cl = $this->getParam("cl");
        print_r($cl);
		
		$buscaCobro= $this->cobrosDAO->busca_Cuentasxc($sucu, $cl);
		if(!is_null($buscaCobro)){
			echo Zend_Json::encode($buscaCobro);
		}else{
			echo Zend_Json::encode(array());
		}
    }
	
	public function buscacobroxpAction()
    {
        // action body
        $idFactura = $this->getParam("idFactura");
     	$buscaCobro= $this->cobrosDAO->busca_CobrosCXC($idFactura);
		//$buscacobro= $this->cobrosDAO busca_PagosCXP($idFactura);
		if(!is_null($buscaCobro)){
			echo Zend_Json::encode($buscaCobro);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function obtenerfacturaxpAction()
    {
        // action body
        $idFactura = $this->getParam("idFactura");
		$obtenerFac= $this->pagosDAO->obtiene_Factura($idFactura);
		if(!is_null($obtenerFac)){
			echo Zend_Json::encode($obtenerFac);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function consecutivoAction()
    {
	    $idSucursal = $this->getParam("sucursal");
		$consecutivoFac= $this->facturaCliDAO->editaNumeroFactura($idSucursal);
		if(!is_null($consecutivoFac)){
			echo Zend_Json::encode($consecutivoFac);
		}else{
			echo Zend_Json::encode(array());
		}
    }
	
	public function desechabledesayunoAction()
    {
		//$desechableDesayuno= $this->facturaCliDAO->restaDesechableDesayuno();
		/*if(!is_null($desechableDesayuno)){
			echo Zend_Json::encode($desechableDesayuno);
		}else{
			echo Zend_Json::encode(array());
		}*/
    }

}






	
	
	
	
	
	
	
	
	
	
	






