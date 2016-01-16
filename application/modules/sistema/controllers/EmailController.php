<?php

class Sistema_EmailController extends Zend_Controller_Action
{
	private $emailDAO = null;
    public function init()
    {
        /* Initialize action controller here */
        $this->emailDAO = new Inventario_DAO_Email;
        
    }

    public function indexAction()
    {
        // action body
        $formulario = new Sistema_Form_AltaEmail;
		$this->view->email = $this->emailDAO->obtenerEmails();
		$this->view->formulario = $formulario;
    }

    public function altaAction()
    {
        //$formulario = new Sistema_Form_AltaEmail;
		//$this->view->formulario = $formulario;
		 $request = $this->getRequest();
		$formulario = new Sistema_Form_AltaEmail;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$email = new Application_Model_Email($datos);
				$this->emailDAO->crearEmail($email);
				$this->_helper->redirector->gotoSimple("index", "email", "sistema");
			}
		}else{
			$this->_helper->redirector->gotoSimple("index", "email", "sistema");
		}
    }

    public function adminAction()
    {
        $idEmail = $this->getParam("idEmail");
		$email = $this->emailDAO->obtenerEmail($idEmail);
		
		$formulario = new Sistema_Form_AltaEmail;
		$formulario->getElement("email")->setValue($email->getEmail());
		$formulario->getElement("agregar")->setLabel("Actualizar");
		
		$this->view->email = $email;
		$this->view->formulario = $formulario;
    }

    public function editaAction()
    {
        // action body
        // action body
        $request = $this->getRequest();
		$idEmail = $this->getParam("idEmail");
		$post = $request->getPost();
		
		$emailModel = new Application_Model_Email($post);
		$this->emailDAO->editarEmail($idEmail, $emailModel);
		$this->_helper->redirector->gotoSimple("index", "email", "sistema");
    }

    public function bajaAction()
    {
        // action body
        $idEmail = $this->getParam("idEmail");
		$this->emailDAO->eliminarEmail($idEmail);
		$this->_helper->redirector->gotoSimple("index", "email", "sistema");
        
    }


}









