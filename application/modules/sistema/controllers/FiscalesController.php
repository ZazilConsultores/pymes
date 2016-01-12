<?php

class Sistema_FiscalesController extends Zend_Controller_Action
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
        $formulario = new Sistema_Form_AltaFiscales;
		$this->view->formulario = $formulario;
    }


}



