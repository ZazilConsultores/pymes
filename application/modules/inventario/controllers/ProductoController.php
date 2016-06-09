<?php

class Inventario_ProductoController extends Zend_Controller_Action
{

    private $productoDAO = null;
	private $subparametroDAO;

    public function init()
    {
    	
        /* Initialize action controller here */	
        $this->productoDAO = new Inventario_DAO_Producto;
        $this->subparametroDAO = new Sistema_DAO_Subparametro;
    }

    public function indexAction()
    {
        $productoDAO = $this->productoDAO;
		$this->view->productos = $productoDAO->obtenerProductos();
    }

    public function altaAction()
    {
    	$subparametroDAO = new Sistema_DAO_Subparametro;
		
        $request = $this->getRequest();
		$idProducto = $this->getParam("idProducto");
		$formulario = new Inventario_Form_AltaProducto;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
		
				$producto = new Inventario_Model_Producto($datos);
				$producto->setClaveProducto($subparametroDAO->generarClaveProducto($datos['Configuracion']));
				$producto->setIdsSubparametros($subparametroDAO->generarIdsSubparametros($datos['Configuracion']));
				//$producto->setIdsSubparametros($subparametroDAO->generarIdsSubparametros($datos['Configuracion']));
				$this->productoDAO->crearProducto($producto);
				$this->_helper->redirector->gotoSimple("index", "producto", "inventario");
			}
		}
		
    }

    public function adminAction()
    {
      
		$idProducto = $this -> getParam("idProducto");
		$producto = $this -> productoDAO ->obtenerProducto($idProducto);

		$formulario = new Inventario_Form_AltaProducto;
		$formulario->getElement("claveProducto")->setValue($producto->getClaveProducto());
		$formulario->getElement("producto")->setValue($producto->getProducto());
		$formulario -> getElement("submit") -> setLabel("Actualizar");
		
		$this -> view -> producto = $producto;
		$this -> view -> formulario = $formulario;	
	 }

    public function bajaAction()
    {
        // action body
    }

    public function editaAction()
    {
       $idProducto= $this->getParam("idProducto");
		
		$datos = $this->getRequest()->getPost();
		unset($datos["submit"]);
		
		$this->productoDAO->editarProducto($idProducto, $datos);
		
		$this->productoDAO->editarProducto($idProducto, ($datos['Configuracion']));
	
    }
}









