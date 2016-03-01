<?php

class Encuesta_GruposController extends Zend_Controller_Action
{

    private $gradoDAO = null;

    private $cicloDAO = null;

    private $gruposDAO = null;

    private $nivelDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->gruposDAO = new Encuesta_DAO_Grupos;
		$this->cicloDAO = new Encuesta_DAO_Ciclo;
		$this->gradoDAO = new Encuesta_DAO_Grado;
		$this->nivelDAO = new Encuesta_DAO_Nivel;
    }

    public function indexAction()
    {
        // action body
    }

    public function consultaAction()
    {
        // action body
        $idGrado = $this->getParam("idGrado");
		$idCiclo = $this->getParam("idCiclo");
		$idNivel = $this->getParam("idNivel");
		
		$formulario = new Encuesta_Form_ConsultaGrupos;
		$grados = $this->gradoDAO->obtenerGrados($idNivel);
		$nivel = $this->nivelDAO->obtenerNivel($idNivel);
		if(!is_null($grados)){
			$formulario->getElement("grado")->clearMultiOptions();
			$formulario->getElement("nivel")->clearMultiOptions();
			$formulario->getElement("nivel")->addMultiOption($nivel->getIdNivel(),$nivel->getNivel());
			foreach ($grados as $grado) {
				$formulario->getElement("grado")->addMultiOption($grado->getIdGrado(),$grado->getGrado());
			}
		}
        
		
		
		
		//$grupos = $this->gruposDAO->obtenerGrupos($idGrado, $idCiclo);
		
		$this->view->formulario = $formulario;
		$this->view->nivel = $nivel;
		$this->view->grupos = array();
		
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
				
				
				
			}
		}
		
    }


}





