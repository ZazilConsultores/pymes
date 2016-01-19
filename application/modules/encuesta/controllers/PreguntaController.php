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
        $idSeccion = $this->getParam("idSeccion");
        $idGrupo = $this->getParam("idGrupo");
		$request = $this->getRequest();
		$idEncuesta = null;
		$formulario = new Encuesta_Form_AltaPregunta();
		$t = Zend_Registry::get("tipo");
		$mensaje = null;
		//=========================================================================================
		if(!is_null($idGrupo)){
			$grupoDAO = $this->grupoDAO;
			$grupo = $grupoDAO->obtenerGrupo($idGrupo);
			$tipo = $grupo->getTipo();
			
			$formulario->getElement("tipo")->setMultiOptions(array($tipo=>$t[$tipo]));
			$mensaje = "Grupo: " . $grupo->getNombre();
			
			$seccion = $this->seccionDAO->obtenerSeccion($grupo->getIdSeccion());
			$idEncuesta = $seccion->getIdEncuesta();
		}else{
			$seccionDAO = $this->seccionDAO;
			$seccion = $seccionDAO->obtenerSeccion($idSeccion);
			
			$mensaje = "Seccion: " . $seccion->getNombre();
			$idEncuesta = $seccion->getIdEncuesta();
		}
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
			$this->view->mensaje = $mensaje;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())) {
				$datos = $formulario->getValues();
				$datos["origen"] = (is_null($idGrupo)) ? "S" : "G" ;
				$datos["idOrigen"] = (is_null($idGrupo)) ? $idSeccion : $idGrupo ;
				$datos["idEncuesta"] = $idEncuesta;
				$pregunta = new Encuesta_Model_Pregunta($datos);
				
				$pregunta = $this->preguntaDAO->crearPregunta($datos["idOrigen"], $datos["origen"], $pregunta);
				if($pregunta->getTipo() != "AB"){
					//Navegamos al alta de opciones de seleccion
					$this->_helper->redirector->gotoSimple("opciones", "pregunta", "encuesta", array("idPregunta" => $pregunta->getIdPregunta()));
				}else{
					if($datos["origen"] == "S"){
						$this->_helper->redirector->gotoSimple("index", "seccion", "encuesta", array("idSeccion" => $pregunta->getIdOrigen()));
					}elseif($datos["origen"] == "G"){
						
						$this->_helper->redirector->gotoSimple("index", "grupo", "encuesta", array("idGrupo" => $pregunta->getIdOrigen()));
					}
				}
				
			}
		}
    }

    public function editaAction()
    {
        // action body
        $request = $this->getRequest();
        $idPregunta = $this->getParam("idPregunta");
		$preguntaDAO = $this->preguntaDAO;
		$pregunta = $preguntaDAO->obtenerPregunta($idPregunta);
        $formulario = new Encuesta_Form_AltaPregunta;
		
		if($pregunta->getOrigen() == "G"){
			//La pregunta viene de un grupo hay que traer el tipo de preguntas del grupo
			$grupoDAO = $this->grupoDAO;
			$grupo = $grupoDAO->obtenerGrupo($pregunta->getIdOrigen());
			$t = Zend_Registry::get("tipo");
			
			$formulario->getElement("tipo")->setMultiOptions(array($grupo->getTipo()=>$t[$grupo->getTipo()]));
		}
		
		$formulario->getElement("submit")->setLabel("Actualizar Pregunta");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//Actualiza
				$preguntaDAO->editarPregunta($idPregunta, $datos);
				$this->_helper->redirector->gotoSimple("admin", "pregunta", "encuesta", array("idPregunta"=>$idPregunta));
			}
		}
		
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
				if($pregunta->getOrigen() == "S"){
					$this->_helper->redirector->gotoSimple("index", "seccion", "encuesta", array("idSeccion"=>$pregunta->getIdOrigen()));
				}elseif($pregunta->getOrigen() == "G"){
					$this->_helper->redirector->gotoSimple("index", "grupo", "encuesta", array("idGrupo"=>$pregunta->getIdOrigen()));
				}
				//$this->_helper->redirector->gotoSimple("admin", "pregunta", "encuesta", array("idPregunta"=>$idPregunta));
			}
		}
    }


}
