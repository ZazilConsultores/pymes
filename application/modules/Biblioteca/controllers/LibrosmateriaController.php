<?php

class Biblioteca_LibrosmateriaController extends Zend_Controller_Action
{

	private $librosMateriaDAO;
	
    public function init()
    {
        /* Initialize action controller here */
        $this->librosMateriaDAO = new Biblioteca_DAO_LibrosMateria;
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
    	$idMateria = $this -> getParam("idMateria");
		print_r($idMateria);
         $request = $this->getRequest();
		
        $formulario = new Biblioteca_Form_AltaLibrosMateria();
		//$this->view->formulario = $formulario;
		//print_r($request->getPost());
		if ( $request->isGet() ) {
			$this->view->formulario = $formulario;
		} elseif ($request->isPost()) {
			if ($formulario->isValid($request->getPost())) {
				$datos = $formulario->getValues();
				
				$librosMateria = new Biblioteca_Model_LibrosMateria($datos);
				
				try{
					//$this->librosMateriaDAO->agregarLibrosMateria($datos);
					$this->librosMateriaDAO->agregarLibrosMateria($librosMateria);
					$this->view->messageSuccess = "Exito en la inserción ";
				}catch(Exception $ex){
					$this->view->messageFail = "Fallo al insertar en la BD Error:".$ex->getMessage()."<strong>";
				}
				
			}
			
		}
    }


}




