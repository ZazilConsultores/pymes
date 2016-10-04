<?php

class Encuesta_ConsultaController extends Zend_Controller_Action
{
	
	private $nivelDAO = null;
	
    public function init()
    {
        /* Initialize action controller here */
        $this->nivelDAO = new Encuesta_DAO_Nivel;
    }

    public function indexAction()
    {
        // action body
        $niveles = $this->nivelDAO->obtenerNiveles();
		$this->view->niveles = $niveles;
    }


}

