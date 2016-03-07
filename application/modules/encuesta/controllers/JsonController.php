<?php

class Encuesta_JsonController extends Zend_Controller_Action
{

    private $gradosDAO = null;
	private $gruposDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->gradosDAO = new Encuesta_DAO_Grado;
		$this->gruposDAO = new Encuesta_DAO_Grupos;
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

    public function gruposAction()
    {
        // action body
        $idCiclo = $this->getParam("idCiclo");
		$idGrado = $this->getParam("idGrado");
		$grupos = $this->gruposDAO->obtenerGrupos($idGrado, $idCiclo);
		$arrayGrupos = array();
		
		foreach ($grupos as $grupo) {
			$arrayGrupos[] = array("idGrupo"=>$grupo->getIdGrupo(),"grupo"=>$grupo->getGrupo());
		}
		
		echo Zend_Json::encode($arrayGrupos);
    }


}





