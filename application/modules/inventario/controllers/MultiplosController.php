<?php

class Inventario_MultiplosController extends Zend_Controller_Action
{
	private $multiploDAO;
	private $productoDAO;

    public function init()
    {
        $this->multiploDAO = new Inventario_DAO_Multiplo;
		$this->productoDAO = new Inventario_DAO_Producto;
    }

    public function indexAction()
    {
        
        $idProducto = $this->getParam("idProducto");
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
		$formulario->getElement("submit")->setLabel("Actualizar");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
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
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$multiplos = new Inventario_Model_Multiplos($datos);
				$this->multiploDAO->crearMultiplos($multiplos) ;
				$this->_helper->redirector->gotoSimple("index", "muliplos", "sistema", array("idProducto"=>$idProducto));
			}
		}else{
			$this->_helper->redirector->gotoSimple("index", "multiplos", "sistema");
		}
		
    }

    public function editaAction()
    {
        $idMultiplos = $this->getParam("idMultiplos");
		
		$datos = $this->getRequest()->getPost();
		unset($datos["submit"]);
		
		$this->multiploDAO->editarMultiplo($idMultiplos, $datos);
		
		
		$this->_helper->redirector->gotoSimple("admin", "multiplos", "invemtario", array("idMultiplos"=>$idMultiplos));
    }


}








