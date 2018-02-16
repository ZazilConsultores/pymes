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

    private $empresasDAO = null;
    private $coloniaDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		//$this->_helper->contextSwitch()->setAutoJsonSerialization(false);
		
        $this->municipioDAO = new Inventario_DAO_Municipio;
		$this->empresaDAO = new Sistema_DAO_Empresa;
		$this->empresasDAO = new Sistema_DAO_Empresas;
		$this->estadoDAO = new Sistema_DAO_Estado;
		$this->sucursalDAO = new Sistema_DAO_Sucursal;
		$this->proyectoDAO = new Contabilidad_DAO_Proyecto;
		$this->multiploDAO = new Inventario_DAO_Multiplo;
		$this->bancosEmpresaDAO = new Contabilidad_DAO_Fondeo;
		$this->coloniaDAO = new Sistema_DAO_Colonia;
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
        $idEmpresas = $this->getParam("idFiscales");
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

    public function saldocxpmesAction()
    {
        $mes = $this->getParam("mm");

        $saldoM  = $this->empresasDAO->obtenerSaldoCXP($mes, $anio);
        
        if(!is_null($saldoM)){
            echo Zend_Json::encode($saldoM);
        }else{
            echo Zend_Json::encode(array());
        }
    }

    public function saldocxcmesAction()
    {
        $mes = $this->getParam("mm");
        $saldoMCXC  = $this->empresasDAO->obtenerSaldoCXC($mes);
        if(!is_null($saldoMCXC)){
            echo Zend_Json::encode($saldoMCXC);
        }else{
            echo Zend_Json::encode(array());
        }
    }

    public function saldoempresamesAction()
    {
        $mes = $this->getParam("mm");
        $anio = $this->getParam("anio");
        
        $saldoEmpresaMes  = $this->empresasDAO->obtenerSaldoEmpresasPorMes($mes, $anio);
        if(!is_null($saldoEmpresaMes)){
            echo Zend_Json::encode($saldoEmpresaMes);
        }else{
            echo Zend_Json::encode(array());
        }
    }

    public function saldobancoAction()
    {
        $idEmpresa = $this->getParam("em");
        $idBanco = $this->getParam("ban");
        $saldoBanco  = $this->empresasDAO->obtenerSaldoxBanco($idEmpresa, $idBanco);
        if(!is_null($saldoBanco)){
            echo Zend_Json::encode($saldoBanco);
        }else{
            echo Zend_Json::encode(array());
        }
    }

    public function coloniasAction()
    {
        // action body
        $idMunicipio = $this->getParam("mun");
        $colonias = $this->municipioDAO->obtenerColonias($idMunicipio);
        
        $arrayColonias = array();
        
        foreach ($colonias as $colonia) {
            //$arrayMunicipios[] = array("idMunicipio"=>$municipio->getIdMunicipio(), "municipio"=>$municipio->getMunicipio());
        
            $arrayColonias[] = array("idColonia"=>$colonia->getIdColonia(), "colonia"=>$colonia->getColonia(), "CP"=>$colonia->getCP());
        }
        //print_r($municipios);
        //$this->view->jsonArray = json_encode($arrayMunicipios);
        //return json_encode($arrayMunicipios);
        echo Zend_Json::encode($arrayColonias);
    }

    public function obtienecpAction()
    {
        $col = $this->getParam("col");
        $colonia  = $this->coloniaDAO->obtenerColonia($col);
        if(!is_null($colonia)){
            echo Zend_Json::encode($colonia);
        }else{
            echo Zend_Json::encode(array());
        }
    }


}















