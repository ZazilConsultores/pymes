<?php

class Contabilidad_JsonController extends Zend_Controller_Action
{
	
	private $empresaDAO;
	private $fiscalesDAO;
	private $bancosEmpresaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Sistema_DAO_Empresa;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		$this->bancosEmpresaDAO = new Contabilidad_DAO_Fondeo;
    }

    public function indexAction() {
    	
    }
	
	public function clienteseAction() {
		$idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		//Obtenemos los registros en Tabla ClientesEmpresa
		$clientese = $this->empresaDAO->obtenerClientesEmpresa($idFiscales);
		
	}
	
	public function proveedoreseAction() {
		$idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		
		
	}
	
	public function bancosempresaAction() {
		$idBanco = $this->getParam("idBanco");
		$bancosEmpresa = $this->bancosEmpresaDAO->obtenerBancosEmpresa($idBanco);
		
	}

}