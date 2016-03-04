<?php

class Encuesta_MateriaController extends Zend_Controller_Action
{
	
	private $materiaDAO;
	
    public function init()
    {
        /* Initialize action controller here */
        $this->materiaDAO = new Encuesta_DAO_Materia;
    }

    public function indexAction()
    {
        // action body
    }

    public function adminAction()
    {
        // action body
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Encuesta_Form_AltaMateria;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$this->view->datos = $datos;
			}
		}
		
    }

    public function editaAction()
    {
        // action body
    }


}







