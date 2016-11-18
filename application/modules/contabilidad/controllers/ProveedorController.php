<?php

class Contabilidad_ProveedorController extends Zend_Controller_Action
{

    public function init()
    {
        //==============Muestra los links del submenu=======================
       	$this->formatter = new NumberFormatter('es_MX', NumberFormatter::CURRENCY);
		//$this->view->links = $this->links;
	
		$this->db = Zend_Db_Table::getDefaultAdapter();
		
		// =================================================== >>> Obtenemos todos los productos de la tabla producto
		$select = $this->db->select()->from("Producto")->order("producto ASC");
		$statement = $select->query();
		$rowsProducto =  $statement->fetchAll();
		
		$select = $this->db->select()->from("Unidad");
		$statement = $select->query();
		$rowsUnidad =  $statement->fetchAll();

		$select = $this->db->select()->from('impuestos');
		$statement = $select->query();
		$rowImpuesto =$statement->fetchAll();
		///////////////////
		$jsonImpuestos = Zend_Json::encode($rowImpuesto);
		$this->view->jsonImpuestos = $jsonImpuestos;
		
		//============================================>>>Multiplos
		//$idProducto = $this->getParam("idProducto");
	
		/*$select = $this->db->select()->from("Multiplos","idMultiplos")
		->join("Unidad", "Unidad.idUnidad = Multiplos.idUnidad")->where("idProducto=?",$idProducto);
		$statement = $select->query();
		$rowsMultiplo = $statement->fetchAll();*/
		
		// =================================== Codificamos los valores a formato JSON
		$jsonProductos = Zend_Json::encode($rowsProducto);
		$this->view->jsonProductos = $jsonProductos;
		
		$jsonUnidad = Zend_Json::encode($rowsUnidad);
		$this->view->jsonUnidad = $jsonUnidad;
		
		/*$jsonMultiplos = Zend_Json::encode($rowsMultiplo);
		$this->view->jsonMultiplo = $jsonMultiplos;*/
	
    }

    public function indexAction()
    {
  
    }

    public function agregarnotaentradaAction()
    {
        
    }

    public function notaAction() {
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_NuevaNotaProveedor;
        //$formulario->getSubForm("0")->removeElement("submit");
        
		//$formulario->removeElement("submit");
		if($request->isGet()){
			$this->view->formulario = $formulario;		
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$notaEntradaDAO = new Contabilidad_DAO_NotaEntrada;
				$datos = $formulario->getValues();
				//print_r($datos);
				$encabezado = $datos[0];
				//print_r($encabezado);
				$productos = json_decode($encabezado['productos'],TRUE);
				//print_r($encabezado);
				//print_r('<br />');
				print_r($productos);
				$contador=0;
			
				foreach ($productos as $producto){
					//$producto->encabezado();
					//sprint_r($producto);
					
					try{
						$notaEntradaDAO->agregarProducto($encabezado, $producto);
						//print_r($contador);
						$contador++;
					}catch(Util_Exception_BussinessException $ex){
						$this->view->messageFail = $ex->getMessage();
					}
						
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
       /* $request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarRemisionProveedor;
		$this->view->formulario = $formulario;*/
		$request = $this->getRequest();
        $formulario = new Contabilidad_Form_AgregarRemisionProveedor;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$remisionEntradaDAO = new Contabilidad_DAO_RemisionEntrada;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				//print_r($encabezado);
				$formaPago =$datos[1];
				//print_r($formaPago);
				$productos = json_decode($encabezado['productos'],TRUE);
				//print_r($encabezado);
				print_r('<br />');
				//print_r($productos);
				$contador=0;
				foreach ($productos as $producto){
					//$producto->encabezado();
					//sprint_r($producto);
					//$notaEntradaDAO->agregarProducto($encabezado, $producto, $formaPago);
					/*$remisionEntradaDAO->agregarProducto($encabezado, $producto, $formaPago);
					print_r($remisionEntradaDAO);
					$contador++;*/
					try{
						$remisionEntradaDAO->agregarProducto($encabezado, $producto, $formaPago);
						$contador++;
						$this->view->messageSuccess ="Remision de Entrada realizada efectivamente" ;
					}catch(Util_Exception_BussinessException $ex){
						$this->view->messageFail = $ex->getMessage();
					}
					
				}
				//print_r($datos)		
				//print_r('<br />');
				//print_r(json_decode($datos[0]['productos']));
				//$notaentrada = new Contabilidad_Model_Movimientos($datos);
				//$this->notaEntradaDAO->crearNotaEntrada($datos);
			}
					
			//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
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
				$facturaProveedor = new Contabilidad_DAO_FacturaProveedor;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago = $datos[1];
				$productos = json_decode($encabezado['productos'], TRUE);
				$importe = json_decode($formaPago['importes'], TRUE);
				print_r($importe);
				
				//$facturaProveedor->guardaFactura($encabezado,$productos, $formaPago);
				 foreach ($productos as $producto){
					 try{
					 	$facturaProveedor->guardaFactura($encabezado, $importe, $formaPago);	
					
					 	$facturaProveedor->agregarFactura($encabezado, $formaPago, $producto);	
					 	//$facturaProveedor->guardaFactura($encabezado, $formaPago, $producto);	
					}catch(Util_Exception_BussinessException $ex){
						$this->view->messageFail = $ex->getMessage();
					}
				}
			}
			
		}
       
    
	}


}














