<?php

class Sistema_EmpresaController extends Zend_Controller_Action
{

    private $empresaDAO;
	private $domicilioDAO;
	private $fiscalesDAO;
	private $telefonoDAO;
	private $emailDAO;

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
        //$empresas = $this->empresaDAO->o
        
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaEmpresa;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				
				$empresa = new Sistema_Model_Fiscal($datos);
				$this->empresasDAO->crearEmpresa($empresa);
				print_r($datos);
			}
		}
    }

    public function empresasAction()
    {
        // action body
        $idFiscales = $this->empresaDAO->obtenerIdFiscalesEmpresas();
		//$idFiscales = $this->empresaDAO->obtenerIdFiscalesEmpresas();
		$fiscales = array();
		foreach ($idFiscales as $id) {
			$fiscales[] = $this->fiscalesDAO->obtenerFiscales($id);
		}
        //$fiscales = $this->fiscalDAO->obtenerFiscalesEmpresa();
		$this->view->fiscales = $fiscales;
    }

    public function clientesAction()
    {
        // action body
        $idFiscales = $this->empresaDAO->obtenerIdFiscalesClientes();
		$fiscales = array();
		foreach ($idFiscales as $id) {
			$fiscales[] = $this->fiscalesDAO->obtenerFiscales($id);
		}
        //$fiscales = $this->fiscalDAO->obtenerFiscalesCliente();
		$this->view->fiscales = $fiscales;
    }

    public function proveedoresAction()
    {
        // action body
        $idFiscales = $this->empresaDAO->obtenerIdFiscalesProveedores();
		$fiscales = array();
		foreach ($idFiscales as $id) {
			$fiscales[] = $this->fiscalesDAO->obtenerFiscales($id);
		}
        //$fiscales = $this->fiscalDAO->obtenerFiscalesProveedor();
		$this->view->fiscales = $fiscales;
    }


}






