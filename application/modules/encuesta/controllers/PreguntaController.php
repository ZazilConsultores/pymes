<?php

class Encuesta_PreguntaController extends Zend_Controller_Action
{

    private $preguntaDAO;
    private $seccionDAO;
    private $grupoDAO;
	private $opcionDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->seccionDAO = new Encuesta_DAO_Seccion;
		$this->grupoDAO = new Encuesta_DAO_Grupo;
        $this->preguntaDAO = new Encuesta_DAO_Pregunta;
		$this->opcionDAO = new Encuesta_DAO_Opcion;
    }

    public function indexAction()
    {
        // action body
        $this->_helper->redirector->gotoSimple("index", "index", "encuesta");
    }

    public function adminAction()
    {
        // action body
        $idPregunta = $this->getParam("idPregunta");
		$t = Zend_Registry::get("tipo");
		$pregunta = $this->preguntaDAO->obtenerPregunta($idPregunta);
		$formulario = new Encuesta_Form_AltaPregunta;
		$formulario->getElement("pregunta")->setValue($pregunta->getPregunta());
		$formulario->getElement("submit")->setLabel("Actualizar Pregunta");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$opciones = null;
		if($pregunta->getTipo() != "AB") {
			$formulario->getElement("tipo")->setMultiOptions(array($pregunta->getTipo() => $t[$pregunta->getTipo()]));
			$opciones = $this->opcionDAO->obtenerOpcionesPregunta($pregunta->getIdPregunta());
			$this->view->opciones = $opciones;
		}
		
		$this->view->pregunta = $pregunta;
		$this->view->formulario = $formulario;
    }

    public function altaAction()
    {
        // action body
        $idSeccion = $this->getParam("idPregunta");
        $idGrupo = $this->getParam("idGrupo");
		$request = $this->getRequest();
		$formulario = new Encuesta_Form_AltaPregunta();
		$t = Zend_Registry::get("tipo");
		//=========================================================================================
		if(!is_null($idGrupo)){
			$grupoDAO = $this->grupoDAO;
			$grupo = $grupoDAO->obtenerGrupo($idGrupo);
			$tipo = $grupo->getTipo();
			
			$formulario->getElement("tipo")->setMultiOptions(array($tipo=>$t[$tipo]));
		}
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			
		}
    }

    public function editaAction()
    {
        // action body
    }

    public function bajaAction()
    {
        // action body
        $idPregunta = $this->getParam("idPregunta");
		$pregunta = $this->preguntaDAO->obtenerPregunta($idPregunta);
		$this->preguntaDAO->eliminarPregunta($idPregunta);
		$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
    }

    public function opcionesAction()
    {
        // action body
        $request = $this->getRequest();
        $idPregunta = $this->getParam("idPregunta");
		
		$pregunta = $this->preguntaDAO->obtenerPregunta($idPregunta);		
        $formulario = new Encuesta_Form_AltaSeleccion;
		$this->view->pregunta = $pregunta;
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
			
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				
				$categorias = $formulario->getValues();
				$opciones = array();
				
				foreach ($categorias as $categoria) {
					foreach ($categoria as $elemento) {
						if(!is_null($elemento)){
							foreach ($elemento as $indice => $id) {
								$opciones[] = $id;
							}
						}
					}
				}
				
				$this->opcionDAO->asociarOpcionesPregunta($idPregunta, $opciones);
				$this->_helper->redirector->gotoSimple("admin", "pregunta", "encuesta", array("idPregunta"=>$idPregunta));
			}
		}
    }


}
