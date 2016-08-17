<?php

class Contabilidad_JsonController extends Zend_Controller_Action
{
	
	private $empresaDAO;
	private $fiscalesDAO;


    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Sistema_DAO_Empresa;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;

		$this->bancosEmpresaDAO = new Contabilidad_DAO_Fondeo;

		$this->tablaClientesEmpresa = new Sistema_Model_DbTable_ClientesEmpresa;

    }

    public function indexAction() {
    	
    }
	
	public function clienteseAction() {
		$idFiscales = $this->getParam("idFiscales");
		//$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		//$empresa = $this->empresaDAO->obtenerEmpresaPorIdFiscales($idFiscales);
		
		$fiscalesClientes = $this->fiscalesDAO->getFiscalesClientesByIdFiscalesEmpresa($idFiscales);
		if(!is_null($fiscalesClientes)){
			echo Zend_Json::encode($fiscalesClientes);
		}else{
			echo Zend_Json::encode(array());
		}
		
	}
	
	public function proveedoreseAction() {
		$idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
	}
	
	public function asocclienteAction() {
		//Si llegamos aqui es por que en verdad se hace la asociacion
		$idFiscalesEmpresa = $this->getParam("idFiscalesEmpresa");
		$idFiscalesCliente = $this->getParam("idFiscalesCliente");
		
		$fiscalesDAO = $this->fiscalesDAO;
		$empresaDAO = $this->empresaDAO;
		
		$empresaEmpresa = $empresaDAO->obtenerEmpresaPorIdFiscales($idFiscalesEmpresa);
		$empresaCliente = $empresaDAO->obtenerEmpresaPorIdFiscales($idFiscalesCliente);
		
		$tablaClientesEmpresa = $this->tablaClientesEmpresa;
		
		
	}
<<<<<<< HEAD
	
	public function bancosempresaAction() {
		$idBanco = $this->getParam("idBanco");
		$bancosEmpresa = $this->bancosEmpresaDAO->obtenerBancosEmpresa($idBanco);
		
	}

=======
>>>>>>> 365a6f8042fb7d54e1f4e3f868f8bd51262d636d
}