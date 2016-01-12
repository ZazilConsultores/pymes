<?php

class Sistema_TelefonoController extends Zend_Controller_Action
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
        $formulario = new Sistema_Form_AltaTelefono;
		$this->view->formulario = $formulario;
    }


}



