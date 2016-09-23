<?php

class Biblioteca_LibroController extends Zend_Controller_Action
{

    private $libroDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->libroDAO = new Biblioteca_DAO_Libro;
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
		
        $formulario = new Biblioteca_Form_AltaLibro();
		//$this->view->formulario = $formulario;
		//print_r($request->getPost());
		if ( $request->isGet() ) {
			$this->view->formulario = $formulario;
		} elseif ($request->isPost()) {
			if ($formulario->isValid($request->getPost())) {
				$datos = $formulario->getValues();
				
				$libro = new Biblioteca_Model_Libro($datos);
				
				try{
					$this->libroDAO->agregarLibro($libro);
					$this->view->messageSuccess = "El libro: <strong>".$libro->getTitulo()."</strong> ha sido agregada ";
				}catch(Exception $ex){
					$this->view->messageFail = "El libro: <strong>".$libro->getTitulo()."</strong> no ha sido agregada. Error: <strong>".$ex->getMessage()."<strong>";
				}
				
			}
			
		}
    }

    public function consultaAction()
    {
        // action body
    }


}





