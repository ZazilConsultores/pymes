<?php

class Encuesta_HtmlController extends Zend_Controller_Action
{

    private $encuestaDAO = null;
    private $seccionDAO = null;
    private $grupoDAO = null;
    private $preguntaDAO = null;

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
		$claveEncuesta = $this->getParam("claveEncuesta");
		if($request->isXmlHttpRequest()) {
			$encuestaDAO = $this->encuestaDAO;
			$this->view->encuesta = $encuestaDAO->getEncuestaById($claveEncuesta);
		}
    }

    public function seccionesAction()
    {
        // action body
        $request = $this->getRequest();
		$claveEncuesta = $this->getParam("claveEncuesta");
		if($request->isXmlHttpRequest()) {
			$seccionDAO = $this->seccionDAO;
			$encuestaDAO = $this->encuestaDAO;
			
			$this->view->encuesta = $encuestaDAO->getEncuestaById($claveEncuesta);
			$this->view->secciones = $seccionDAO->getSeccionesByIdEncuesta($claveEncuesta);
		}
    }

    public function secciondetAction()
    {
        // action body
        $request = $this->getRequest();
		$claveSeccion = $this->getParam("claveSeccion");
		if($request->isXmlHttpRequest()){
			$seccionDAO = $this->seccionDAO;
			$encuestaDAO = $this->encuestaDAO;
			
			$seccion = $seccionDAO->getSeccionById($claveSeccion);
			//$seccion = $seccionDAO->obtenerSeccionHash($hash);
			
        	$this->view->seccion = $seccion;
        	$this->view->encuesta = $encuestaDAO->getEncuestaById($seccion->getIdEncuesta());
		}
    }

    public function gruposAction()
    {
        // action body
        $request = $this->getRequest();
		$claveSeccion = $this->getParam("claveSeccion");
		
		if($request->isXmlHttpRequest()) {
			$seccionDAO = $this->seccionDAO;
			
			$seccion = $seccionDAO->getSeccionById($claveSeccion);
			//$grupos = $seccionDAO->get
			$grupos = $seccionDAO->obtenerGrupos($seccion->getIdSeccionEncuesta());
			
			$this->view->seccion = $seccion;
			$this->view->grupos = $grupos;
		}
    }

    public function grupodetAction()
    {
        // action body
        $request = $this->getRequest();
		$claveGrupo = $this->getParam("claveGrupo");
		$hash = $this->getParam("hash");
		//if($request->isXmlHttpRequest()){
			$grupoDAO = $this->grupoDAO;
			$grupo = $grupoDAO->obtenerGrupo($claveGrupo);
			$this->view->grupo = $grupo;
		//}
    }

    public function preguntasAction()
    {
        // action body
        $request = $this->getRequest();
		$claveSeccion = $this->getParam("claveSeccion");
		//$hashSeccion = $this->getParam("hashSeccion"); 
		$claveGrupo = $this->getParam("claveGrupo");
		//$hashGrupo = $this->getParam("hashGrupo");
		
		if($request->isXmlHttpRequest()){
			$preguntaDAO = $this->preguntaDAO;
			if(!is_null($claveSeccion)) {
				$seccionDAO = $this->seccionDAO;
				$seccion = $seccionDAO->getSeccionById($claveSeccion);
				
				$this->view->seccion = $seccion;
				//$this->view->preguntas = $preguntaDAO->obtenerPreguntas($seccion->getIdSeccion(), "S");
				$this->view->preguntas = $seccionDAO->obtenerPreguntas($seccion->getIdSeccionEncuesta());
			}else if(!is_null($claveGrupo)) {
				$grupoDAO = $this->grupoDAO;
				$grupo = $grupoDAO->obtenerGrupo($claveGrupo);
				$this->view->grupo = $grupo;
				//$this->view->preguntas = $preguntaDAO->obtenerPreguntas($grupo->getIdGrupo(), "G");
				$this->view->preguntas = $grupoDAO->obtenerPreguntas($grupo->getIdGrupo());
			}
		}
    }

    public function preguntadetAction()
    {
        // action body
        $request = $this->getRequest();
		$clavePregunta = $this->getParam("clavePregunta");
		//$hash = $this->getParam("hash");
		
		$preguntaDAO = new Encuesta_DAO_Pregunta;
		
		if($request->isXmlHttpRequest()){
			$this->view->pregunta = $preguntaDAO->obtenerPregunta($clavePregunta);
		}
    }

    public function registroAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
        $referencia = $this->getParam("referencia");
		
		$tablaRegistro = new Encuesta_Model_DbTable_Registro;
		$select = $tablaRegistro->select()->from($tablaRegistro)->where("referencia = ?", $referencia);
		//print_r($select->__toString());
		$rowRef = $tablaRegistro->fetchRow($select);
		if(is_null($rowRef)){
			$this->view->messageUser = "Usuario con referencia: " .  $referencia ." no esta registrado o es inválido.";
			//print_r($rowRef);
			//print_r("==========");
			return;
		}
		
		$tablaRespuesta = new Encuesta_Model_DbTable_Respuesta;
		$select = $tablaRespuesta->select()->from($tablaRespuesta)->where("idEncuesta = ?", $idEncuesta)->where("idRegistro = ?", $rowRef->idRegistro);
		$rowsRespuestas = $tablaRespuesta->fetchAll($select);
		$numeroRespuestas = count($rowsRespuestas);
		//print_r("<br />");
		//print_r($select->__toString());
		//print_r("<br />");
		//print_r($rowsRespuestas->toArray());
		//print_r("<br />");
		//print_r($numeroRespuestas);
		//print_r("<br />");
		if($numeroRespuestas == 0){
			$this->view->messageSuccess = "Usuario : <strong>" . $rowRef->apellidos .", " . $rowRef->nombres ."</strong> puede contestar esta encuesta";
			return;
		}else{
			$this->view->messageComplete = "Usuario : <strong>" . $rowRef->apellidos .", " . $rowRef->nombres ."</strong> ya ha contestado esta encuesta";
			return;
		}
		
		//print_r("==========");
    }

    public function grupoAction()
    {
        // action body
        $idNivel = $this->getParam("idNivel");
		//$tablaNivel = new Encuesta_Model
		
		
    }


}




