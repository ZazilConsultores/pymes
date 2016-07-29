<?php

class Contabilidad_ProveedorController extends Zend_Controller_Action
{

    /*public $links = array(
        'Inicio' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index'
            ),
        'Nota Entrada' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' => '1'
            ),
        'Remision Proveedor' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' =>	 '2'
            ),
        'Factura Proveedor' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' => '3'
            ),
        'Cobro Factura' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' => '4'
            ),
        'Cancelar Factura' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' => '5'
            ),
        'Cancelar Remision' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' => '6'
            )
        );*/

    public function init()
    {
        //==============Muestra los links del submenu=======================
       	$this->formatter = new NumberFormatter('es_MX', NumberFormatter::CURRENCY);
		//$this->view->links = $this->links;
	
		$this->db = Zend_Db_Table::getDefaultAdapter();
		
		// =================================================== >>> Obtenemos todos los productos de la tabla producto
		$select = $this->db->select()->from("Producto");
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
    	//action body
        $request = $this->getRequest();
        $tipo = $this->getParam('tipo');
        $formulario = null;
		$rowset = null;
		$mensajeFormulario = null;
		
		if(! is_null($tipo)){
			if($tipo >= 1 && $tipo <= 6){
				switch ($tipo) {
					case '1':
						$mensajeFormulario = "<h3>Nueva Nota Entrada Proveedor</h3>";
						$formulario = new Contabilidad_Form_NuevaNotaProveedor;
						break;
					/*case '2':
						$mensajeFormulario = "<h3>Remision Proveedor</h3>";
						
						break;
					case '3':
						$mensajeFormulario = "<h3>Pago Factura</h3>";
						
						break;
					case '4':
						$mensajeFormulario = "<h3>Cancelar Factura</h3>";
						
						break;
					case '5':
						$mensajeFormulario = "<h3>Cancelar Remision</h3>";
						
						break;
					case '6':
						$mensajeFormulario = "<h3>Cancelar Remision</h3>";
						
						break;	
					*/
				}//	Del switch
			}//	Del if
		}//	Del if is_null($tipo)
		
		if($request->isGet()){
			$this->view->mensajeFormulario = $mensajeFormulario;
			$this->view->formulario = $formulario;
		}
    }

    public function agregarnotaentradaAction()
    {
        
    }

    public function notaAction()
    {
       $request = $this->getRequest();
        $formulario = new Contabilidad_Form_NuevaNotaProveedor;
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
				//print_r($productos);
				$contador=0;
			
				foreach ($productos as $producto){
					//$producto->encabezado();
					//sprint_r($producto);
					try{
						$notaEntradaDAO->agregarProducto($encabezado, $producto);
						//print_r($contador);
						$contador++;
						$this->view->messageSuccess ="  Nota de Entrada realizada efectivamente" ;
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
				print_r($formaPago);
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
        // action body
    }


}














