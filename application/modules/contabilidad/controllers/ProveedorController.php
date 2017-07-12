<?php

class Contabilidad_ProveedorController extends Zend_Controller_Action
{
	private $empresaDAO = null;
    private $notaEntradaDAO = null;
    private $remisionEntradaDAO = null;
    private $facturaDAO = null;
    private $pagoProveedor = null;

    public function init()
    {
    	$this->empresaDAO = new Sistema_DAO_Empresa;
    	$this->notaEntradaDAO = new Contabilidad_DAO_NotaEntrada;
    	$this->remisionEntradaDAO =  new Contabilidad_DAO_RemisionEntrada;
    	$this->facturaDAO = new Contabilidad_DAO_FacturaProveedor;
		$this->pagoProveedorDAO = new Contabilidad_DAO_PagoProveedor;
		
        //==============Muestra los links del submenu=======================
		//$this->view->links = $this->links;
		$adapter = Zend_Registry::get('dbmodgeneral');
		$this->db = $adapter;
		// =================================================== >>> Obtenemos todos los productos de la tabla producto
		$select = $this->db->select()->from("Producto")->order("producto ASC");
		$statement = $select->query();
		$rowsProducto =  $statement->fetchAll();
		
		$select = $this->db->select()->from("Unidad");
		$statement = $select->query();
		$rowsUnidad =  $statement->fetchAll();
	
		$select = $this->db->select()->from("Multiplos")
		->join("Unidad", "Unidad.idUnidad = Multiplos.idUnidad");
		$statement = $select->query();
		$rowsMultiplos = $statement->fetchAll();
		
		// =================================== Codificamos los valores a formato JSON
		$jsonProductos = Zend_Json::encode($rowsProducto);
		$this->view->jsonProductos = $jsonProductos;
		
		$jsonUnidad = Zend_Json::encode($rowsUnidad);
		$this->view->jsonUnidad = $jsonUnidad;
		
		$jsonMultiplos = Zend_Json::encode($rowsMultiplos);
		$this->view->jsonMultiplos = $jsonMultiplos;
    }

    public function indexAction()
    {
  
    }

    public function notaAction()
    {
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_NuevaNotaProveedor;
        $this->view->formulario = $formulario;	
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				//print_r($encabezado);
				$productos = json_decode($encabezado['productos'], TRUE);
				try{
					$notaentrada = $this->notaEntradaDAO->agregarProducto($encabezado, $productos);
					$actualizaProducto = $this->notaEntradaDAO->actulizaProducto($encabezado, $productos);
					$this->view->messageSuccess = "Numero de Nota: <strong>" .$encabezado["numFolio"] . " </strong> guardada exitosamente!!";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = "Error al crear el Nota Proveedor: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
    }

    public function remisionAction()
    {
    	$request = $this->getRequest();
        $formulario = new Contabilidad_Form_AgregarRemisionProveedor;
		$this->view->formulario = $formulario;	
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$remisionEntradaDAO = new Contabilidad_DAO_RemisionEntrada;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago =$datos[1];
				$productos = json_decode($encabezado['productos'],TRUE);
				$contador = 0;
				try{
					$guardaPago = $this->remisionEntradaDAO->guardaPago($encabezado, $formaPago,$productos);
					$saldoBanco = $this->remisionEntradaDAO->saldoBanco($formaPago, $productos);
					foreach ($productos as $producto){
						$movimiento = $this->remisionEntradaDAO->agregarProducto($encabezado, $producto, $formaPago);
						$actualizaProducto = $this->remisionEntradaDAO->actulizaProducto($encabezado, $formaPago, $producto);
						$contador++;
					}
					$this->view->messageSuccess = "Remision: <strong>" .$encabezado["numFolio"] . " </strong> guardada exitosamente!!";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
					
			}
		}
    }

    public function facturaAction()
    {
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarFacturaProveedor;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago = $datos[1];
				$productos = json_decode($encabezado['productos'], TRUE);
				$importe = json_decode($formaPago['importes'], TRUE);
				$contador=0;
				try{
					$guardaFactura = $this->facturaDAO->guardaFactura($encabezado, $importe, $formaPago, $productos);
					foreach ($productos as $producto){
						$actualizaProducto = $this->facturaDAO->actulizaProducto($encabezado,$formaPago, $producto, $importe);
						$guardaDetalle = $this->facturaDAO->guardaDetalleFactura($encabezado, $producto, $importe);
						$contador++;
					}
					$this->view->messageSuccess = "Factura: <strong>" .$guardaFactura["numeroFactura"] . " </strong> guardada exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: La factura no se ha ejecutado correctamente: <strong>". $ex->getMessage()."</strong>";;
				}
				foreach ($productos as $producto){
					
					$actualizaPT = $this->facturaDAO->actulizaCostoProducto($encabezado, $formaPago, $producto, $importe);
				}	
			}
			
		}
			
    }

    public function pagosAction()
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
        	$pr = $this->getParam("proveedor"); 
        	//Enviamos la busqueda a la consulta
        	$facturaxp = $this->pagoProveedorDAO->busca_Cuentasxp($idSucursal, $pr);
			$this->view->facturasxp = $facturaxp;
		}
    }

    public function aplicarpagoAction()
    {
    	
    	$request = $this->getRequest();
		$idFactura = $this->getParam("idFactura");
		
    	$formulario = new Contabilidad_Form_PagosProveedor;
		$this->view->formulario = $formulario;
		$pagosDAO = new Contabilidad_DAO_PagoProveedor;
		//$proveedores = $pagosDAO->obtenerProveedoresEmpresa($idFactura);
		$datosFactura = $pagosDAO->obtiene_Factura($idFactura);
		//$this->view->datosFactura = $pagosDAO->obtiene_Factura($idFactura);	
		//$this->view->proveedorFac = $pagosDAO->obtenerProveedoresEmpresa($idFactura);
		//$this->view->sucursalFac = $pagosDAO->obtenerSucursal($idFactura);
		
		/*if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				try{
					$this->pagoProveedorDAO->aplica_Pago($idFactura, $datos);
					//$actualizaSaldo = $this->pagoProveedorDAO->actualiza_Saldo($idFactura, $datos);
					$this->view->messageSuccess = "El pago <strong>".$datosFactura["numeroFactura"]."</strong> se ha efectuado exitosamente!!";
				}catch(Exception $ex){
					//$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
    	
    	$fecha = $this->getParam($fecha);
		print_r($fecha);
		$cxp = $this->pagoProveedor->guardacxp($idFactura, $idBanco, $idDivisa, $fecha, $referencia, $total);
				
    }*/
    if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				print_r($datos);
				try{
					$this->pagoProveedorDAO->aplica_Pago($idFactura, $datos);
					$this->view->messageSuccess = "Empresa dada de alta con exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
				
			}
		}
    }

    public function pagodosAction()
    {
        // action body
        $request = $this->getRequest();
		$empresas = $this->empresaDAO->obtenerFiscalesEmpresas(); 
        $this->view->empresas = $empresas;	
		if($request->isGet()){
			$this->view->empresas = $empresas;	
		}if($request->isPost()){		
			$datos = $request->getPost();
			//$pagoPago = $this->pagoProveedorDAO->aplica_Pago($idFactura, $datos);
			$idSucursal = $this->getParam("sucursal");
			print_r($idSucursal);
        	$pr = $this->getParam("proveedor"); 
        	//Enviamos la busqueda a la consulta
        	$facturaxp = $this->pagoProveedorDAO->busca_Cuentasxp($idSucursal, $pr);
			$this->view->facturasxp = $facturaxp;
			/*switch ($datos["tipoFormulario"]) {
				case 'PF': // Pago Factura Proveedor
					print_r("Es un pago Factura");
					break;
				
				case 'NP': // Nomina de Credito de Proveedor
					print_r("Es una nomina de ");
					break;
			}*/
			
		}
    }


}




















