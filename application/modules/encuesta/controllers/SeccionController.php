<?php

class Encuesta_SeccionController extends Zend_Controller_Action
{
	private $encuestaDAO;
    private $seccionDAO;
	private $grupoDAO;
	private $preguntaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->encuestaDAO = new Encuesta_DAO_Encuesta;
		$this->seccionDAO = new Encuesta_DAO_Seccion;
		$this->grupoDAO = new Encuesta_DAO_Grupo;
		$this->preguntaDAO = new Encuesta_DAO_Pregunta;
    }

    public function indexAction()
    {
        // action body
        $idSeccion = $this->getParam("idSeccion");
		if(! is_null($idSeccion)) {
			$seccion = $this->seccionDAO->getSeccionById($idSeccion);
			$encuesta = $this->encuestaDAO->getEncuestaById($seccion->getIdEncuesta());
			$this->view->seccion = $seccion;
			$this->view->encuesta = $encuesta;
			$grupos = $this->seccionDAO->getGruposByIdSeccion($idSeccion);
			$preguntas = $this->seccionDAO->getPreguntasByIdSeccion($idSeccion);
			
			$elementos = array();
			
			foreach ($grupos as $grupo) {
				$elementos[$grupo->getOrden()] = $grupo;
			}
			
			foreach ($preguntas as $pregunta) {
				$elementos[$pregunta->getOrden()] = $pregunta;
			}
			
			ksort($elementos);
			
			$this->view->elementos = $elementos;
		}else{
			//Redirect
			$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
		}
    }

    public function adminAction()
    {
        // action body
        $idSeccion = $this->getParam("idSeccion");
		if(! is_null($idSeccion)) {
			$seccionDAO = $this->seccionDAO;
			$seccion = $seccionDAO->getSeccionById($idSeccion);
			$grupos = $seccionDAO->getGruposByIdSeccion($idSeccion);
			$preguntas = $seccionDAO->getPreguntasByIdSeccion($idSeccion);
			//$seccion = $this->seccionDAO->obtenerSeccion($idSeccion);
			$this->view->seccion = $seccion;
			$this->view->grupos = $grupos;
			$this->view->preguntas = $preguntas;
			
			$formulario = new Encuesta_Form_AltaSeccion;
			$formulario->getElement("nombre")->setValue($seccion->getNombre());
			$formulario->getElement("submit")->setLabel("Actualizar seccion");
			$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
			
			$this->view->formulario = $formulario;
		}else{
			//Redirect
			$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
		}
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
		$idEncuesta = $this->getParam("idEncuesta");
		$formulario = new Encuesta_Form_AltaSeccion();
		if($request->isGet()){
			if(!is_null($idEncuesta)){
				$encuesta = $this->encuestaDAO->getEncuestaById($idEncuesta);
				
				$this->view->encuesta = $encuesta;
				$this->view->formulario = $formulario;
			}else{
				$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
			}
		}else if($request->isPost()) {
			if($formulario->isValid($request->getPost())) {
				
				$datos = $formulario->getValues();
				
				$seccion = new Encuesta_Models_Seccion($datos);
				$seccion->setIdEncuesta($idEncuesta);
				//$seccion->setFecha(date("Y-m-d H:i:s", time()));
				try{
					$this->seccionDAO->addSeccionToEncuesta($seccion);
				}catch(Exception $ex){
					print_r($ex->getMessage());
				}
				$this->_helper->redirector->gotoSimple("index", "index", "encuesta", array("idEncuesta" => $idEncuesta));
			}
		}
    }

    public function editaAction()
    {
        // action body
        $request = $this->getRequest();
		$idSeccion = $this->getParam("idSeccion");
		$post = $request->getPost();
		unset($post["submit"]);
		//print_r($post);
		//$seccion = new Encuesta_Model_Seccion($post);
		//print_r($estadoModel->toArray());
		//$this->encuestaDAO->editarEncuesta($idEncuesta, $encuestaModel);
		$this->seccionDAO->editarSeccion($idSeccion, $post);
		$this->_helper->redirector->gotoSimple("admin", "seccion", "encuesta", array("idSeccion"=>$idSeccion));
    }

    public function bajaAction()
    {
        // action body
    }


}









