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
		$select= $this->db->select()->from("Producto")->order("producto ASC");
		$statement = $select->query();
		$rowsProducto  =$statement->fetchAll();
		$jsonDesProductos = Zend_Json::encode($rowsProducto);
		$this->view->jsonDesProductos = $jsonDesProductos;
        $formulario = new Contabilidad_Form_NuevaNotaCliente;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$productos = json_decode($encabezado['productos'],TRUE);
				$contador = 0;
				foreach ($productos as $producto){
					try{
						if($encabezado["idEmpresas"]==6){
							$desechable  = $this->notaSalidaDAO->restaDesechable($producto);
						}
						$guardaMovimiento = $this->notaSalidaDAO->guardaMovimientos($encabezado, $producto);
						$resta  = $this->notaSalidaDAO->restaProducto($encabezado, $producto);
						$contador++;
						$this->view->messageSuccess = "Nota Cliente Generada Exitosamente";
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
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$remisionSalidaDAO = new Contabilidad_DAO_RemisionSalida;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago =$datos[1];
				$productos = json_decode($encabezado['productos'], TRUE);
				$contador = 0;
				try{
				    foreach ($productos as $producto){
						$remisionSalidaDAO->restarProducto($encabezado, $producto, $formaPago);
						$contador++;
						$this->view->messageSuccess ="Remision de Salida realizada efectivamente" ;
					}
					$remisionSalidaDAO->generaCXC($encabezado, $formaPago, $productos);
				}catch(Util_Exception_BussinessException $ex){
				    $this->view->messageFail = $ex->getMessage();
				}							
			}//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
        }
    	
    }

    public function facturaAction()
    {
		$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarFacturaCliente;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago = $datos[1];
				$productos = json_decode($encabezado['productos'],TRUE);
				$importe = json_decode($formaPago['importes'],TRUE);
				$contador=0;
				try{
					$guardaFactura = $this->facturaDAO->guardaFactura($encabezado, $importe, $formaPago, $productos);
					//$restaPT = $this->facturaDAO->restaProductoTerminado($encabezado, $formaPago, $productos);
					foreach ($productos as $producto){
					    if($encabezado["idEmpresas"]==6 ){
					        $desechable  = $this->facturaDAO->restaDesechable($producto);
					    }
					    $detalle = $this->facturaDAO->guardaDetalleFactura($encabezado, $producto, $importe);
						$restaProducto  = $this->facturaDAO->restarProducto($encabezado, $producto);
					   $contador++;
					}
					$this->view->messageSuccess = "Se ha agregado Factura exitosamente";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
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
		}
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
				//print_r($datos);
				try{
					$this->cobroClienteDAO->aplica_Cobro($idFactura, $datos);
					//$this->cobroClienteDAO->actualiza_Saldo($idFactura, $datos);
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
		}
        
    }

    public function buscaanticipoclientesAction()
    {
    	$request = $this->getRequest();
		$sucu = $this->getParam("idSucursal");
        $cli = $this->getParam("idCoP");
		$empresas = $this->empresaDAO->obtenerFiscalesEmpresas(); 
        $this->view->empresas = $empresas;
        $cobrosDAO = new Contabilidad_DAO_CobroCliente;
        $this->view->datosFacturas = $cobrosDAO->obtieneFacturaParaAnticipoCliente($idSucursal, $idCoP);	
		if($request->isPost()){		
			$datos = $request->getPost();
			$idSucursal = $this->getParam("sucursal");
			$cl = $this->getParam("cliente");
		}
        
    }

    public function enlazafacturaAction()
    {
    	$idSucursal = $this->getParam("idSucursal");
		$idCoP = $this->getParam("idCoP");
		$total = $this->getParam("total");
    	$cobrosDAO = new Contabilidad_DAO_CobroCliente;
        $this->view->datosFacturas = $cobrosDAO->obtieneFacturaParaAnticipoCliente($idSucursal, $idCoP);
    }

    public function cancelarAction()
    {
		$request = $this->getRequest();
		$empresas = $this->empresaDAO->obtenerFiscalesEmpresas(); 
        $this->view->empresas = $empresas;
		if($request->isPost()){					
			$datos = $request->getPost();
			$idFactura = $datos["fac"];
			$this->facturaDAO->cancelaFactura($idFactura);
		}
    }

    public function remisioncafeAction()
    {
        $request = $this->getRequest();
        $select = $this->db->select()->from("Producto")->order("producto ASC");
        $statement = $select->query();
        $rowsProducto =  $statement->fetchAll();
        $jsonDesProductos = Zend_Json::encode($rowsProducto);
        $this->view->jsonDesProductos = $jsonDesProductos;
        $formulario = new Contabilidad_Form_AgregarRemisionClienteCafeteria;
        $this->view->formulario = $formulario;
        if($request->isPost()){
            if($formulario->isValid($request->getPost())){
                $remisionSalidaDAO = new Contabilidad_DAO_RemisionSalida;
                $datos = $formulario->getValues();
                $encabezado = $datos[0];
                $formaPago =$datos[1];
                $productos = json_decode($encabezado['productos'], TRUE);
                $contador = 0;
                try{
                    $remisionSalidaDAO->restaProductoCafeteria($encabezado, $productos, $formaPago);
                    $contador++;
                    $this->view->messageSuccess ="Remision de Salida realizada efectivamente" ;
                }catch(Util_Exception_BussinessException $ex){
                    $this->view->messageFail = $ex->getMessage();
                }
            }//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
        }
    }

    public function cobroremiclicafeAction()
    {
        $request = $this->getRequest();
        $empresas = $this->empresaDAO->obtenerFiscalesEmpresas();
        $this->view->empresas = $empresas;
        if($request->isPost()){
            $datos = $request->getPost();
            $idSucursal = $this->getParam("sucursal");
            $cl = $this->getParam("cliente");
        }
    }

    public function aplicacobroremiclicafeAction()
    {
        $request = $this->getRequest();
        $idMovimiento = $this->getParam("idMovimiento");
        $datosMovto = $this->cobroClienteDAO->obtieneMovimiento($idMovimiento);
        $formulario = new Contabilidad_Form_Cobrofactura;
        $this->view->formulario = $formulario;
        $cobrosDAO = new Contabilidad_DAO_CobroCliente;
        
        if($request->isPost()){
            if($formulario->isValid($request->getPost())){
                $datos = $formulario->getValues();
                print_r($datos);
                try{
                    $this->cobroClienteDAO->aplica_CobroRemisionCafe($idMovimiento, $datos);
                    //$this->cobroClienteDAO->actualiza_Saldo($idFactura, $datos);
                    $this->view->messageSuccess = "Cobro: <strong>".$datosMovto["numeroFolio"]."</strong> se ha efectuado exitosamente!!";
                }catch(Exception $ex){
                    $this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
                }
            }
        }
    }


}





























