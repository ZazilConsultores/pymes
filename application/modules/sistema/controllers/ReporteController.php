<?php

class Sistema_ReporteController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
        // action body
        $formulario = new Sistema_Form_AltaReporte();
		$this->view->formulario = $formulario;
    }


}



