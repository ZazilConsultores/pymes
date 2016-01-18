<?php

class Consulta_EmpresaController extends Zend_Controller_Action
{

    private $empresaDAO = null;

    private $fiscalesDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Inventario_DAO_Empresa;
		$this->fiscalesDAO = new Inventario_DAO_Fiscales;
    }

    public function indexAction()
    {
        // action body
        $empresaDAO = $this->empresaDAO;
		$this->view->informaciones = $empresaDAO->obtenerInformacionEmpresas();
    }

    public function pruebaAction()
    {
        // action body
        $empresaDAO = $this->empresaDAO;
		//$idEmpresa = 6;
		$select =$empresaDAO->obtenerInformacionEmpresas();
		//$select = $empresaDAO->obtenerInformacion($idEmpresa);
		$this->view->select = $select;
    }

}



