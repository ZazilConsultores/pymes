<?php

class Contabilidad_EmpresasController extends Zend_Controller_Action
{
	
	private $empresaDAO;
	private $fiscalesDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Sistema_DAO_Empresa;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		
    }

    public function indexAction() {
    	$fiscales = $this->fiscalesDAO->obtenerFiscalesEmpresas();
		$this->view->fiscales = $fiscales;
    }

    public function clientesAction() {
    	// Nos traemos directamente los Id's FISCALES!! de nuestras empresas
        $this->view->fiscalesEmpresas = $this->fiscalesDAO->obtenerFiscalesEmpresas();
		
    }
	
	public function proveedoresAction() {
		
	}
}