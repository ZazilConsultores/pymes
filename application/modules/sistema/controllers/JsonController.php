<?php

class Sistema_JsonController extends Zend_Controller_Action
{
	private $municipioDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		//$this->_helper->contextSwitch()->setAutoJsonSerialization(false);
		
        $this->municipioDAO = new Inventario_DAO_Municipio;
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


}



