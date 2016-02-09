<?php

class Contabilidad_BancoController extends Zend_Controller_Action
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
        $formularioAgregarBanco = new Contabilidad_Form_AltaBanco;
        $this->view->formulario = $formularioAgregarBanco;	
    }


}



