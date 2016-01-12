<?php

class Consulta_EmpresaController extends Zend_Controller_Action
{
	private $empresaDAO;
	private $fiscalesDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Inventario_DAO_Empresa;
		$this->fiscalesDAO = new Inventario_DAO_Fiscales;
    }

    public function indexAction()
    {
        // action body
        $empresas = $this->empresaDAO->obtenerEmpresas();
		
		$dfEmpresas = array();
		
		foreach ($empresas as $empresa) {
			$dfEmpresas[] = $this->fiscalesDAO->obtenerFiscales($empresa->getIdFiscales);
		}
		
		$this->view->empresas = $dfEmpresas;
		
		$this->view->clientes = $this->empresaDAO->obtenerClientes();
		$this->view->proveedores = $this->empresaDAO->obtenerProveedores();
        
    }


}

