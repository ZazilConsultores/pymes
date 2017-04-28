<?php

class Contabilidad_OperaController extends Zend_Controller_Action
{
	
	private $fiscalesDAO;
	private $empresaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->fiscalesDAO = new Sistema_DAO_Fiscales;
        $this->empresaDAO = new Sistema_DAO_Empresa;
    }

    public function indexAction() {
    	
    }
	
	/**
	 * 
	 */
    public function asocclienteeAction() {
        $idFiscalesEmpresa = $this->getParam("idFiscalesEmpresa");
		$idFiscalesCliente = $this->getParam("idFiscalesCliente");
		
		print_r($idFiscalesCliente . "<br />");
		//print_r($idFiscalesEmpresa . "<br />");
		
		/*$fiscalesDAO = $this->fiscalesDAO;
		
		$empresa = $fiscalesDAO->getEmpresaByIdFiscales($idFiscalesEmpresa);
		$cliente = $fiscalesDAO->getClienteByIdFiscales($idFiscalesCliente);
		*/
		$this->fiscalesDAO->asociateClienteEmpresa($idFiscalesEmpresa, $idFiscalesCliente);
    }
	
	public function asocproveedoreAction() {
		$idFiscalesEmpresa = $this->getParam("idFiscalesEmpresa");
		$idFiscalesProveedor = $this->getParam("idFiscalesProveedor");
		
		$fiscalesDAO = $this->fiscalesDAO;
		
		$empresa = $fiscalesDAO->getEmpresaByIdFiscales($idFiscalesEmpresa);
		
	}
}







