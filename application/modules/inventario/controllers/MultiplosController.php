<?php

class Inventario_MultiplosController extends Zend_Controller_Action
{
	private $multiploDAO;
	private $productoDAO;
	private $unidadDAO;

    public function init()
    {
        $this->multiploDAO = new Inventario_DAO_Multiplo;
		$this->productoDAO = new Inventario_DAO_Producto;
		$this->unidadDAO = new Inventario_DAO_Unidad;
		
		
    }

    public function indexAction()
    {
        $idProducto = $this->getParam("idProducto");
		$idUnidad = $this->getParam("idUnidad");
		$formulario = new Inventario_Form_AltaMultiplos;
		
		$this->view->multiplos = $this->multiploDAO->obtenerMultiplos($idProducto);
		$this->view->formulario = $formulario;
		$this->view->producto = $this->productoDAO->obtenerProducto($idProducto);
    }

    public function adminAction()
    {
        $idMultiplos = $this->getParam("idMultiplos");
		$multiplo = $this->multiploDAO->obtenerMultiplo($idMultiplos);
	
		$formulario = new Inventario_Form_AltaMultiplos;
		$formulario->getSubForm("0")->getElement("cantidad")->setValue($multiplo->getCantidad());
		$formulario->getSubForm("0")->getElement("unidad")->setValue($multiplo->getUnidad());
		$formulario->getSubForm("0")->getElement("abreviatura")->setValue($multiplo->getAbreviatura());
		$formulario->getElement("agregar")->setLabel("Actualizar Multiplo");
		$formulario->getElement("agregar")->setAttrib("class", "btn btn-warning");
		
		$this->view->multiplo = $multiplo;
		$this->view->formulario = $formulario;
    }

    public function bajaAction()
    {
        // action body
    }

    public function altaAction()
    {
        $request = $this->getRequest();
		$idProducto = $this->getParam("idProducto");
	
		$formulario = new Inventario_Form_AltaMultiplos;
		$this->view->formulario = $formulario;

		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos[0]);
				$idUnidad = $this -> getParam("idUnidad");
				$unidad = $this -> unidadDAO -> obtenerUnidad($idUnidad);
				
				$multiplo = new Inventario_Model_Multiplos($datos);
				$multiplo->setIdProducto($idProducto);
				$multiplo->setIdUnidad($idUnidad);
				
				$this->multiploDAO->crearMultiplos($multiplo);		
				//$this->_helper->redirector->gotoSimple("index", "producto", "inventario");
	
			}
		}
	}
	 
    public function editaAction()
    {
    	
		$request = $this->getRequest();
    	$idMultiplo = $this->getParam("idMultiplos");
		$idProducto = $this->getParam("idProducto");
	
		$multiplo = $this->multiploDAO->obtenerMultiplo($idMultiplo);
		$producto = $this->multiploDAO->obtenerMultiplos($idProducto);
		
		$this->view->multiplo = $multiplo;
		$formulario = new Inventario_Form_AltaMultiplos;
		
		$formulario->getElement("cantidad")->setValue($multiplo->getCantidad());
		$formulario->getElement("idUnidad")->setValue($multiplo->getIdUnidad());
		$formulario->getElement("submit")->setLabel("Actualizar Multiplo");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		
		$this->view->formulario = $producto;
		$this->view->formulario = $formulario;
		
		if ($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				try{
					$this->multiploDAO->editarMultiplo($idMultiplo, $datos);
					
				}catch(exception $ex){
					
				}
			}
		}
		
    }

}









