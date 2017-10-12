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

    private $facturaProDAO = null;

    private $proyectoClienteDAO = null;

    private $proyectoDAO = null;

    private $notaSalidaDAO = null;

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
			$this->facturaProDAO = new Contabilidad_DAO_FacturaProveedor;
			$this->proyectoClienteDAO = new Contabilidad_DAO_ProyectoCliente;
			$this->proyectoDAO = new Contabilidad_DAO_Proyecto;
			$this->notaSalidaDAO = new Contabilidad_DAO_NotaSalida;
			
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
        $idSucursal = $this->getParam("sucu");
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
        
		$buscaCobro = $this->cobrosDAO->busca_Cuentasxc($sucu, $cl);
		if(!is_null($buscaCobro)){
			echo Zend_Json::encode($buscaCobro);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function buscacobroxpAction()
    {
        // action body
      /*  $idFactura = $this->getParam("idFactura");
     	$buscaCobro= $this->cobrosDAO->busca_CobrosCXC($idFactura);
		//$buscacobro= $this->cobrosDAO busca_PagosCXP($idFactura);
		if(!is_null($buscaCobro)){
			echo Zend_Json::encode($buscaCobro);
		}else{
			echo Zend_Json::encode(array());
		}*/
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

    public function productoxmovimientoAction()
    {
        // action body
    }

    public function totalproyectoAction()
    {
    	$idProyecto = $this->getParam("idProyecto");
		$proyectoMovto= $this->proyectoClienteDAO->obtieneProyecto($idProyecto);
		if(!is_null($proyectoMovto)){
			echo Zend_Json::encode($proyectoMovto);
		}else{
			echo Zend_Json::encode(array());
		}
        
    }

    public function getdescripciontipomovtoAction()
    {
        $idTipoMovto = $this->getParam("idTipoMovimiento");
        $desMovto = $this->proyectoClienteDAO->obtieneDescripcionxMovto($idTipoMovto);
		if(!is_null($desMovto)){
			echo Zend_Json::encode($desMovto);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function empleadoAction()
    {
    	$idFiscales = $this->getParam("idFiscales");
		$fiscalesProveedores = $this->fiscalesDAO->getEmpleadoProveedorIdFiscalesEmpresa($idFiscales);
		if(!is_null($fiscalesProveedores)){
			echo Zend_Json::encode($fiscalesProveedores);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function buscanominaxpAction()
    {
        $idSucursal = $this->getParam("sucu");
        $proveedor = $this->getParam("pro");
		
		$buscaNomina= $this->pagosDAO->busca_Nominasxp($idSucursal, $proveedor);
		if(!is_null($buscaNomina)){
			echo Zend_Json::encode($buscaNomina);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function proyectoremisionAction()
    {
	    $idProyecto = $this->getParam("idProyecto");
		$proyectoMovtoRemision= $this->proyectoClienteDAO->obtieneProyectoRemision($idProyecto);
		if(!is_null($proyectoMovtoRemision)){
			echo Zend_Json::encode($proyectoMovtoRemision);
		}else{
			echo Zend_Json::encode(array());
		} 
    }

    public function buscaanticipoclienteAction()
    {
    	$sucu = $this->getParam("sucu");
        $cl = $this->getParam("cl");
        
		$buscaCobro = $this->cobrosDAO->busca_AnticipoCliente($sucu, $cl);
		if(!is_null($buscaCobro)){
			echo Zend_Json::encode($buscaCobro);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function facturaantcliAction()
    {
    	$sucu = $this->getParam("idSucursal");
        $cli = $this->getParam("idCoP");
        
		$buscaFacAntCli = $this->cobrosDAO->obtieneFacturaParaAnticipoCliente($sucu, $cli);
		if(!is_null($buscaFacAntCli)){
			echo Zend_Json::encode($buscaFacAntCli);
		}else{
			echo Zend_Json::encode(array());
		}   
    }

    public function proyectoclienteAction()
    {
        $CoP = $this->getParam("CoP");
		$proyectoCliente= $this->proyectoDAO->obtieneProyectoCliente($CoP);
		if(!is_null($proyectoCliente)){
			echo Zend_Json::encode($proyectoCliente);
		}else{
			echo Zend_Json::encode(array());
		} 
    }

    public function movimientosproveedorAction()
    {
        $idCoP = $this->getParam("CoP");
		$proyectoProveedor= $this->facturaProDAO->obtieneProyectoProveedor($idCoP);
		if(!is_null($proyectoProveedor)){
			echo Zend_Json::encode($proyectoProveedor);
		}else{
			echo Zend_Json::encode(array());
		} 
    }

    public function proyectoxfechaAction()
    {
    	$idProyecto = $this->getParam("idProyecto"); 
		$fechaI = $this->getParam("fechaI"); 
        $fechaF = $this->getParam("fechaF"); 
		$proyectoMovtoxFecha = $this->proyectoDAO->obtieneProyectoxfecha($idProyecto, $fechaI , $fechaF);
		if(!is_null($proyectoMovtoxFecha)){
			echo Zend_Json::encode($proyectoMovtoxFecha);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function getclienteAction()
    {
    	$idCliente = $this->getParam("cl");
		$cliente = $this->notaSalidaDAO->obtenerCliente($idCliente);
		if(!is_null($cliente)){
			echo Zend_Json::encode($cliente);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function proyectoprovxfechaAction()
    {
    	$idProyecto = $this->getParam("idProyecto"); 
		$fechaI = $this->getParam("fechaI"); 
        $fechaF = $this->getParam("fechaF"); 
		$proyectoMovtoxFecha = $this->proyectoDAO->obtieneProyectoProvxfecha($idProyecto, $fechaI , $fechaF);
		if(!is_null($proyectoMovtoxFecha)){
			echo Zend_Json::encode($proyectoMovtoxFecha);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function proyectoremprovxfechaAction()
    {
    	$idProyecto = $this->getParam("idProyecto"); 
		$fechaI = $this->getParam("fechaI"); 
        $fechaF = $this->getParam("fechaF"); 
		$proyectoRemisionEntrdaxFecha = $this->proyectoDAO->obtieneProyectoRemisionProveedorxFecha($idProyecto, $fechaI, $fechaF);
		if(!is_null($proyectoRemisionEntrdaxFecha)){
			echo Zend_Json::encode($proyectoRemisionEntrdaxFecha);
		}else{
			echo Zend_Json::encode(array());
		}
    	
    }

    public function proyectoremclixfechaAction()
    {
    	$idProyecto = $this->getParam("idProyecto"); 
		$fechaI = $this->getParam("fechaI"); 
        $fechaF = $this->getParam("fechaF"); 
		$proyectoRemisionSalidaxFecha = $this->proyectoDAO->obtieneProyectoRemisionClientexFecha($idProyecto, $fechaI, $fechaF);
		if(!is_null($proyectoRemisionSalidaxFecha)){
			echo Zend_Json::encode($proyectoRemisionSalidaxFecha);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function proyectonominafechaAction()
    {
    	$idProyecto = $this->getParam("idProyecto"); 
		$fechaI = $this->getParam("fechaI"); 
        $fechaF = $this->getParam("fechaF"); 
		$proyectoNominaxFecha = $this->proyectoDAO->obtieneProyectoNominaProveedorxFecha($idProyecto, $fechaI, $fechaF);
		if(!is_null($proyectoNominaxFecha)){
			echo Zend_Json::encode($proyectoNominaxFecha);
		}else{
			echo Zend_Json::encode(array());
		}
        
    }


}






















	
	
	
	
	
	
	
	
	
	
	






















