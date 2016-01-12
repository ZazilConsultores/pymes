<?php

class Sistema_MunicipiosController extends Zend_Controller_Action
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
        $formulario = new Sistema_Form_AltaMunicipio;
		$this->view->formulario = $formulario;
    }


}



