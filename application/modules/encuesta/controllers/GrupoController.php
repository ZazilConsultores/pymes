<?php

class Encuesta_GrupoController extends Zend_Controller_Action
{
	private $grupoDAO;
	private $seccionDAO;
	private $preguntaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->grupoDAO = new Encuesta_DAO_Grupo;
		$this->seccionDAO = new Encuesta_DAO_Seccion;
		$this->preguntaDAO = new Encuesta_DAO_Pregunta;
    }

    public function indexAction()
    {
        // action body
        $idGrupo = $this->getParam("idGrupo");
		
		if(!is_null($idGrupo)){
			
			$this->view->grupo = $this->grupoDAO->obtenerGrupo($idGrupo);
			$this->view->preguntas = $this->preguntaDAO->obtenerPreguntas($idGrupo, "grupo");
		}else{
			//Redirect
		}
    }

    public function adminAction()
    {
        // action body
        $idGrupo = $this->getParam("idGrupo");
		
		if(!is_null($idGrupo)){
			$grupo = $this->grupoDAO->obtenerGrupo($idGrupo);
			$seccion = $this->seccionDAO->obtenerSeccion($grupo->getIdSeccion());
			
			$this->view->seccion = $seccion;
			$this->view->grupo = $grupo;
			
		}else{
			$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
		}
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Encuesta_Form_AltaGrupo;
		//$idEncuesta = $this->getParam("idEncuesta");
		$idSeccion = $this->getParam("idSeccion");
		
		if($request->isGet()){
			if(!is_null($idSeccion)){
				$seccion = $this->seccionDAO->obtenerSeccion($idSeccion);
				//->obtenerSeccionId($idEncuesta, $idSeccion);
				
				$this->view->formulario = $formulario;
				$this->view->seccion = $seccion;
			}else{
				$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
			}
		}else if($request->isPost()){
			if($formulario->isValid($request->getPost())) {
				$datos = $formulario->getValues();
				//$datos["idSeccion"] = $idSeccion;
				
				$grupo = new Encuesta_Model_Grupo($datos);
				
				$grupo->setIdSeccion($idSeccion);
				$grupo->setFecha(date("Y-m-d H:i:s", time()));
				$grupo->setElementos("0");
				$grupo->setHash($grupo->getHash());
				
				//$grupo->setElementos("0");
				$this->grupoDAO->crearGrupo($grupo);
				//$this->grupoDAO->crearGrupo($grupo);
				$this->_helper->redirector->gotoSimple("index", "seccion", "encuesta", array("idSeccion" => $idSeccion));
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









