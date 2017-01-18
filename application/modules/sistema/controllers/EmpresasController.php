<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */

class Sistema_EmpresasController extends Zend_Controller_Action
{

    private $empresaDAO = null;

    private $domicilioDAO = null;

    private $fiscalesDAO = null;

    private $telefonoDAO = null;

    private $emailDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Sistema_DAO_Empresa;
		//$this->fiscalDAO = new Sistema_DAO_Fiscal;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		$this->domicilioDAO = new Sistema_DAO_Domicilio;
		$this->telefonoDAO = new Sistema_DAO_Telefono;
		$this->emailDAO = new Sistema_DAO_Email;
    }

    public function indexAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
        //$fiscales = $this->fiscalDAO->obtenerFiscalEmpresa();
		//$fiscalesEmpresas = $this->empresaDAO->obtenerIdFiscalesEmpresas();
		$this->view->fiscales = $fiscales;
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaEmpresa;
		$formulario->getSubForm("0")->getElement("tipo")->setMultiOptions(array("EM"=>"Empresa"));
		
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$contenedor = $formulario->getValues();
				
				//print_r($contenedor);
				$this->empresaDAO->crearEmpresa($contenedor);
				print_r($contenedor);
				$this->_helper->redirector->gotoSimple("empresas", "empresa", "sistema");
			}
		}
		
    }

    public function adminAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		//$formulario = new Sistema_Form_AltaEmpresa;
		$formulario = new Sistema_Form_AltaFiscales;
		$formulario->getElement("rfc")->setValue($fiscales->getRfc());
		$formulario->getElement("razonSocial")->setValue($fiscales->getRazonSocial());
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->fiscales = $fiscales;
		$this->view->formulario = $formulario;
    }

    public function editaAction()
    {
        // action body
    }

    public function empresaAction()
    {
        // action body
        $idEmpresa = $this->getParam("idEmpresa");
		$empresaDAO = $this->empresaDAO;
		
		$empresa = $empresaDAO->obtenerEmpresa($idEmpresa);
		$this->view->empresa = $empresa;
    }


}

