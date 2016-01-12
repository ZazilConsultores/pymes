<?php

class Sistema_EstadosController extends Zend_Controller_Action
{
    private $estadosDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        //Inicializamos el DAO que ocuparemos en la administracion de estados
        $this->estadosDAO = new Inventario_DAO_Estado;
    }

    public function indexAction()
    {
        // action body
        //Creo un formulario de Alta de Estado
		$formulario = new Sistema_Form_AltaEstado;
		//Obtengo lista de estados y los envio a la vista
		$this->view->estados = $this->estadosDAO->obtenerEstados();
		//Envio a la vista el formulario de Alta de Estado, si el usuario lo llega se recibe la informacion en altaAction
		$this->view->formulario = $formulario;
    }

    public function altaAction()
    {
    	$request = $this->getRequest();
		$formulario = new Sistema_Form_AltaEstado;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$estado = new Application_Model_Estado($datos);
				$this->estadosDAO->crearEstado($estado);
				$this->_helper->redirector->gotoSimple("index", "estados", "sistema");
			}
		}else{
			$this->_helper->redirector->gotoSimple("index", "estados", "sistema");
		}
    }

    public function adminAction()
    {
        // action body
        $idEstado = $this->getParam("idEstado");
		$estado = $this->estadosDAO->obtenerEstado($idEstado);
		
		$formulario = new Sistema_Form_AltaEstado;
		$formulario->getElement("estado")->setValue($estado->getEstado());
		$formulario->getElement("capital")->setValue($estado->getCapital());
		$formulario->getElement("agregar")->setLabel("Actualizar");
		
		$this->view->estado = $estado;
		$this->view->formulario = $formulario;
    }

    public function editaAction()
    {
        // action body
        $request = $this->getRequest();
		$idEstado = $this->getParam("idEstado");
		$post = $request->getPost();
		
		$estadoModel = new Application_Model_Estado($post);
		//print_r($estadoModel->toArray());
		$this->estadosDAO->editarEstado($idEstado, $estadoModel);
		$this->_helper->redirector->gotoSimple("index", "estados", "sistema");
    }

    public function bajaAction()
    {
        // action body
        $idEstado = $this->getParam("idEstado");
		$this->estadosDAO->eliminarEstado($idEstado);
		$this->_helper->redirector->gotoSimple("index", "estados", "sistema");
    }
	
}
