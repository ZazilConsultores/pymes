<?php

class Contabilidad_JsonController extends Zend_Controller_Action
{
	
	private $empresaDAO;
	private $fiscalesDAO;


    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
        
        $this->empresaDAO = new Sistema_DAO_Empresa;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;

		$this->bancosEmpresaDAO = new Contabilidad_DAO_Fondeo;

		$this->tablaClientesEmpresa = new Sistema_Model_DbTable_ClientesEmpresa;

    }

    public function indexAction() {
    	
    }
	
	public function clienteseAction() {
		$idFiscales = $this->getParam("idFiscales");
		
		$fiscalesClientes = $this->fiscalesDAO->getFiscalesClientesByIdFiscalesEmpresa($idFiscales);
		if(!is_null($fiscalesClientes)){
			echo Zend_Json::encode($fiscalesClientes);
		}else{
			echo Zend_Json::encode(array());
		}
		
	}
	
	public function proveedoreseAction() {
		$idFiscales = $this->getParam("idFiscales");
		
		$fiscalesProveedores = $this->fiscalesDAO->getFiscalesProveedoresByIdFiscalesEmpresa($idFiscales);
		if(!is_null($fiscalesProveedores)){
			echo Zend_Json::encode($fiscalesProveedores);
		}else{
			echo Zend_Json::encode(array());
		}
	}
	
	public function asocclienteAction() {
		//Si llegamos aqui es por que en verdad se hace la asociacion
		$idFiscalesEmpresa = $this->getParam("idFiscalesEmpresa");
		$idFiscalesCliente = $this->getParam("idFiscalesCliente");
		
		//print_r($idFiscalesCliente . "<br />");
		//print_r($idFiscalesEmpresa . "<br />");
		
		$fiscalesDAO = $this->fiscalesDAO;
		$empresaDAO = $this->empresaDAO;
		
		$empresaEmpresa = $empresaDAO->obtenerEmpresaPorIdFiscales($idFiscalesEmpresa);
		$empresaCliente = $empresaDAO->obtenerEmpresaPorIdFiscales($idFiscalesCliente);
		
		//print_r($empresaEmpresa);
		//print_r("<br />");
		//print_r($empresaCliente);
		
		$empresa = $fiscalesDAO->getEmpresaByIdFiscales($idFiscalesEmpresa);
		$cliente = $fiscalesDAO->getClienteByIdFiscales($idFiscalesCliente);
		
		$tablaClientesEmpresa = $this->tablaClientesEmpresa;
		print_r("<br />");
		print_r($fiscalesDAO->getEmpresaByIdFiscales($idFiscalesEmpresa));
		print_r("<br />");
		print_r($fiscalesDAO->getClienteByIdFiscales($idFiscalesCliente));
	}

	

	public function bancosempresaAction() {
		$idBanco = $this->getParam("idBanco");
		$bancosEmpresa = $this->bancosEmpresaDAO->obtenerBancosEmpresa($idBanco);
		
	}
}