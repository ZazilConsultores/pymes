<?php

class Encuesta_SeccionController extends Zend_Controller_Action
{
	private $encuestaDAO;
    private $seccionDAO;
	private $grupoDAO;
	private $preguntaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->encuestaDAO = new Encuesta_DAO_Encuesta;
		$this->seccionDAO = new Encuesta_DAO_Seccion;
		$this->grupoDAO = new Encuesta_DAO_Grupo;
		$this->preguntaDAO = new Encuesta_DAO_Pregunta;
    }

    public function indexAction()
    {
        // action body
        $idSeccion = $this->getParam("idSeccion");
		if(! is_null($idSeccion)) {
			$this->view->seccion = $this->seccionDAO->obtenerSeccion($idSeccion);
			$this->view->elementos = $this->seccionDAO->obtenerElementos($idSeccion);
		}else{
			//Redirect
			$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
		}
    }

    public function adminAction()
    {
        // action body
        $idSeccion = $this->getParam("idSeccion");
		if(! is_null($idSeccion)) {
			$seccion = $this->seccionDAO->obtenerSeccion($idSeccion);
			$this->view->seccion = $seccion;
			$this->view->grupos = $this->grupoDAO->obtenerGrupos($idSeccion);
			$this->view->preguntas = $this->preguntaDAO->obtenerPreguntas($idSeccion, "S");
			
			
			$formulario = new Encuesta_Form_AltaSeccion;
			$formulario->getElement("nombre")->setValue($seccion->getNombre());
			$formulario->getElement("submit")->setLabel("Actualizar seccion");
			
			$this->view->formulario = $formulario;
		}else{
			//Redirect
			$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
		}
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
		$idEncuesta = $this->getParam("idEncuesta");
		$formulario = new Encuesta_Form_AltaSeccion();
		if($request->isGet()){
			if(!is_null($idEncuesta)){
				$encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
				
				$this->view->encuesta = $encuesta;
				$this->view->formulario = $formulario;
			}else{
				$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
			}
		}else if($request->isPost()) {
			if($formulario->isValid($request->getPost())) {
				
				$datos = $formulario->getValues();
				
				$seccion = new Encuesta_Model_Seccion($datos);
				$seccion->setIdEncuesta($idEncuesta);
				$seccion->setFecha(date("Y-m-d H:i:s", time()));
				
				$this->seccionDAO->crearSeccion($seccion);
				
				$this->_helper->redirector->gotoSimple("index", "index", "encuesta", array("idEncuesta" => $idEncuesta));
			}
		}
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









