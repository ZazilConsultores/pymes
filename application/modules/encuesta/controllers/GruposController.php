<?php

class Encuesta_GruposController extends Zend_Controller_Action
{

    private $gradoDAO = null;

    private $cicloDAO = null;

    private $gruposDAO = null;

    private $nivelDAO = null;

    private $materiaDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->gruposDAO = new Encuesta_DAO_Grupos;
		$this->cicloDAO = new Encuesta_DAO_Ciclo;
		$this->gradoDAO = new Encuesta_DAO_Grado;
		$this->nivelDAO = new Encuesta_DAO_Nivel;
		$this->materiaDAO = new Encuesta_DAO_Materia;
    }

    public function indexAction()
    {
        // action body
        $idGrupo = $this->getParam("idGrupo");
		$grupo = $this->gruposDAO->obtenerGrupo($idGrupo);
		$ciclo = $this->cicloDAO->obtenerCiclo($grupo->getIdCiclo());
		$grado = $this->gradoDAO->obtenerGrado($grupo->getIdGrado());
		$nivel = $this->nivelDAO->obtenerNivel($grado->getIdNivel());
		$materias = $this->materiaDAO->obtenerMateriasGrupo($ciclo->getIdCiclo(), $grupo->getIdGrado());
		
		$this->view->nivel = $nivel;
		$this->view->grado = $grado;
		$this->view->grupo = $grupo;
		$this->view->materias = $materias;
		
		$profesores = $this->gruposDAO->obtenerDocentes($idGrupo);
		$this->view->profesores = $profesores;
    }

    public function consultaAction()
    {
        // action body
        $request = $this->getRequest();
		$formulario = new Encuesta_Form_ConsultaGrupos;
		
		
        $idGrado = $this->getParam("idGrado");
		$idNivel = $this->getParam("idNivel");
		$ciclo = $this->cicloDAO->obtenerCicloActual();
		$this->view->ciclo = $ciclo;
		
		//Cuando viene la la vista encuesta/grado/admin/idGrado/valor
		//No desplegamos formulario de consulta, traemos tabla con los grupos del grado del ciclo actual
		if(!is_null($idGrado)){
			$grado = $this->gradoDAO->obtenerGrado($idGrado);
			$nivel = $this->nivelDAO->obtenerNivel($grado->getIdNivel());
			
			$grupos = $this->gruposDAO->obtenerGrupos($idGrado, $ciclo->getIdCiclo());
			
			$this->view->nivel = $nivel;
			$this->view->grado = $grado;
			
			$this->view->grupos = $grupos;
			return;
		}elseif(!is_null($idNivel)){
			$nivel = $this->nivelDAO->obtenerNivel($idNivel);
			$grados = $this->gradoDAO->obtenerGrados($idNivel);
			
			if(!is_null($grados)){
				$formulario->getElement("grado")->clearMultiOptions();
				$formulario->getElement("nivel")->clearMultiOptions();
				$formulario->getElement("nivel")->addMultiOption($nivel->getIdNivel(),$nivel->getNivel());
				foreach ($grados as $grado) {
					$formulario->getElement("grado")->addMultiOption($grado->getIdGrado(),$grado->getGrado());
				}
			}
			
			$this->view->nivel = $nivel;
			$this->view->grupos = array();
		}
		
		$this->view->formulario = $formulario;
		//$this->view->ciclo = $this->cicloDAO->obtenerCicloActual();
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				
				$grupos = $this->gruposDAO->obtenerGrupos($datos["grado"], $datos["ciclo"]);
				$this->view->grado = $this->gradoDAO->obtenerGrado($datos["grado"]);
				$this->view->grupos = $grupos;
			}
		}
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
		$idGrado = $this->getParam("idGrado");
		$grado = $this->gradoDAO->obtenerGrado($idGrado);
		
		$formulario = new Encuesta_Form_AltaGrupoE;
		$formulario->getElement("grado")->addMultiOption($grado->getIdGrado(),$grado->getGrado());
        
		$this->view->formulario = $formulario;
		$this->view->grado = $grado;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				$datos["idCiclo"] = $datos["ciclo"];
				$datos["idGrado"] = $datos["grado"];
				$grupo = new Encuesta_Model_Grupoe($datos);
				$grado->setHash($grupo->getHash());
				//print_r("<br/>");
				//print_r($grupo->toArray());
				try{
					$this->gruposDAO->crearGrupo($datos["idGrado"], $datos["idCiclo"], $grupo);
				}catch(Exception $ex){
					print_r($ex->getMessage());
				}
				
				
			}
		}
		
    }

    public function opcionesAction()
    {
        // action body
        $idGrupo = $this->getParam("idGrupo");
		$grupo = $this->gruposDAO->obtenerGrupo($idGrupo);
		$grado = $this->gradoDAO->obtenerGrado($grupo->getIdGrado());
		$nivel = $this->nivelDAO->obtenerNivel($grado->getIdNivel());
		$ciclo = $this->cicloDAO->obtenerCiclo($grupo->getIdCiclo());
        
        $this->view->grupo = $grupo;
        $this->view->grado = $grado;
		$this->view->nivel = $nivel;
        $this->view->ciclo = $ciclo;
        
    }

    public function asociarpAction()
    {
        // action body
        $request = $this->getRequest();
        $idGrupo = $this->getParam("idGrupo");
		$idMateria = $this->getParam("idMateria");
		
		$grupo = $this->gruposDAO->obtenerGrupo($idGrupo);
		$materia = $this->materiaDAO->obtenerMateria($idMateria);
		
		$formulario = new Encuesta_Form_MateriasProfesor;
		$formulario->getElement("idMateria")->clearMultiOptions();
		$formulario->getElement("idMateria")->addMultiOption($materia->getIdMateria(),$materia->getMateria());
		
		$this->view->grupo = $grupo;
		$this->view->formulario = $formulario;
		if($request->getPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				$registro = array();
				$registro["idGrupo"] = $idGrupo;
				$registro["idRegistro"] = $datos["idProfesor"];
				$registro["idMateria"] = $datos["idMateria"];
				$this->gruposDAO->agregarDocenteGrupo($registro);
				//print_r($registro);
			}
		}
		
    }

    public function aencuestaAction()
    {
        // action body
        $request = $this->getRequest();
        $idGrupo = $this->getParam("idGrupo");
		$grupo = $this->gruposDAO->obtenerGrupo($idGrupo);
		$grado = $this->gradoDAO->obtenerGrado($grupo->getIdGrado());
		$ciclo = $this->cicloDAO->obtenerCiclo($grupo->getIdCiclo());
		$nivel = $this->nivelDAO->obtenerNivel($grado->getIdNivel());
		
		
		$formulario = new Encuesta_Form_AsociarEncuesta;
		
		$this->view->grupo = $grupo;
		$this->view->grado = $grado;
		$this->view->ciclo = $ciclo;
		$this->view->nivel = $nivel;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$datos["idGrupo"] = $idGrupo;
				print_r($datos);
			}
		}
    }


}






