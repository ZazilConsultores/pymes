<?php

class Encuesta_ProfesorController extends Zend_Controller_Action
{

    private $encuestaDAO = null;
	private $registroDAO = null;
    private $gruposDAO = null;
	private $asignacionGrupoDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->encuestaDAO = new Encuesta_DAO_Encuesta;
		$this->registroDAO = new Encuesta_DAO_Registro;
		$this->gruposDAO = new Encuesta_DAO_Grupos;
		$this->asignacionGrupoDAO = new Encuesta_DAO_AsignacionGrupo;
    }

    public function indexAction()
    {
        // action body
        $docentes = $this->registroDAO->obtenerDocentes();
		$this->view->docentes = $docentes;
    }

    public function encuestasAction()
    {
        // action body
        $idDocente = $this->getParam("idDocente");
		$docente = $this->registroDAO->obtenerRegistro($idDocente);
		
        $asignaciones = $this->asignacionGrupoDAO->obtenerAsignacionesDocente($idDocente);
		$this->view->docente = $docente;
		$this->view->asignaciones = $asignaciones;
    }


}



