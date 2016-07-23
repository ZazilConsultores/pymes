<?php

class Contabilidad_ClientesController extends Zend_Controller_Action
{
    public $links = array(
        'Inicio' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index'
            ),
        'Factura Cliente' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index',
            'tipo' => '1'
            ),
        'Remision Cliente' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index',
            'tipo' => '2'
            ),
        'Cobro Factura' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index',
            'tipo' => '3'
            ),
        'Cancelar Factura' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index',
            'tipo' => '4'
            ),
        'Cancelar Remision' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index',
            'tipo' => '5'
            )
        );

    public function init()
    {
        /* Initialize action controller here */
        $this->formatter = new NumberFormatter('es_MX', NumberFormatter::CURRENCY);
		$this->view->links = $this->links;
		
		$this->notaSalidaDAO= new Contabilidad_DAO_NotaSalida;
		
		//=============================
		 
        /* Initialize action controller here */
		$this->db = Zend_Db_Table::getDefaultAdapter();
		// =================================================== >>> Obtenemos todos los productos de la tabla producto
		$select = $this->db->select()->from("Producto");
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
    	 // action body
        $request = $this->getRequest();
        $tipo = $this->getParam('tipo');
        $formulario = null;
		$rowset = null;
		$mensajeFormulario = null;
		
		if(! is_null($tipo)){
			if($tipo >= 1 && $tipo <= 5){
				switch ($tipo) {
					case '1':
						$mensajeFormulario = "<h3>Nueva Nota Entrada Clientes</h3>";
						$formulario = new Contabilidad_Form_NuevaNotaCliente;
						break;
						
					case '2':
						$mensajeFormulario = "<h3>Nueva Remision Cliente</h3>";
						$formulario = new Contabilidad_Form_AgregarRemisionCliente;
						break;
					case '3':
						$mensajeFormulario = "<h3>Cobro Factura</h3>";
						$formulario = new Contabilidad_Form_Cobrofactura;
						break;
					case '4':
						$mensajeFormulario = "<h3>Cancelar Factura</h3>";
						$formulario = new Contabilidad_Form_CancelarFacturaCliente;
						break;
					case '5':
						$mensajeFormulario = "<h3>Cancelar Remision</h3>";
						$formulario = new Contabilidad_Form_CancelarRemisionCliente;
						break;	
					
				}//	Del switch
			}//	Del if
		}//	Del if is_null($tipo)
		
		if($request->isGet()){
			$this->view->mensajeFormulario = $mensajeFormulario;
			$this->view->formulario = $formulario;
		}

    }

    public function notaAction()
    {

        // action body
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
					//$producto->encabezado();
					//sprint_r($producto);

					$notaSalidaDAO->restarProducto($encabezado, $producto);
					//print_r($contador);
					$contador++;
					
				}
				//print_r($datos)		

				//print_r($productos);
				//print_r(json_decode($datos[0]['productos']));
				//$notaentrada = new Contabilidad_Model_Movimientos($datos);
				//$this->notaEntradaDAO->crearNotaEntrada($datos);
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
				$productos = json_decode($encabezado['productos'], TRUE);
				print_r('<br />');
				$contador=0;
				foreach ($productos as $producto){
					try{
						$remisionSalidaDAO->restarProducto($encabezado, $producto, $formaPago);
						$contador++;
						$this->view->messageSuccess ="Remision de Salida realizada efectivamente" ;
					}catch(Util_Exception_BussinessException $ex){
						$this->view->messageFail = $ex->getMessage();
					}
					
				}
			}
					
			//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
    }
    	
    }


    public function facturaAction()
    {
        // action body
    }


}








