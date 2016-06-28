<?php

class Sistema_ProveedorController extends Zend_Controller_Action
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
		$empresa = $this->empresaDAO->obtenerEmpresaPorIdFiscales($idFiscales);
		
		$this->view->empresa = $empresa;
		$this->view->empresaDAO = $this->empresaDAO;
		$this->view->fiscalesDAO = $this->fiscalesDAO;
		
    }


}



