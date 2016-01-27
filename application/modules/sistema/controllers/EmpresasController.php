<?php

class Sistema_EmpresasController extends Zend_Controller_Action
{
	
	private $empresaDAO;
	
    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Inventario_DAO_Empresa;
    }

    public function indexAction()
    {
        // action body
        //$empresas = $this->empresaDAO->ob
    }


}

