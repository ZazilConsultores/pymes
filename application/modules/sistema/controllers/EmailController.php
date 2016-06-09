<?php

class Sistema_EmailController extends Zend_Controller_Action
{

    private $emailDAO = null;
	private $fiscalesDAO;

    public function init()
    {
        /* Initialize action controller here */
        //$this->emailDAO = new Inventario_DAO_Email;
        $this->emailDAO = new Sistema_DAO_Email;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		
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
        $request = $this->getRequest();
		$idEmail = $this->getParam("idEmail");
		$email = $this->emailDAO->obtenerEmail($idEmail);
		
		$formulario = new Sistema_Form_AltaEmail;
		$formulario->getElement("email")->setValue($email->getEmail());
		$formulario->getElement("descripcion")->setValue($email->getDescripcion());
		$formulario->getElement("submit")->setLabel("Actualizar Email");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				try{
					$this->emailDAO->editarEmail($idEmail, $datos);
					$this->view->messageSuccess = "Email actualizado exitosamente !!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error al actualizar email: " . $ex->getMessage();
				}
				print_r($datos);
			}
		}
		
		
		
    }

    public function bajaAction()
    {
        // action body
        $idEmail = $this->getParam("idEmail");
		$this->emailDAO->eliminarEmail($idEmail);
		$this->_helper->redirector->gotoSimple("index", "email", "sistema");
        
    }

    public function fiscalAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		$emails = $this->fiscalesDAO->obtenerEmailsFiscales($idFiscales);
		
		
		$this->view->emails = $emails;
		$this->view->fiscales = $fiscales;
    }


}











