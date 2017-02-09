<?php

class Biblioteca_ConsultaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function librosAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Biblioteca_Forms_AltaLibro;
		if ($request->isGet()) {
			$this->view->formulario = $formulario;
		} else {
			if($formulario->isValid($request->getPost())){
				print_r("formulario recibido!!");
			}
		}
		
    }

    public function multimediaAction()
    {
        // action body
    }

    public function revistasAction()
    {
        // action body
    }


}







