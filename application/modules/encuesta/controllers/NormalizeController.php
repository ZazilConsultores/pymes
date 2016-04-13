<?php

class Encuesta_NormalizeController extends Zend_Controller_Action
{
	private $opcionDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->opcionDAO = new Encuesta_DAO_Opcion;
    }

    public function indexAction()
    {
        // action body
    }

    public function preferenciapAction()
    {
        // action body
        try{
        	$this->opcionDAO->normalizarOpciones();
        }catch(Exception $ex){
        	
        }
    }


}



