<?php

class Contabilidad_ClientesController extends Zend_Controller_Action
{
	private $facturaDAO = null;
	private $impuestosDAO = null;
	
	public function init()
    {
		$this->notaSalidaDAO = new Contabilidad_DAO_NotaSalida;
		$this->facturaDAO = new Contabilidad_DAO_FacturaCliente;
		$this->impuestosDAO = new Contabilidad_DAO_Impuesto;
		
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
				
				
				//try{
					//$this->facturaDAO->guardaIva($encabezado, $importe);
					foreach ($productos as $producto){
					//try{
						//$this->facturaDAO->guardaImportesImpuesto($encabezado, $importe, $producto);
						$guardaFactura = $this->facturaDAO->guardaFactura($encabezado, $importe, $formaPago, $producto);
						$guardaDetalleFactura =$this->facturaDAO->guardaDetalleFactura($encabezado, $producto, $importe);	
						//$facturaDAO->guardaImportesImpuesto($encabezado, $importe, $producto);
						//$facturaProveedorDAO->guardaImportesImpuesto($encabezado, $importe, $producto);
						//$facturaProveedorDAO->guardaFactura($encabezado, $importe, $formaPago, $productos);
					$contador++;
					}
				//}catch(Util_Exception_BussinessException $ex){
					//$this->view->messageFail = $ex->getMessage();
				//}
				//$guardaFactura = $this->facturaDAO->guardaFactura($encabezado, $importe, $formaPago, $productos); 
				//$saldoCliente = $this->facturaDAO->actualizaSaldoCliente($encabezado, $formaPago);
				//$saldoBanco = $this->facturaDAO->actualizarSaldoBanco($formaPago);
				
				
			//}
			
		}
   }

	}
}








