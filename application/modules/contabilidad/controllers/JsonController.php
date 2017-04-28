<?php

class Contabilidad_JsonController extends Zend_Controller_Action
{

    private $bancoDAO = null;

    private $fiscalesDAO = null;

    private $impuestoProductosDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->bancoDAO = new Contabilidad_DAO_Banco;
		$this->impuestoProductosDAO = new Contabilidad_DAO_Impuesto;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		
    }

    public function indexAction()
    {
        // action body
    }

    public function bancosempresaAction()
    {
    	$idEmpresa = $this->getParam("emp");
		//print_r($idEmpresa);
		
		$bancosEmpresa = $this->bancoDAO->obtenerBancosEmpresa($idEmpresa);
		
		if(!is_null($bancosEmpresa)){
			echo Zend_Json::encode($bancosEmpresa);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function impuestosAction()
    {
        // action body
        $idImpuesto = $this->getParam("idImpuesto");
		
		$impuestoProducto = $this->impuestoProductosDAO->obtenerImpuestoProductos($idImpuesto);
		
		if(!is_null($impuestoProducto)){
			echo Zend_Json::encode($impuestoProducto);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function clienteseAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		
		$fiscalesClientes = $this->fiscalesDAO->getFiscalesClientesByIdFiscalesEmpresa($idFiscales);
		if(!is_null($fiscalesClientes)){
			echo Zend_Json::encode($fiscalesClientes);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function proveedoreseAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		
		$fiscalesProveedores = $this->fiscalesDAO->getFiscalesProveedoresByIdFiscalesEmpresa($idFiscales);
		if(!is_null($fiscalesProveedores)){
			echo Zend_Json::encode($fiscalesProveedores);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function sucursalAction()
    {
        // action body
        $idSucursal = $this->getParam("idSucursal");
		
		$sucursal = $this->empresaDAO->obtenerSucursal($idSucursal);
		if(!is_null($sucursal)){
			echo Zend_Json::encode($sucursal);
		}else{
			echo Zend_Json::encode(array());
		}	
    }


}











