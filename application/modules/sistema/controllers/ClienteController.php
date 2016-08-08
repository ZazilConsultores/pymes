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


}



