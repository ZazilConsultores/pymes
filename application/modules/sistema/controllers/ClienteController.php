<?php

class Sistema_ClienteController extends Zend_Controller_Action
{
	private $empresaDAO;
	private $fiscalesDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Sistema_DAO_Empresa;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
    }

    public function indexAction()
    {
        // action body
    }

    public function sucursalesAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		$tipoSucursal = $this->getParam("tipoSucursal");
		//$empresaDAO->obtenerSucursales($idFiscales);
		$this->view->empresaDAO = $this->empresaDAO;
		$this->view->fiscalesDAO = $this->fiscalesDAO;
		$this->view->idFiscales = $idFiscales;
		$this->view->tipoSucursal = $tipoSucursal;
    }
	
	public function atelefonoAction() {
		// action body
		$request = $this->getRequest();
		$idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		$formulario = new Sistema_Form_AltaTelefono();
		$this->view->fiscales = $fiscales;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				//print_r($formulario->getValues());
				$telefono = new Sistema_Model_Telefono($formulario->getValues());
				try{
					$this->fiscalesDAO->agregarTelefonoFiscal($idFiscales, $telefono);
					$this->view->messageSuccess = "El telefono: <strong>".$telefono->getTelefono()."</strong> dado de alta en cliente exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "No se pudo dar de alta el telefono: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
	}
	
	public function aemailAction() {
		// action body
		$request = $this->getRequest();
		$idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		$formulario = new Sistema_Form_AltaEmail;
		$this->view->fiscales = $fiscales;
		$this->view->formulario = $formulario;
		if($request->isPost()) {
			if($formulario->isValid($request->getPost())) {
				print_r($formulario->getValues());
				$email = new Sistema_Model_Email($formulario->getValues());
				try{
					$this->fiscalesDAO->agregarEmailFiscal($idFiscales, $email);
					$this->view->messageSuccess = "El email: <strong>".$email->getEmail()."</strong> dado de alta en cliente exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "No se pudo dar de alta el email: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
	}
}



