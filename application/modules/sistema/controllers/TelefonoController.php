<?php

class Sistema_TelefonoController extends Zend_Controller_Action
{

    private $telefonoDAO = null;
	private $fiscalesDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        //Iniciamos el DAO
        //$this->telefonosDAO = new Inventario_DAO_Telefono;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		
    }

    public function indexAction()
    {
       $formulario = new Sistema_Form_AltaTelefono;
		//Obtengo lista de telefonos y los envio a la vista
		$this->view->telefonos = $this->telefonosDAO->obtenerTelefonos();
		//Envio a la vista el formulario de Alta de Estado, si el usuario lo llega se recibe la informacion en altaAction
		$this->view->formulario = $formulario;
    }

    public function altaAction()
    {
        //$formulario = new Sistema_Form_AltaTelefono;
		//$this->view->formulario = $formulario;
		$request = $this->getRequest();
		$formulario = new Sistema_Form_AltaTelefono;
		
		if($request->isPost()) {
			if($formulario->isValid($request->getPost())) {
				$datos = $formulario->getValues();
				$telefono = new Application_Model_Telefono($datos);
				$this->telefonosDAO->crearTelefono($telefono);
				$this->_helper->redirector->gotoSimple("index", "telefono", "sistema");
			}
		}else {
			$this->_helper->redirector->gotoSimple("index", "telefono", "sistema");
		}
		
    }

    public function adminAction()
    {
        // action body
    }

    public function editaAction()
    {
        // action body
    }

    public function bajaAction()
    {
        // action body
    }

    public function fiscalAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		//$telefonos = $this->
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		$telefonos = $this->fiscalesDAO->obtenerTelefonosFiscales($fiscales->getIdFiscales());
		$formulario = new Sistema_Form_AltaTelefono;
		
		$this->view->fiscales = $fiscales;
		$this->view->formulario = $formulario;
		$this->view->telefonos = $telefonos;
		
    }


}











