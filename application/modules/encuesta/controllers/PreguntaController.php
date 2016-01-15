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
				
				//print_r($pregunta->toArray());
				//no sabemos si es grupo o pregunta y su id
				//$pregunta->setIdOrigen($idOrigen);
				$p = $preguntaDAO->crearPregunta($idObj, $t, $pregunta);
				if($pregunta->getTipo() == "AB"){
					$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
				}else{
					// La pregunta ya se creo, ahora solo verificamos donde se dio de alta la pregunta, 
					//si fue de una seccion le asociamos opciones, si fue de un grupo regresamos a grupo:admin
					if($p->getOrigen() == "S"){
						$this->_helper->redirector->gotoSimple("opciones", "pregunta", "encuesta", array("idPregunta" => $p->getIdPregunta()));
					}elseif($p->getOrigen() == "G"){
						//antes de regresar a grupo admin debemos asociar las opciones del grupo a la pregunta creada
						$opcionesGrupo = $this->opcionDAO->obtenerOpcionesGrupo($p->getIdOrigen());
						$opciones = array();
						
						foreach ($opcionesGrupo as $opcionGrupo) {
							$opciones[] = $opcionGrupo->getIdOpcion();
						}
						
						$this->opcionDAO->asociarOpcionesPregunta($p->getIdPregunta(), $opciones);
						$this->_helper->redirector->gotoSimple("admin", "grupo", "encuesta", array("idGrupo" => $p->getIdOrigen()));
					}
					
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
