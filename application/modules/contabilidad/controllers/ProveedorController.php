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
		
		//============================================>>>Multiplos
		//$idProducto = $this->getParam("idProducto");
		$idProducto=14;
		$select = $this->db->select()->from("Multiplos","idMultiplos")
		->join("Unidad", "Unidad.idUnidad = Multiplos.idUnidad")->where("idProducto=?",$idProducto);
		$statement = $select->query();
		$rowsMultiplo = $statement->fetchAll();
		
		// =================================== Codificamos los valores a formato JSON
		$jsonProductos = Zend_Json::encode($rowsProducto);
		$this->view->jsonProductos = $jsonProductos;
		$jsonUnidad = Zend_Json::encode($rowsUnidad);
		$this->view->jsonUnidad = $jsonUnidad;
		$jsonMultiplos = Zend_Json::encode($rowsMultiplo);
		$this->view->jsonMultiplo = $jsonMultiplos;
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
				//print_r($productos);
				//print_r(json_decode($datos[0]['productos']));
				//$notaentrada = new Contabilidad_Model_Movimientos($datos);
				//$this->notaEntradaDAO->crearNotaEntrada($datos);
			}
					
			//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
    }
  }
    public function facturaAction()
    {
    	//Validar que la factura no existe
    	$request = $this->getRequest();
		$numeroFactura = $this->getParam("numeroFactura");
		$idCoP = $this->getParam("idCoP");
		$idTipoMovimiento  = $this->getParam("idTipoMovimiento");
		$idSucursal = $this->getParam("idSucursal");
		
	
		$formulario = new Contabilidad_Form_AgregarFacturaProveedor;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				print_r($numeroFactura);
				print_r("<br />");
				print_r($idCoP);
				print_r("<br />");
				print_r($idTipoMovimiento);
				print_r("<br />");
				print_r($idSucursal);
				
			
				$facturaProveedor = new Contabilidad_DAO_FacturaProveedor;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				
				$productos = json_decode($encabezado['productos'],TRUE);
				
				$formaPago = $datos[1];
				//$impuestos = $datos[2];
				//$facturaProveedor->agregarFactura($encabezado,$formaPago,$producto);
				/*print_r($encabezado);
				print_r('<br />');
				print_r($formaPago);
				print_r('<br />');
				print_r($impuestos);
				print_r('<br />');*/
				//$facturaProveedor->existeFactura($numeroFactura, $idTipoMovimiento, $idCoP, $idSucursal);
				//print_r($facturaProveedor);
				$contador = 0;
				
				foreach ($productos as $producto){
					//Validar multiplos
				$cantidad = $this->getParam("idCantidad_");
				$idProducto = $this->getParam("descripcion_");
				$idUnidad = $this->getParam("idUnidad_");
				//valida Multiplos
				print_r($cantidad);
				print_r($idProducto);
				print_r("<br />");
				print_r($idUnidad);
					 
					 /*try{
						$facturaProveedor->agregarFactura($encabezado,$formaPago,$producto);
					}catch(Util_Exception_BussinessException $ex){
						$this->view->messageFail = $ex->getMessage();
						
					}*/
				}
				
			}
			
		}
       
    
	}


}














