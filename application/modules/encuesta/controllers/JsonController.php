<?php

class Encuesta_JsonController extends Zend_Controller_Action
{

    private $encuestaDAO = null;
    private $gradosDAO = null;
    private $gruposDAO = null;
    private $cicloDAO = null;
    private $asignacionDAO = null;
    private $materiaDAO = null;
    private $registroDAO = null;
    private $reporteDAO = null;
    private $nivelDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance();
        $dataIdentity = $auth->getIdentity();
        
        $this->encuestaDAO = new Encuesta_DAO_Encuesta($dataIdentity["adapter"]);
        $this->gradosDAO = new Encuesta_DAO_Grado($dataIdentity["adapter"]);
		$this->gruposDAO = new Encuesta_DAO_Grupos($dataIdentity["adapter"]);
		$this->cicloDAO = new Encuesta_DAO_Ciclo($dataIdentity["adapter"]);
		$this->asignacionDAO = new Encuesta_DAO_AsignacionGrupo($dataIdentity["adapter"]);
        $this->reporteDAO = new Encuesta_DAO_Reporte($dataIdentity["adapter"]);
        
		
		$this->materiaDAO = new Encuesta_DAO_Materia($dataIdentity["adapter"]);
		$this->registroDAO = new Encuesta_DAO_Registro($dataIdentity["adapter"]);
        $this->nivelDAO = new Encuesta_DAO_Nivel($dataIdentity["adapter"]);
		
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
		if(is_null($idCiclo)) $idCiclo = $this->cicloDAO->getCurrentCiclo()->getIdCiclo();
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

    public function impuestoProductosAction()
    {
        // action body
    }

    public function reposdocenteAction()
    {
        // retornamos un array de info con los reportes del docente seleccionado
        $request = $this->getRequest();
        
        $idDocente = $this->getParam("idDocente");
        $idCicloEscolar = $this->getParam("idCicloEscolar");
        
        $reporteDAO = $this->reporteDAO;
        $reportes = $reporteDAO->getReportesDocenteByIdCiclo($idCicloEscolar, $idDocente);
        $objJSON = array();
        
        foreach ($reportes as $reporte) {
            $obj = array();
            $obj["reporte"] = $reporte;
            $encuesta = $this->encuestaDAO->getEncuestaById($reporte["idEncuesta"]);
            $materia = $this->asignacionDAO->obtenerMateriaAsignacion($reporte["idAsignacionGrupo"]);
            $grupo = $this->asignacionDAO->obtenerGrupoAsignacion($reporte["idAsignacionGrupo"]);
            //$grado = $this->materiaDAO->obtenerGradoByIdMateria();
            $grado = $this->gradosDAO->getGradoById($materia->getIdGrado());
            $nivel = $this->nivelDAO->obtenerNivel($grado->getIdNivelEducativo());
            $obj["encuesta"] = $encuesta->toArray();
            $detalle = array();
            $detalle["nivel"] = $nivel->toArray();
            $detalle["grado"] = $grado->toArray();
            $detalle["materia"] = $materia->toArray();
            $detalle["grupo"] = $grupo->toArray();
            $obj["detalle"] = $detalle;
            
            $objJSON[] = $obj;
        }
        
        echo Zend_Json::encode($objJSON);
    }


}













