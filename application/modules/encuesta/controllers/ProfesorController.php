<?php

class Encuesta_ProfesorController extends Zend_Controller_Action
{

    private $encuestaDAO = null;
	private $registroDAO = null;
    private $gruposDAO = null;
	private $asignacionGrupoDAO = null;
    private $materiaDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance();
        $dataIdentity = $auth->getIdentity();
        
        $this->encuestaDAO = new Encuesta_DAO_Encuesta($dataIdentity["adapter"]);
		$this->registroDAO = new Encuesta_DAO_Registro($dataIdentity["adapter"]);
		$this->gruposDAO = new Encuesta_DAO_Grupos($dataIdentity["adapter"]);
		$this->asignacionGrupoDAO = new Encuesta_DAO_AsignacionGrupo($dataIdentity["adapter"]);
        $this->materiaDAO = new Encuesta_DAO_Materia($dataIdentity["adapter"]);
    }

    public function indexAction()
    {
        // action body
        $docentes = $this->registroDAO->obtenerDocentes();
		$this->view->docentes = $docentes;
        $this->view->registroDAO = $this->registroDAO;
    }

    public function encuestasAction()
    {
        // action body
        $idDocente = $this->getParam("idDocente");
		$docente = $this->registroDAO->obtenerRegistro($idDocente);
		
        $asignaciones = $this->asignacionGrupoDAO->obtenerAsignacionesDocente($idDocente);
		//print_r($asignaciones);
		$this->view->docente = $docente;
		$this->view->asignaciones = $asignaciones;
        
        $this->view->encuestaDAO = $this->encuestaDAO;
        $this->view->materiaDAO = $this->materiaDAO;
        $this->view->gruposDAO = $this->gruposDAO;
        $this->view->asignacionDAO = $this->asignacionGrupoDAO;
        
        
    }


}



