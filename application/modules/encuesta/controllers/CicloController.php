<?php

class Encuesta_CicloController extends Zend_Controller_Action
{

    private $cicloDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->cicloDAO = new Encuesta_DAO_Ciclo;
    }

    public function indexAction()
    {
        // action body
        $ciclos = $this->cicloDAO->obtenerCiclos();
        $this->view->ciclos = $ciclos;
    }

    public function adminAction()
    {
        // action body
    }

    public function altaAction()
    {
        // action body
        $formulario = new Encuesta_Form_AltaCiclo;
		$this->view->formulario = $formulario;
		
    }

    public function editaAction()
    {
        // action body
    }


}







