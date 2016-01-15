<?php

class Encuesta_PreguntaController extends Zend_Controller_Action
{

    private $preguntaDAO = null;
    private $seccionDAO = null;
    private $grupoDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->seccionDAO = new Encuesta_DAO_Seccion;
		$this->grupoDAO = new Encuesta_DAO_Grupo;
        $this->preguntaDAO = new Encuesta_DAO_Pregunta;
    }

    public function indexAction()
    {
        // action body
        $idPregunta = $this->getParam("idPregunta");
		$pregunta = $this->preguntaDAO->obtenerPregunta($idPregunta);
		$formulario = new Encuesta_Form_AltaPregunta;
		$formulario->getElement("nombre")->setValue($pregunta->getNombre());
		$formulario->getElement("submit")->setLabel("Editar Pregunta");
		$opciones = null;
		if($pregunta->getTipo() != "AB") {
			//$opciones = $this->tablaOpGrupo->
		}
		$this->view->pregunta = $pregunta;
		$this->view->formulario = $formulario;
    }

    public function adminAction()
    {
        // action body
        $idPregunta = $this->getParam("idPregunta");
		$pregunta = $this->preguntaDAO->obtenerPregunta($idPregunta);
		$t = Zend_Registry::get("tipo");
		
		$formulario = new Encuesta_Form_AltaPregunta();
		$formulario->getElement("tipo")->setMultiOptions(array($pregunta->getTipo() => $t[$pregunta->getTipo()] ));
		$formulario->getElement("submit")->setLabel("Actualizar Pregunta");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		$this->view->formulario = $formulario;
		$this->view->pregunta = $pregunta;
		/*
        $idSeccion = $this->getParam("idSeccion");
		$idGrupo = $this->getParam("idGrupo");
		$preguntaDAO = $this->preguntaDAO;
		//Enviamos las preguntas de la seccion o grupo segun sea el caso
		if(!is_null($idSeccion)){
			
			$seccionDAO = $this->seccionDAO;
			$seccion = $seccionDAO->obtenerSeccion($idSeccion);
			$preguntas = $preguntaDAO->obtenerPreguntas($idSeccion, "S");
			$this->view->seccion = $seccion;
			$this->view->preguntas = $preguntas;
			
		}elseif(!is_null($idGrupo)){
			
			$grupoDAO = $this->grupoDAO;
			$grupo = $grupoDAO->obtenerGrupo($idGrupo);
			$preguntas = $preguntaDAO->obtenerPreguntas($idGrupo, "G");
			
			$this->view->grupo = $grupo;
			$this->view->preguntas = $preguntas;
		}
		*/
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
		$grupoDAO = $this->grupoDAO;
		$seccionDAO = $this->seccionDAO;
		$preguntaDAO = $this->preguntaDAO;
		
        $formulario = new Encuesta_Form_AltaPregunta;
		$idGrupo = $this->getParam("idGrupo");
		$idSeccion = $this->getParam("idSeccion");
		
		$idObj = (is_null($idGrupo)) ? $idSeccion : $idGrupo;
		$obj = (is_null($idGrupo)) ? $seccionDAO->obtenerSeccion($idObj) : $grupoDAO->obtenerGrupo($idObj);
		$t = (is_null($idGrupo)) ? "S" : "G";
		$mensaje = (is_null($idGrupo)) ? "la Seccion: " . $obj->getNombre() : "el Grupo:" . $obj->getNombre();
		
		if($request->isGet()){
			//encontramos el tipo para el grupo
			$grupo = null;
			$tipoPreguntas = null;
			$tipo = Zend_Registry::get("tipo");
			if (!is_null($idGrupo)) {
				$grupo = $grupoDAO->obtenerGrupo($idGrupo);
				$tipoPreguntas = $grupo->getTipo();
				$formulario->getElement("tipo")->clearMultiOptions();
				$formulario->getElement("tipo")->addMultiOption($tipoPreguntas, $tipo[$tipoPreguntas]);
			}
			
			$this->view->formulario = $formulario;
			$this->view->mensaje = $mensaje;
			
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())) {
				$datos = $formulario->getValues();
				$datos["idOrigen"] = $idObj;
				$datos["origen"] = $t;
				
				$pregunta = new Encuesta_Model_Pregunta($datos);
				$pregunta->setFecha(date("Y-m-d H:i:s", time()));
				$pregunta->setHash($pregunta->getHash());
				
				print_r($pregunta->toArray());
				//no sabemos si es grupo o pregunta y su id
				//$pregunta->setIdOrigen($idOrigen);
				$p = $preguntaDAO->crearPregunta($idObj, $t, $pregunta);
				if($pregunta->getTipo() == "AB"){
					$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
				}else{
					$this->_helper->redirector->gotoSimple("opciones", "pregunta", "encuesta", array("idPregunta" => $p->getIdPregunta()));
				}
				
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
				//$this->view->opciones =$formulario->getValues();
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
				
				$this->opc;
				
				
				
				$this->view->opciones =$formulario->getValues();
				//$datos = $formulario->getValues();
				
				
			}
		}
    }


}
