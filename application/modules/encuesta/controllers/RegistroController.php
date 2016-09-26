<?php

class Encuesta_RegistroController extends Zend_Controller_Action
{

    private $registroDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->registroDAO = new Encuesta_DAO_Registro;
    }

    public function indexAction()
    {
        // action body
        $registros = $this->registroDAO->obtenerRegistros();
		$this->view->registros = $registros;
    }

    public function altaAction()
    {
        // action body
        $formulario = new Encuesta_Form_AltaRegistro;
		$request = $this->getRequest();
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//$registro = new Encuesta_Model_Registro($datos);
				//$registro->setHash($registro->getHash());
				//$registro->setFecha($datos["fecha"] = date("Y-m-d H:i:s", time()));
				try{
					$this->registroDAO->crearRegistro($datos);
					$this->view->messageSuccess = "Registro de : <strong>" .$datos["nombres"].", ".$datos["apellidos"]."</strong> creado exitosamente.";
				}catch(Exception $ex){
					$this->view->messageFail = $ex->getMessage();
				}
				//$this->_helper->redirector->gotoSimple("index", "registro", "encuesta");
			}
		}
    }


}



