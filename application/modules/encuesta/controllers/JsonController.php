<?php

class Encuesta_JsonController extends Zend_Controller_Action
{
	private $gradosDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->gradosDAO = new Encuesta_DAO_Grado;
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
        // action body
    }

    public function gradosAction()
    {
        // action body
        $idNivel = $this->getParam("idNivel");
		$grados = $this->gradosDAO->obtenerGrados($idNivel);
		
		$arrayGrados = array();
		
		foreach ($grados as $grado) {
			$arrayGrados[] = array("idGrado"=>$grado->getIdGrado(), "grado"=>$grado->getGrado());
		}
		
		echo Zend_Json::encode($arrayGrados);
    }


}



