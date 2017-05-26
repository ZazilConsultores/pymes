<?php

class Contabilidad_ClientesController extends Zend_Controller_Action
{

    private $facturaDAO = null;

    private $sucursalesDAO = null;

    private $impuestosDAO = null;

    private $cobroClienteDAO = null;

    private $empresaDAO = null;

    public function init()
    {
		$this->notaSalidaDAO = new Contabilidad_DAO_NotaSalida;
		$this->facturaDAO = new Contabilidad_DAO_FacturaCliente;
		$this->impuestosDAO = new Contabilidad_DAO_Impuesto;
		$this->empresaDAO = new Sistema_DAO_Empresa;
		$this->sucursalesDAO = new Sistema_DAO_Sucursal;
		$this->cobroClienteDAO = new Contabilidad_DAO_CobroCliente;
		
		$adapter =Zend_Registry::get('dbmodgeneral');
		$this->db = $adapter;
		// =================================================== >>> Obtenemos todos los productos de la tabla producto
		$select = $this->db->select()->from("Producto")->order("claveProducto ASC");
		$statement = $select->query();
		$rowsProducto =  $statement->fetchAll();
		
		$select = $this->db->select()->from("Unidad");
		$statement = $select->query();
		$rowsUnidad =  $statement->fetchAll();
		// =================================== Codificamos los valores a formato JSON
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
				$notaSalidaDAO = new Contabilidad_DAO_NotaSalida;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$productos = json_decode($encabezado['productos'],TRUE);
				//print_r($encabezado);
				/*print_r('<br />');
				
				$notaSalidaDAO = new Contabilidad_DAO_NotaSalida;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$productos = json_decode($encabezado['productos'],TRUE);
				/*print_r($encabezado);
				print_r('<br />');
				print_r($productos);*/
				$contador=0;
				
				foreach ($productos as $producto){
					try{
						//$guardaFactura = $this->facturaDAO->guardaFactura($encabezado, $importe, $formaPago, $productos);
						$guardaMovimiento = $this->notaSalidaDAO->guardaMovimientos($encabezado, $producto);
						$resta  = $this->notaSalidaDAO->resta($encabezado, $producto);
						$creaCardex = $this->notaSalidaDAO->creaCardex($encabezado, $producto);
						$contador++;
					}catch(Util_Exception_BussinessException $ex){
						$this->view->messageFail = $ex->getMessage();
					}
					
				}
			}
					
			//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
		}

		
    }

    public function remisionAction()
    {
		$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarRemisionCliente;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$remisionSalidaDAO = new Contabilidad_DAO_RemisionSalida;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago =$datos[1];
				$idBanco = $this->getParam("idBanco");
				$productos = json_decode($encabezado['productos'], TRUE);
				print_r('<br />');
				$contador=0;
				$remisionSalidaDAO->editarBanco($formaPago, $productos);
				/*foreach ($productos as $producto){
					try{
						$remisionSalidaDAO->restarProducto($encabezado, $producto, $formaPago);
						$contador++;
						$this->view->messageSuccess ="Remision de Salida realizada efectivamente" ;
					}catch(Util_Exception_BussinessException $ex){
						$this->view->messageFail = $ex->getMessage();
					}
					
				}*/
			}else{
				print_r("formulario no valido <br />");
			}							
			//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
    }
    	
    }

    public function facturaAction()
    {
    	//$this->view->impuestos = $this->impuestosDAO->obtenerImpuestos();
		$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarFacturaCliente;
		if($request->isGet()){
			$this->view->formulario = $formulario;			
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago = $datos[1];
				$productos = json_decode($encabezado['productos'],TRUE);
				print_r($productos);
				$importe = json_decode($formaPago['importes'],TRUE);
				print_r("<br />");
				print_r($importe);
				$contador=0;
				
				
				try{
					$guardaFactura = $this->facturaDAO->guardaFactura($encabezado, $importe, $formaPago, $productos);
				
					//$saldoCliente = $this->facturaDAO->actualizaSaldoCliente($encabezado, $formaPago);
				//$saldoBanco = $this->facturaDAO->actualizarSaldoBanco($formaPago);
					foreach ($productos as $producto){
					//try{
						$detalle =$this->facturaDAO->guardaDetalleFactura($encabezado, $producto, $importe);
						$inventario = $this->facturaDAO->resta($encabezado, $producto);
						//$cardex = $this->facturaDAO->creaCardex($encabezado, $producto);
						
					$contador++;
					}
					$this->view->messageSuccess = "Se ha agregado Factura exitosamente";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
				
				
				
			//}
			
		}
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
			print_r($idSucursal);
			print_r($cl);
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
    	$idFactura = $this->getParam("idFactura");
        $cobroClienteDAO = new Contabilidad_DAO_CobroCliente;
		$this->view->datosFactura = $cobroClienteDAO->obtiene_Factura($idFactura);	
    }


}
















