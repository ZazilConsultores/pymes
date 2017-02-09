<?php

class Contabilidad_PolizaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function generarAction()
    {
     	$formulario = new Contabilidad_Form_GeneraPoliza;
		$this->view->formulario = $formulario;   
    }


}



