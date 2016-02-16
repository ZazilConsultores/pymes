<?php

class Inventario_ProductoController extends Zend_Controller_Action
{
	private $productoDAO = null;
    public function init()
    {
    	
        /* Initialize action controller here */
        $this->productoDAO = new Inventario_DAO_Producto;
        
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
		$formulario = new Inventario_Form_AltaProducto;
		$this->view->formulario = $formulario;
		//if($request->isPost()){
		//	if($formulario->isValid($request->getPost())){
		//		$datos = $formulario->getValues();
		//		print_r($datos);
				//print_r("=================");
		//		$producto = new Inventario_Model_Producto($datos);
		//		print_r($producto->toArray());
		//		$this->productoDAO->crearProducto($producto);
		//		print_r($producto);
				//$this->_helper->redirector->gotoSimple("index", "banco", "contabilidad");
		//	}
			//$this->_helper->redirector->gotoSimple("index", "banco", "contabilidad");
		//}	
        
    }


}



