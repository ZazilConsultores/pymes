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
		$hash = $this->getParam("hash");
		//if($request->isXmlHttpRequest()) {
			$encuestaDAO = $this->encuestaDAO; 
	        $this->view->encuesta = $encuestaDAO->obtenerEncuestaHash($hash);
		//}
    }

    public function seccionesAction()
    {
        // action body
        $request = $this->getRequest();
		$hash = $this->getParam("hash");
		//if($request->isXmlHttpRequest()) {
			$seccionDAO = $this->seccionDAO;
			$encuestaDAO = $this->encuestaDAO;
			$encuesta = $encuestaDAO->obtenerEncuestaHash($hash);
			
			$this->view->encuesta = $encuesta;
			$this->view->secciones = $seccionDAO->obtenerSecciones($encuesta->getIdEncuesta());
		//}
    }

    public function secciondetAction()
    {
        // action body
        $request = $this->getRequest();
		$hash = $this->getParam("hash");
		//if($request->isXmlHttpRequest()){
			$seccionDAO = $this->seccionDAO;
			$encuestaDAO = $this->encuestaDAO;
			$seccion = $seccionDAO->obtenerSeccionHash($hash);
			
        	$this->view->seccion = $seccion;
        	$this->view->encuesta = $encuestaDAO->obtenerEncuesta($seccion->getIdEncuesta());
		//}
    }

    public function gruposAction()
    {
        // action body
        $request = $this->getRequest();
		$hash = $this->getParam("hash");
		//if($request->isXmlHttpRequest()) {
			$seccionDAO = $this->seccionDAO;
			
			$seccion = $seccionDAO->obtenerSeccionHash($hash);
			$grupos = $seccionDAO->obtenerGrupos($seccion->getIdSeccion());
			
			$this->view->seccion = $seccion;
			$this->view->grupos = $grupos;
		//}
    }

    public function grupodetAction()
    {
        // action body
        $request = $this->getRequest();
		
		$hash = $this->getParam("hash");
		//if($request->isXmlHttpRequest()){
			$grupoDAO = $this->grupoDAO;
			$grupo = $grupoDAO->obtenerGrupoHash($hash);
			$this->view->grupo = $grupo;
		//}
    }

    public function preguntasAction()
    {
        // action body
        $request = $this->getRequest();
		$hashSeccion = $this->getParam("hashSeccion"); 
		$hashGrupo = $this->getParam("hashGrupo");
		
		if($request->isXmlHttpRequest()){
			$preguntaDAO = $this->preguntaDAO;
			if(!is_null($hashSeccion)) {
				$seccionDAO = $this->seccionDAO;
				$seccion = $seccionDAO->obtenerSeccionHash($hashSeccion);
				
				$this->view->seccion = $seccion;
				$this->view->preguntas = $preguntaDAO->obtenerPreguntas($seccion->getIdSeccion(), "S");
			}else if(!is_null($hashGrupo)) {
				$grupoDAO = $this->grupoDAO;
				$grupo = $grupoDAO->obtenerGrupoHash($hashGrupo);
				$this->view->grupo = $grupo;
				$this->view->preguntas = $preguntaDAO->obtenerPreguntas($grupo->getIdGrupo(), "G");
			}
		}
    }

    public function preguntadetAction()
    {
        // action body
        $request = $this->getRequest();
		
		$hash = $this->getParam("hash");
		$preguntaDAO = new Encuesta_DAO_Pregunta;
		
		if($request->isXmlHttpRequest()){
			$this->view->pregunta = $preguntaDAO->obtenerPreguntaHash($hash);
		}
    }


}

















