<?php

class Sistema_JsonController extends Zend_Controller_Action
{

    private $municipioDAO = null;
	private $estadoDAO = null;
	private $sucursalDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		//$this->_helper->contextSwitch()->setAutoJsonSerialization(false);
		
        $this->municipioDAO = new Inventario_DAO_Municipio;
		$this->estadoDAO = new Sistema_DAO_Estado;
		$this->sucursalDAO = new Sistema_DAO_Sucursal;
    }

    public function indexAction()
    {
        // action body
    }

    public function municipiosAction()
    {
        // action body
        $idEstado = $this->getParam("idEstado");
        $municipios = $this->municipioDAO->obtenerMunicipios($idEstado);
		
		$arrayMunicipios = array();
		
		foreach ($municipios as $municipio) {
			$arrayMunicipios[] = array("idMunicipio"=>$municipio->getIdMunicipio(), "municipio"=>$municipio->getMunicipio());
		}
		//print_r($municipios);
		//$this->view->jsonArray = json_encode($arrayMunicipios); 
		//return json_encode($arrayMunicipios);
		echo Zend_Json::encode($arrayMunicipios);
    }

    public function sdomicilioAction()
    {
        // action body
        $idSucursal = $this->getParam("idSucursal");
		$sdomicilio = $this->sucursalDAO->obtenerDomicilioSucursal($idSucursal);
		$municipio = $this->municipioDAO->obtenerMunicipio($sdomicilio["idMunicipio"]);
		$estado = $this->estadoDAO->obtenerEstado($municipio->getIdEstado());
		$sdomicilio["estado"] = $estado->toArray();
		$sdomicilio["municipio"] = $municipio->toArray();
		echo Zend_Json::encode($sdomicilio);
		
    }
	
    public function stelefonosAction()
    {
        // action body
        $idSucursal = $this->getParam("idSucursal");
		$stelefonos = $this->sucursalDAO->obtenerTelefonosSucursal($idSucursal);
		echo Zend_Json::encode($stelefonos);
    }

    public function semailsAction()
    {
        // action body
        $idSucursal = $this->getParam("idSucursal");
		$semails = $this->sucursalDAO->obtenerEmailsSucursal($idSucursal);
		echo Zend_Json::encode($semails);
    }
	
	public function sucursalesAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		$sucursales = $this->sucursalDAO->obtenerSucursales($idFiscales);
		echo Zend_Json::encode($sucursales);
    }
    


}









