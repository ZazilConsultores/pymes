<?php

class Encuesta_NivelController extends Zend_Controller_Action
{

    private $nivelDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->nivelDAO = new Encuesta_DAO_Nivel;
    }

    public function indexAction()
    {
        // action body
        $niveles = $this->nivelDAO->obtenerNiveles();
		$this->view->niveles = $niveles;
    }

    public function adminAction()
    {
        // action body
    }

    public function altaAction()
    {
        // action body
        $formulario = new Encuesta_Form_AltaNivel;
		$request = $this->getRequest();
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//$nivel = new Encuesta_Model_Nivel($datos);
				
				try{
					$this->nivelDAO->crearNivel($datos);
					$this->view->messageSuccess = "Nivel Educativo: <strong>" .$datos["nivelEducativo"]."</strong> creado exitosamente.";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
			}
		}
    }

    public function editaAction()
    {
        // action body
    }


}







