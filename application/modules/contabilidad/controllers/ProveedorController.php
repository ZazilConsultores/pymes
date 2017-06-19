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
		$select = $this->db->select()->from("Producto")->order("claveProducto ASC");
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
				$productos = json_decode($encabezado['productos'],TRUE);
				try{
					$notaentrada = $this->notaEntradaDAO->agregarProducto($encabezado, $productos);
					$suma = $this->notaEntradaDAO->suma($encabezado, $productos);
					$this->view->messageSuccess = "Numero de Nota: <strong>" .$encabezado["numFolio"] . " </strong> guardada exitosamente!!";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = "Error al crear el Nota Proveedor: <strong>".$ex->getMessage()."</strong>";
				}
			}/*else{
				print_r("formulario no valido <br />");
			}	*/				
			//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
		}
    }

    public function remisionAction()
    {
        // action body
		$request = $this->getRequest();
        $formulario = new Contabilidad_Form_AgregarRemisionProveedor;
		$this->view->formulario = $formulario;	
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$remisionEntradaDAO = new Contabilidad_DAO_RemisionEntrada;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				//print_r($encabezado);
				$formaPago =$datos[1];
				$productos = json_decode($encabezado['productos'],TRUE);
				//print_r('<br />');
				$contador=0;
				try{
				$guardaPago = $this->remisionEntradaDAO->guardaPago($encabezado, $formaPago,$productos);
				//$suma = $this->notaEntradaDAO->suma($encabezado, $productos);
				//$editaBanco = $this->remisionEntradaDAO->editarBanco($formaPago, $productos); 
				foreach ($productos as $producto){
					
					$remisionEntradaDAO->agregarProducto($encabezado, $producto, $formaPago);
					$contador++;
				}
					//$suma = $this->notaEntradaDAO->suma($encabezado, $producto);
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
				print_r($encabezado);
				print_r("<br />");
				$formaPago = $datos[1];
				print_r($formaPago);
				print_r("<br />");
				$productos = json_decode($encabezado['productos'], TRUE);
				print_r($productos);
				print_r("<br />");
				$importe = json_decode($formaPago['importes'], TRUE);
				print_r($importe);
				print_r("<br />");
				
				try{
					$guardaFactura = $this->facturaDAO->guardaFactura($encabezado, $importe, $formaPago, $productos);	
						 	
					foreach ($productos as $producto){
						/*$suma = $this->facturaDAO->suma($encabezado, $producto);
						$guardaDetalle = $this->facturaDAO->guardaDetalleFactura($encabezado, $producto, $importe);
						$contador++;	*/
					}
					$this->view->messageSuccess = "Factura: <strong>" .$guardaFactura["numeroFactura"] . " </strong> guardada exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: La factura no se ha ejecutado correctamente: <strong>". $ex->getMessage()."</strong>";;
				}
			}
			
		}
			
    }

    public function pagosAction()
    {
		$request = $this->getRequest();
		$formulario = new Contabilidad_Form_PagosProveedor;
		$formulario->getSubForm("0")->getElement("idEmpresas");
		$formulario->getSubForm("0")->getElement("idSucursal");
		$formulario->getSubForm("0")->getElement("idCoP");
		$formulario->getSubForm("0")->getElement("numFactura");
		$formulario->removeElement("fecha");
		$formulario->removeSubForm("1");
		$this->view->formulario = $formulario;
	
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$pagosDAO = new Contabilidad_DAO_PagoProveedor;
				$datos = $formulario->getValues();
				$this->view->facturasxp = $pagosDAO->busca_Facturasxp();
				//$this->view->facturasp = $facturasp;
			}	
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
		$this->view->datosFactura = $pagosDAO->obtiene_Factura($idFactura);	
		$this->view->proveedorFac = $pagosDAO->obtenerProveedoresEmpresa($idFactura);
		$this->view->sucursalFac = $pagosDAO->obtenerSucursal($idFactura);
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				try{
					$this->pagoProveedorDAO->aplica_Pago($idFactura, $datos);
					$actualizaSaldo = $this->pagoProveedorDAO->actualiza_Saldo($idFactura, $datos);
				}catch(Exception $ex){
				}
			}
		}
    	
    	/*$fecha = $this->getParam($fecha);
		print_r($fecha);
		$cxp = $this->pagoProveedor->guardacxp($idFactura, $idBanco, $idDivisa, $fecha, $referencia, $total);*/
				
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




















