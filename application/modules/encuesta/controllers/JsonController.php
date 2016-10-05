<?php

class Encuesta_JsonController extends Zend_Controller_Action
{

    private $encuestaDAO = null;

    private $gradosDAO = null;

    private $gruposDAO = null;

    private $cicloDAO = null;
	
	private $asignacionDAO = null;
	private $materiaDAO;
	private $registroDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->encuestaDAO = new Encuesta_DAO_Encuesta;
        $this->gradosDAO = new Encuesta_DAO_Grado;
		$this->gruposDAO = new Encuesta_DAO_Grupos;
		$this->cicloDAO = new Encuesta_DAO_Ciclo;
		$this->asignacionDAO = new Encuesta_DAO_AsignacionGrupo;
		
		$this->materiaDAO = new Encuesta_DAO_Materia;
		$this->registroDAO = new Encuesta_DAO_Registro;
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
        // action body
    }

    /**
     * Hace una consulta de grados educativos 
     * en base a un idNivelEducativo proporcionado
     */
    public function gradosAction()
    {
        // action body
        $idNivel = $this->getParam("idNivel");
		$grados = $this->gradosDAO->getGradosByIdNivel($idNivel);
		
		$arrayGrados = array();
		
		foreach ($grados as $grado) {
			$arrayGrados[] = array("idGradoEducativo"=>$grado->getIdGradoEducativo(), "gradoEducativo"=>$grado->getGradoEducativo());
		}
		
		echo Zend_Json::encode($arrayGrados);
    }

    public function gruposAction()
    {
        // action body
        $idCiclo = $this->getParam("idCiclo");
		$idGrado = $this->getParam("idGrado");
		if(is_null($idCiclo)) $idCiclo = $this->cicloDAO->obtenerCicloActual()->getIdCiclo();
		$grupos = $this->gruposDAO->obtenerGrupos($idGrado, $idCiclo);
		$arrayGrupos = array();
		
		foreach ($grupos as $grupo) {
			$arrayGrupos[] = array("idGrupo"=>$grupo->getIdGrupo(),"grupo"=>$grupo->getGrupo());
		}
		
		echo Zend_Json::encode($arrayGrupos);
    }

    public function encrealizadasAction()
    {
        // action body
        $idGrupoEscolar = $this->getParam("idGrupo");
        $encuestaDAO = $this->encuestaDAO;
		$asignacionDAO = $this->asignacionDAO;
		//Materia y Docente
		$materiaDAO = $this->materiaDAO;
		$registroDAO = $this->registroDAO;
		
		$encuestasRealizadas = $encuestaDAO->getEncuestasRealizadasByIdGrupoEscolar($idGrupoEscolar);
		// array de encuestas realizadas extendido.
		$arrayERExt = array();
		foreach ($encuestasRealizadas as $er) {
			$asignacionGrupo = $asignacionDAO->getAsignacionById($er["idAsignacionGrupo"]);
			$materia = $materiaDAO->obtenerMateria($asignacionGrupo["idMateriaEscolar"]);
			$docente = $registroDAO->obtenerRegistro($asignacionGrupo["idRegistro"]);
			$encuesta = $encuestaDAO->getEncuestaById($er["idEncuesta"]);
			
			$contenedor = array();
			$contenedor["asignacion"] = $er;
			$contenedor["encuesta"] = $encuesta->toArray();
			$contenedor["docente"] = $docente->toArray();
			$contenedor["materia"] = $materia->toArray();
			
			$arrayERExt[] = $contenedor;
		}
		
		echo Zend_Json::encode($arrayERExt);
    }


}









