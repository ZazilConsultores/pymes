<?php

class Inventario_JsonController extends Zend_Controller_Action
{

    private $unidadDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$this->unidadDAO = new Inventario_DAO_Unidad;
    }

    public function indexAction()
    {
        // action body
    }

    public function unidadesAction()
    {
        // action body
        $idUnidad = $this->getParam("idUnidad");
       	$unidades = $this->unidadDAO->obtenerUnidad($idUnidad);
		
		$arrayUnidades = array();
		
		foreach ($unidades as $unidad) {
			$arrayUnidades[] = array("idUnidad"=>$unidad->getIdUnidad(), "unidad"=>$unidad->getAbreviatura());
		}
		echo Zend_Json::encode($arrayUnidades);
    }


}



