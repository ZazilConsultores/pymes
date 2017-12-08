<?php

class Sistema_JsonController extends Zend_Controller_Action
{

    private $municipioDAO = null;

    private $estadoDAO = null;

    private $sucursalDAO = null;

    private $proyectoDAO = null;

    private $multiplos = null;

    private $bancosEmpresa = null;

    private $empresaDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		//$this->_helper->contextSwitch()->setAutoJsonSerialization(false);
		
        $this->municipioDAO = new Inventario_DAO_Municipio;
		$this->empresaDAO = new Sistema_DAO_Empresa;
		$this->estadoDAO = new Sistema_DAO_Estado;
		$this->sucursalDAO = new Sistema_DAO_Sucursal;
		$this->proyectoDAO = new Contabilidad_DAO_Proyecto;
		$this->multiploDAO = new Inventario_DAO_Multiplo;
		$this->bancosEmpresaDAO = new Contabilidad_DAO_Fondeo;
		$this->db = Zend_Db_Table::getDefaultAdapter();
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
        $idEmpresas = $this->getParam("idFiscales");
		//$sucursales = $this->sucursalDAO->obtenerSucursales($idFiscales);
		$sucursales = $this->empresaDAO->obtenerSucursalesEmpresas($idEmpresas);
		echo Zend_Json::encode($sucursales);
    }

    public function proyectosAction()
    {
        // action body
       	$idSucursal = $this->getParam("idSucursal");
		$proyectos = $this->proyectoDAO->obtenerProyecto($idSucursal);
		echo Zend_Json::encode($proyectos);

    }

    public function multiplosAction()
    {
        $idProducto = $this->getParam("idProducto");
		$select = $this->db->select()->from("Multiplos","idMultiplos")
		->join("Unidad", "Unidad.idUnidad = Multiplos.idUnidad")->where("idProducto=?",$idProducto);
		$statement = $select->query();
		$rowsMultiplo = $statement->fetchAll();
		echo  Zend_Json::encode($rowsMultiplo);
		
    }

    public function saldoempresasAction()
    {
        $idBanco = $this->getParam("ban");
        $fechaI = $this->getParam("fechaI");
        $fechaF = $this->getParam("fechaF");
        $saldoM  = $this->empresaDAO->saldoEmpresas($idBanco, $fechaI, $fechaF);
       
        if(!is_null($proyectoRemSalCafePen)){
            echo Zend_Json::encode($proyectoRemSalCafePen);
        }else{
            echo Zend_Json::encode(array());
        }
        
    }


}



