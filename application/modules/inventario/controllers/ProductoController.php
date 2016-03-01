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
        $request = $this->getRequest();
		$idProducto = $this->getParam("idProducto");
		$formulario = new Inventario_Form_AltaProducto;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				print_r($datos[0]);
				print_r("<br />");
				$claveProducto = $this->subparametroDAO->generarClaveProducto($datos[0]);
				/*
				//print_r("<br />");
				//print_r($claveProducto);
				//print_r("<br />");
				*/
				/*
				$producto = new Inventario_Model_Producto($datos[0]);
				$producto->setIdProducto($idProducto);
				try{
					$this->productoDAO->crearProducto($producto);
					//print_r($subparametro->toArray());
					$mensaje = "Producto <strong>" . $producto->getProducto() . "</strong> creado exitosamente";
					$this->view->messageSuccess = $mensaje;
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}*/
				
			}
		}
    }

    public function adminAction()
    {
        $idProducto = $this->getParam("idProducto"); //1
		$producto = $this->productoDAO->obtenerProducto($idProducto);
		//print_r($idProducto);
		//$this->view->producto = $producto;
		
		$formulario = new Inventario_Form_AltaProducto;
	
		$formulario->getElement("producto")->setValue($producto->getProducto());
		$formulario->getElement("claveProducto")->setValue($producto->getClaveProducto());
		$formulario->getElement("codigoBarras")->setValue($producto->getCodigoBarras());

		$formulario->getElement("agregar")->setLabel("Actualizar");
		
		//$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		$this->view->producto = $producto;
		$this->view->formulario = $formulario;	
	 }

    public function bajaAction()
    {
        // action body
    }

    public function editaAction()
    {
        $request = $this->getRequest();
		$idProducto = $this->getParam("idProducto");
		$post = $request->getPost();
		
		$productoModel = new Inventario_Model_Producto($post);
		//print_r($estadoModel->toArray());
		$this->productoDAO->editarProducto($idProducto, $productoModel);
		$this->_helper->redirector->gotoSimple("index", "producto", "inventario");
    }
}









