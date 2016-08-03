<?php

class Inventario_EmpresasController extends Zend_Controller_Action
{
	private $empresaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Inventario_DAO_Empresa;
    }

    public function indexAction()
    {
    	$this->view->empresas = $this->empresaDAO->obtenerEmpresas();
    }

    
}