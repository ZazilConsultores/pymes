<?php

class Inventario_CardexController extends Zend_Controller_Action
{
    private $empresaDAO = null;

    public function init()
    {
        $this->empresaDAO = new Sistema_DAO_Empresa;
    }

    public function indexAction()
    {
        // action body
    }

    public function buscaAction()
    {
        $request = $this->getRequest();
        $empresas = $this->empresaDAO->obtenerFiscalesEmpresas();
        $this->view->empresas = $empresas;	
    }


}



