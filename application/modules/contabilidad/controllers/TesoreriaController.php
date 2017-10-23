<?php

class Contabilidad_TesoreriaController extends Zend_Controller_Action
{

    private $tesoreriaDAO = null;

    private $empresaDAO = null;

    public function init()
    {
        $this->tesoreriaDAO = new Contabilidad_DAO_Tesoreria;
		$this->pagoProveedorDAO = new Contabilidad_DAO_PagoProveedor;
		$this->empresaDAO = new Sistema_DAO_Empresa;
		
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
    }

    public function indexAction()
    {
        // action body
    }

    public function fondeoAction()
    {
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarFondeo;
		$formulario->getElement("submit")->setLabel("Agregar Fondeo");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-success");
		$this->view->$formulario = $formulario;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$empresa = $datos[0];
				$fondeo = $datos[1];
				//print_r($fondeo);
				try{
					$this->tesoreriaDAO->guardaFondeo($empresa, $fondeo);
					$this->view->messageSuccess = "Se ha generado fondeo: <strong>".$empresa["numFolio"]."</strong> exitosamente";
				}catch(exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
			}else{
				print_r("formulario no valido <br />");
			}				
		}	
    }

    public function inversionesAction()
    {
        $formulario = new Contabilidad_Form_AgregarInversiones;
		$this->view->formulario = $formulario;
	
    }

    public function nominaAction()
    {
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarNomina;
		$this->view->formulario = $formulario;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$empresa = $datos[0];
				$nomina = $datos[1];
				 try{
					$this->tesoreriaDAO->guardaPagoNomina($empresa, $nomina);
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
			}else{
				print_r("El formulario no es valido");
			}
		}
    }

    public function impuestosAction()
    {
    	$request = $this->getRequest();
        $formulario = new Contabilidad_Form_PagoImpuesto;
        $this->view->formulario = $formulario;
		$formulario->getSubForm("0")->removeElement("idCoP");
        if($request->isGet()){
        	$this->view->formulario = $formulario;
        }elseif($request->isPost()){
        	if($formulario->isValid($request->getPost())){
        		$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$info = $datos[1];
				print_r($encabezado);
				print_r("<br />");
				print_r($info);
				try{
					$this->tesoreriaDAO->guardaPagoImpuesto($encabezado, $info);
					$this->view->messageSuccess = "Se ha generado Pago de Impuesto: <strong>".$encabezado["numFolio"]."</strong> exitosamente";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
        	}
        }
        
    }

    public function notacreditoAction()
    {
    	$request = $this->getRequest();
        $formulario = new Contabilidad_Form_NotaCredito;

		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$notaCredito = $formulario->getValues();
				print_r($notaCredito);
				$formaPago = $notaCredito[1];
				$productos = json_decode($notaCredito[0]['productos'],TRUE);
				$impuestos = json_decode($notaCredito[0]['importes'],TRUE);
				$contador = 0;
				
					try{
						$guardaFactura = $this->tesoreriaDAO->guardaNotaCredito($notaCredito, $formaPago, $impuestos, $productos);
						foreach ($productos as $producto){
							$restaProsducto = $this->tesoreriaDAO->restaProducto($notaCredito, $producto);
							$contador++;
						}
						////$detalle =$this->facturaDAO->guardaDetalleFactura($encabezado, $producto, $importe);
						////$cardex = $this->facturaDAO->creaCardex($encabezado, $producto);
						////$inventario = $this->facturaDAO->resta($encabezado, $producto);
						//$restaProducto = $this->facturaDAO->creaFacturaCliente($encabezado, $producto, $importe);
						//$contador++;	
					}catch(Util_Exception_BussinessException $ex){
						$this->view->messageFail = $ex->getMessage();
					}
			}
		}
        
    }

    public function pagonominaAction()
    {
    	$request = $this->getRequest();
		$empresas = $this->empresaDAO->obtenerFiscalesEmpresas();
		$this->view->empresas = $empresas;
    }

    public function aplicapagonominaAction()
    {
    	$request = $this->getRequest();
		$idFactura = $this->getParam("idFactura");
		$formulario = new Contabilidad_Form_PagosProveedor;
		$this->view->formulario = $formulario;
		$pagosDAO = new Contabilidad_DAO_PagoProveedor;
		$datosFactura = $pagosDAO->obtiene_Factura($idFactura);
		$this->view->datosFactura = $pagosDAO->obtiene_Factura($idFactura);	
		$this->view->proveedorFac = $pagosDAO->obtenerProveedoresEmpresa($idFactura);
		$this->view->sucursalFac = $pagosDAO->obtenerSucursal($idFactura);
	
    	if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				try{
					$pago = $this->tesoreriaDAO->aplicaPagoNomina($idFactura, $datos);
					$this->view->messageSuccess = "Pago: <strong>".$datosFactura["numeroFactura"]."</strong> se ha efectuado exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
				
			}
		}
    }

    public function impuestoempleadoAction()
    {
        $request = $this->getRequest();
        $formulario = new Contabilidad_Form_PagoImpuesto;
        $this->view->formulario = $formulario;
        if($request->isGet()){
        	$this->view->formulario = $formulario;
        }elseif($request->isPost()){
        	if($formulario->isValid($request->getPost())){
        		$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$info = $datos[1];
				print_r($encabezado);
				print_r("<br />");
				print_r($info);
				try{
					$this->tesoreriaDAO->guardaPagoImpuesto($encabezado, $info);
					$this->view->messageSuccess = "Se ha generado Pago de Impuesto: <strong>".$encabezado["numFolio"]."</strong> exitosamente";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
        	}
        }
    }


}

















