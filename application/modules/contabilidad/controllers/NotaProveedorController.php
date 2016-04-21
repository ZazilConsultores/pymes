<?php

class Contabilidad_NotaproveedorController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $formulario = new Contabilidad_Form_NuevaNotaProveedor;
		$this->view->formulario = $formulario;
    }

    public function nuevaAction()
    {
        // action body
    }


}





