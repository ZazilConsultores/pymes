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
        //$empresas = $this->empresaDAO->obtenerEmpresas();
		
		//$dfEmpresas = array();
		
		//foreach ($empresas as $empresa) {
			//$dfEmpresas[] = $this->fiscalesDAO->obtenerFiscales($empresa->getIdFiscales);
		//}
		
		//$this->view->empresas = $dfEmpresas;
		
		//$this->view->clientes = $this->empresaDAO->obtenerClientes();
		//*$this->view->proveedores = $this->empresaDAO->obtenerProveedores();
		
		//$select =$empresaDAO->obtenerInformacionEmpresas();
		//$tablaProductos = new Inventario_Model_DbTable_Productos();
		//$rowset = $tablaProductos->obtenerProductos();
		//$this->view->query = $rowset;

		
		$empresaDAO = $this->empresaDAO;
		//$idEmpresa = 6;
		//$rowset = $empresaDAO->obtenerInformacionEmpresas();
		//$rowset = $empresaDAO->obtenerInformacion($idEmpresa);
		$this->view->query = $rowset;
		//$this->view->informacion = $empresaDAO->obtenerInformacionEmpresas();
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



