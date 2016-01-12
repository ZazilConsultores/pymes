<?php

class Sistema_EmailController extends Zend_Controller_Action
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
        $formulario = new Sistema_Form_AltaEmail;
		$this->view->formulario = $formulario;
    }


}



