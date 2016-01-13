<?php

class Encuesta_HtmlController extends Zend_Controller_Action
{
	private $encuestaDAO;
	private $seccionDAO;
	private $grupoDAO;
	private $preguntaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
		
		$this->encuestaDAO = new Encuesta_DAO_Encuesta;
		$this->seccionDAO = new Encuesta_DAO_Seccion;
		$this->grupoDAO = new Encuesta_DAO_Grupo;
		$this->preguntaDAO = new Encuesta_DAO_Pregunta;
    }

    public function indexAction()
    {
        // action body
    }

    public function encuestadetAction()
    {
        // action body
        $request = $this->getRequest();
		if($request->isXmlHttpRequest()){
			$idEncuesta = $this->getParam("idEncuesta");
			if(! is_null($idEncuesta)){
				$encuestaDAO = $this->encuestaDAO; 
	        	$this->view->encuesta = $encuestaDAO->obtenerEncuesta($idEncuesta);
			}
		}
    }

    public function seccionesAction()
    {
        // action body
        $request = $this->getRequest();
		$idEncuesta = $this->getParam("idEncuesta");
		if($request->isXmlHttpRequest()) {
			$seccionDAO = $this->seccionDAO;
			$encuestaDAO = $this->encuestaDAO;
			$this->view->secciones = $seccionDAO->obtenerSecciones($idEncuesta);
			$this->view->encuesta = $encuestaDAO->obtenerEncuesta($idEncuesta);
		}
    }

    public function secciondetAction()
    {
        // action body
        $request = $this->getRequest();
		$idSeccion = $this->getParam("idSeccion");
		if($request->isXmlHttpRequest()){

			if(! is_null($idSeccion)){
				$seccionDAO = $this->seccionDAO;
				$encuestaDAO = $this->encuestaDAO;
				
				$seccion = $seccionDAO->obtenerSeccion($idSeccion);
				
	        	$this->view->seccion = $seccion;
	        	$this->view->encuesta = $encuestaDAO->obtenerEncuesta($seccion->getIdEncuesta());
			}
		}
    }

    public function gruposAction()
    {
        // action body
        $request = $this->getRequest();
		$idSeccion = $this->getParam("idSeccion");
		//if($request->isXmlHttpRequest()) {
			$seccionDAO = $this->seccionDAO;
			$grupoDAO = $this->grupoDAO;
			//$seccion = $seccionDAO->obtenerSeccionId($idSeccion);
			//$grupos = $grupoDAO->obtenerGrupos($idSeccion);
			$this->view->seccion = $seccionDAO->obtenerSeccion($idSeccion);
			$this->view->grupos = $grupoDAO->obtenerGrupos($idSeccion);
		//}
    }

    public function grupodetAction()
    {
        // action body
        $request = $this->getRequest();
		
		$idGrupo = $this->getParam("idGrupo");
		if($request->isXmlHttpRequest()){
			$grupoDAO = $this->grupoDAO;
			if(!is_null($idGrupo)){
				$grupo = $grupoDAO->obtenerGrupoId($idGrupo);
				$this->view->grupo = $grupo;
			}
		}
    }

    public function preguntasAction()
    {
        // action body
        $request = $this->getRequest();
		$idSeccion = $this->getParam("idSeccion"); 
		$idGrupo = $this->getParam("idGrupo");
		//if($request->isXmlHttpRequest()){
			$preguntaDAO = $this->preguntaDAO;
			if(!is_null($idSeccion)) {
				$seccionDAO = $this->seccionDAO;
				$this->view->seccion = $seccionDAO->obtenerSeccion($idSeccion);
				$this->view->preguntas = $preguntaDAO->obtenerPreguntas($idSeccion, "S");
			}else if(!is_null($idGrupo)) {
				$grupoDAO = $this->grupoDAO;
				$this->view->grupo = $grupoDAO->obtenerGrupo($idGrupo);
				$this->view->preguntas = $preguntaDAO->obtenerPreguntas($idGrupo, "G");
			}
		//}
    }

    public function preguntadetAction()
    {
        // action body
        $request = $this->getRequest();
		
		$idPregunta = $this->getParam("idPregunta");
		$preguntaDAO = new Encuesta_DAO_Pregunta;
		
		if($request->isXmlHttpRequest()){
			$this->view->pregunta = $preguntaDAO->obtenerPreguntaId($idPregunta);
		}
    }


}

















