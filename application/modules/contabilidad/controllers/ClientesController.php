<?php

class Contabilidad_ClientesController extends Zend_Controller_Action
{

    private $empresaDAO = null;

    private $sucursalDAO = null;

    private $notaSalidaDAO = null;

    private $remisionEntradaDAO = null;

    private $facturaDAO = null;

    private $impuestosDAO = null;

    private $cobroClienteDAO = null;

    private $anticipoDAO = null;

    private $proyectoDAO = null;

    public function init()
    {
    	$this->sucursalDAO = new Sistema_DAO_Sucursal;
    	$this->empresaDAO = new Sistema_DAO_Empresa;
		$this->notaSalidaDAO = new Contabilidad_DAO_NotaSalida;
		$this->remisionSalidaDAO = new Contabilidad_DAO_RemisionSalida;
		$this->facturaDAO = new Contabilidad_DAO_FacturaCliente;
		$this->impuestosDAO = new Contabilidad_DAO_Impuesto;
		$this->cobroClienteDAO = new Contabilidad_DAO_CobroCliente;
		$this->anticipoDAO = new Contabilidad_DAO_Anticipos;
		$this->proyectoDAO = new Contabilidad_DAO_ProyectoCliente;
		
		$adapter =Zend_Registry::get('dbmodgeneral');
		$this->db = $adapter;
		// ====================================================>>> Obtenemos todos los productos de la tabla producto
		$select = $this->db->select()->from("Producto")->order("claveProducto ASC");
		$statement = $select->query();
		$rowsProducto =  $statement->fetchAll();
		
		$select = $this->db->select()->from("Unidad");
		$statement = $select->query();
		$rowsUnidad =  $statement->fetchAll();
		// ====================================================>>> Codificamos los valores a formato JSON
		$jsonProductos = Zend_Json::encode($rowsProducto);
		$this->view->jsonProductos = $jsonProductos;
		$jsonUnidad = Zend_Json::encode($rowsUnidad);
		$this->view->jsonUnidad = $jsonUnidad;
		
    }

    public function indexAction()
    {
    }

    public function notaAction()
    {
    	
        $request = $this->getRequest();
        $formulario = new Contabilidad_Form_NuevaNotaCliente;

		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$productos = json_decode($encabezado['productos'],TRUE);
				$contador = 0;
				foreach ($productos as $producto){
					try{
						$guardaMovimiento = $this->notaSalidaDAO->guardaMovimientos($encabezado, $producto);
						$resta  = $this->notaSalidaDAO->restaProducto($encabezado, $producto);
						$contador++;
					}catch(Util_Exception_BussinessException $ex){
						$this->view->messageFail = $ex->getMessage();
					}
					
				}
			}
		}
    }

    public function remisionAction()
    {
		$request = $this->getRequest();
		
		$select = $this->db->select()->from("Producto")->order("producto ASC");
		$statement = $select->query();
		$rowsProducto =  $statement->fetchAll();
		$jsonDesProductos = Zend_Json::encode($rowsProducto);
		$this->view->jsonDesProductos = $jsonDesProductos;
		
		$formulario = new Contabilidad_Form_AgregarRemisionCliente;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$remisionSalidaDAO = new Contabilidad_DAO_RemisionSalida;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago =$datos[1];
				$productos = json_decode($encabezado['productos'], TRUE);
				print_r('<br />');
				$contador = 0;
				foreach ($productos as $producto){
					try{
						$remisionSalidaDAO->restarProducto($encabezado, $producto, $formaPago);
						$contador++;
						$this->view->messageSuccess ="Remision de Salida realizada efectivamente" ;
					}catch(Util_Exception_BussinessException $ex){
						$this->view->messageFail = $ex->getMessage();
					}
					
				}
				$remisionSalidaDAO->generaCXC($encabezado, $formaPago, $productos);
			}else{
				print_r("formulario no valido <br />");
			}							
			//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
    }
    	
    }

    public function facturaAction()
    {
		$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarFacturaCliente;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				$encabezado = $datos[0];
				$formaPago = $datos[1];
				$productos = json_decode($encabezado['productos'],TRUE);
				print_r($productos);
				
				//$importe = json_decode($formaPago['importes'],TRUE);
				//print_r($formaPago);
				//if($importe[0]['desayuno']=="on"){
					//print_r("Controller desayuno");
				//}
				$contador=0;
				try{
					$guardaFactura = $this->facturaDAO->guardaFactura($encabezado, $importe, $formaPago, $productos);
					//$restaPT = $this->facturaDAO->restaProductoTerminado($encabezado, $formaPago, $productos);
					foreach ($productos as $producto){
					//try{
						
						$detalle = $this->facturaDAO->guardaDetalleFactura($encabezado, $producto, $importe);
						$actualizaProducto = $this->facturaDAO->restaProducto($encabezado, $producto);
						////$cardex = $this->facturaDAO->creaCardex($encabezado, $producto);
						////$inventario = $this->facturaDAO->resta($encabezado, $producto);
						//$restaProducto = $this->facturaDAO->creaFacturaCliente($encabezado, $producto, $importe);
						
					$contador++;
					}
					$this->view->messageSuccess = "Se ha agregado Factura exitosamente";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}/*}else{
					print_r("formulario no valido <br />");*/
				}

			//}
			
		//}
   }

    }

    public function cobrosAction()
    {
    	$request = $this->getRequest();
		$empresas = $this->empresaDAO->obtenerFiscalesEmpresas(); 
        $this->view->empresas = $empresas;	
		if($request->isPost()){		
			$datos = $request->getPost();
			$idSucursal = $this->getParam("sucursal");
			$cl = $this->getParam("cliente");
			//print_r($idSucursal);
			//print_r($cl);
			$facturasxc = $this->cobroClienteDAO->busca_Cuentasxc($idSucursal, $cl);
			$this->view->facturasxc = $facturasxc;
		}
    }

    public function consecutivofacturaAction()
    {
        $request = $this->getRequest();
		$empresas = $this->empresaDAO->obtenerFiscalesEmpresas(); 
        $this->view->empresas = $empresas;
		$idFiscales = $this->getParam("empresa");
		print_r($idFiscales);
		//$sucursal = $this->sucursalesDAO->obtenerSucursales($idFiscales); 
		/*$sucursal = $this->getParam("sucursal");
		print_r($sucursal);*/
		
        /*$this->view->sucursal = $sucursal;*/
		
		
		 
		/*$obtenerFactura = $this->facturaDAO->editaNumeroFactura($idSucursal);
		$this->view->obtenerFactura = $obtenerFactura;
		$formulario = new Contabilidad_Form_AgregarFacturaCliente;
		$formulario->getSubForm("0")->removeElement("idEmpresas");
		$formulario->getSubForm("0")->removeElement("idSucursal");
		$formulario->getSubForm("0")->removeElement("idProyecto");
		$formulario->getSubForm("0")->removeElement("folioFiscal");
		$formulario->getSubForm("0")->removeElement("idCoP");
		$formulario->getSubForm("0")->removeElement("fecha");
		$formulario->getSubForm("0")->getElement("numeroFactura")->setValue($obtenerFactura["numeroFactura"]);
		
		$formulario->removeSubForm("1");
		$formulario -> getElement("submit")->setAttrib("class", "btn btn-warning");
		$formulario -> getElement("submit")->setLabel("Actualizar Consecutivo");
		$this -> view -> formulario = $formulario;			
		/*if($request->isGet()){
			$this->view->empresas = $empresas;	
		}if($request->isPost()){		
			$datos = $request->getPost();
			
					
		}*/
    }

    public function editaconsecutivoAction()
    {
        // action body
        $idFiscales = $this->getParam("empresa");
		print_r($idFiscales);
		//$sucursal = $this->sucursalesDAO->obtenerSucursales($idFiscales); 
    }

    public function aplicacobroAction()
    {
    	$request = $this->getRequest();
		$idFactura = $this->getParam("idFactura");
		$datosFactura = $this->cobroClienteDAO->obtiene_Factura($idFactura);
    	$formulario = new Contabilidad_Form_Cobrofactura;
		$this->view->formulario = $formulario;
		$cobrosDAO = new Contabilidad_DAO_CobroCliente;
		
		$this->view->datosFactura = $cobrosDAO->obtiene_Factura($idFactura);	
		$this->view->clientesFac = $cobrosDAO->obtenerClienteEmpresa($idFactura);
		$this->view->sucursalFac = $cobrosDAO->obtenerSucursal($idFactura);
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				print_r($datos);
				try{
					$this->cobroClienteDAO->aplica_Cobro($idFactura, $datos);
					$this->cobroClienteDAO->actualiza_Saldo($idFactura, $datos);
					$this->view->messageSuccess = "Cobro: <strong>".$datosFactura["numeroFactura"]."</strong> se ha efectuado exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
    }

    public function anticipoAction()
    {
    	$request = $this->getRequest();
        $formulario = new Contabilidad_Form_AnticipoClientes;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$anticipo = $formulario->getValues();
				try{
					$this->anticipoDAO->guardarAnticipoCliente($anticipo);
					$this->view->messageSuccess = "Anticipo: <strong>".$anticipo["numeroReferencia"]."</strong> creado exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = "Error al guardar el anticipo: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
    }

    public function proyectoAction()
    {
    	$request = $this->getRequest();
		$empresas = $this->empresaDAO->obtenerFiscalesEmpresas(); 
        $this->view->empresas = $empresas;	
		if($request->isGet()){
			$this->view->empresas = $empresas;	
		}if($request->isPost()){		
			$datos = $request->getPost();
			//$pagoPago = $this->pagoProveedorDAO->aplica_Pago($idFactura, $datos);
			$idSucursal = $this->getParam("sucursal");
			//print_r($idSucursal);
        	$idProyecto = $this->getParam("idProyecto"); 
        	//print_r($idProyecto);
        	$proyectos = $this->proyectoDAO->obtieneProyecto($idProyecto);
			$this->view->proyectos = $proyectos;
		}
        
    }

    public function desechabledesayunoAction()
    {
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarFacturaCliente;
		//if($request->isGet()){
			//$this->view->formulario = $formulario;
		//}elseif($request->isPost()){
			//if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				$encabezado = $datos[0];
				$productos = json_decode($encabezado['productos'],TRUE);
        		foreach ($productos as $producto){
        			$restaDesechable = $this->facturaDAO->restaDesechableDesayuno($producto);
				}
			//}
        //}
        
    }


}






















