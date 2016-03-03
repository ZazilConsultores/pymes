<?php

class Encuesta_GradoController extends Zend_Controller_Action
{
	private $nivelDAO;
	private $gradoDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->nivelDAO = new Encuesta_DAO_Nivel;
        $this->gradoDAO = new Encuesta_DAO_Grado;
    }

    public function indexAction()
    {
        // action body
        $idNivel = $this->getParam("idNivel");
		$nivel = $this->nivelDAO->obtenerNivel($idNivel);
		$grados = $this->gradoDAO->obtenerGrados($idNivel);
		$this->view->nivel = $nivel;
		$this->view->grados = $grados;
    }

    public function altaAction()
    {
        // action body
        $idNivel = $this->getParam("idNivel");
		$nivel = $this->nivelDAO->obtenerNivel($idNivel);
		$formulario = new Encuesta_Form_AltaGrado;
		$request = $this->getRequest();
		
		$this->view->nivel = $nivel;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$grado = new Encuesta_Model_Grado($datos);
				$grado->setIdNivel($idNivel);
				//$grado->setAbreviatura(addslashes($datos["abreviatura"]));
				try{
					$this->gradoDAO->crearGrado($grado);
					$this->view->messageSuccess = "Grado: <strong>".$grado->getGrado()."</strong> dado de alta al Nivel: <strong>".$nivel->getNivel()."</strong> exitosamente.";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
				
				//print_r($datos);
				//$this->_helper->redirector->gotoSimple("index", "grado", "encuesta",array("idNivel"=>$idNivel));
			}
		}
    }

    public function adminAction()
    {
        // action body
        //$idNivel = $this->getParam("idNivel");
		//$nivel = $this->nivelDAO->obtenerNivel($idNivel);
		
		$idGrado = $this->getParam("idGrado");
		$grado = $this->gradoDAO->obtenerGrado($idGrado);
		$formulario = new Encuesta_Form_AltaGrado;
		$formulario->getElement("grado")->setValue($grado->getGrado());
		$formulario->getElement("descripcion")->setValue($grado->getDescripcion());
		//$formulario->getElement("objetivo")->setValue($grado->getObjetivo());
		
		$this->view->grado = $grado;
		$this->view->formulario = $formulario;
		
    }

    public function editaAction()
    {
        // action body
    }

    public function bajaAction()
    {
        // action body
    }


}









