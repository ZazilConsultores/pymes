<?php

class Sistema_HtmlController extends Zend_Controller_Action
{

    private $domicilioDAO;
    private $estadoDAO;
    private $municipioDAO;
    private $fiscalesDAO;
	private $emailDAO;
	private $telefonoDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		$this->domicilioDAO = new Sistema_DAO_Domicilio;
		$this->estadoDAO = new Sistema_DAO_Estado;
		$this->municipioDAO = new Sistema_DAO_Municipio;
		$this->emailDAO = new Sistema_DAO_Email;
		$this->telefonoDAO = new Sistema_DAO_Telefono;
    }

    public function indexAction()
    {
        // action body
    }

    public function municipiosAction()
    {
        // action body
        
    }

    public function domicilioAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		//$domicilio = $this->domicilioDAO->obtenerDomicilio($fiscales->getIdDomicilio());
		$domicilio = $this->fiscalesDAO->obtenerDomicilioFiscal($idFiscales);
		$municipio = $this->municipioDAO->obtenerMunicipio($domicilio->getIdMunicipio());
		$estado = $this->estadoDAO->obtenerEstado($municipio->getIdEstado());
		$this->view->domicilio = $domicilio;
		$this->view->estado = $estado;
		$this->view->municipio = $municipio;
    }

    public function telefonosAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		$telefonos = $this->fiscalesDAO->obtenerTelefonosFiscales($idFiscales);
		/*
		$idsTelefonos = $fiscales->getIdsTelefonos();
		$idsTelefonos = explode(",", $idsTelefonos);
		$telefonos = array();
		foreach ($idsTelefonos as $idTelefono) {
			$telefonos[] = $this->telefonoDAO->obtenerTelefono($idTelefono);
		}
		 * 
		 */
		$this->view->telefonos = $telefonos;
    }

    public function emailsAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		$emails = $this->fiscalesDAO->obtenerEmailsFiscales($idFiscales);
		/*
		$idsEmails = $fiscales->getIdsEmails();
		$idsEmails = explode(",", $idsEmails);
		$emails = array();
		foreach ($idsEmails as $idEmail) {
			$emails[] = $this->emailDAO->obtenerEmail($idEmail);
		}
		*/
		$this->view->emails = $emails;
    }


}









