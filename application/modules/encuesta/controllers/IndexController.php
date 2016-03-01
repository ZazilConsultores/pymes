<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */

class Encuesta_IndexController extends Zend_Controller_Action
{

    private $encuestaDAO = null;

    private $seccionDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->encuestaDAO = new Encuesta_DAO_Encuesta;
		$this->seccionDAO = new Encuesta_DAO_Seccion;
    }

    public function indexAction()
    {
        // action body
        $this->view->encuestas = $this->encuestaDAO->obtenerEncuestas();
    }

    public function adminAction()
    {
        // action body
        $request = $this->getRequest();
		$idEncuesta = $this->getParam("idEncuesta");
		$encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
		
		$this->view->encuesta = $encuesta;
		//$this->view->secciones = $this->seccionDAO->obtenerSecciones($idEncuesta);
		
		$formulario = new Encuesta_Form_AltaEncuesta;
		$formulario->getElement("nombre")->setValue($encuesta->getNombre());
		$formulario->getElement("nombreClave")->setValue($encuesta->getNombreClave());
		$formulario->getElement("descripcion")->setValue($encuesta->getDescripcion());
		$formulario->getElement("estatus")->setValue($encuesta->getEstatus());
		$formulario->getElement("submit")->setLabel("Actualizar Encuesta");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->formulario = $formulario;
		
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Encuesta_Form_AltaEncuesta;
		
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				
				$encuesta = new Encuesta_Model_Encuesta($datos);
				
				$this->encuestaDAO->crearEncuesta($encuesta);
				$this->_helper->redirector->gotoSimple("index", "index", "encuesta", array("idEncuesta" => $encuesta->getIdEncuesta()));
			}
		}
    }

    public function editaAction()
    {
        // action body
        $request = $this->getRequest();
		$idEncuesta = $this->getParam("idEncuesta");
		$post = $request->getPost();
		$fInicio = new Zend_Date($post["fechaInicio"], 'yyyy-MM-dd hh-mm-ss');
		$fFin = new Zend_Date($post["fechaFin"], 'yyyy-MM-dd hh-mm-ss');
		$post['fechaInicio'] = $fInicio->toString('yyyy-MM-dd hh-mm-ss');
		$post['fechaFin'] = $fFin->toString('yyyy-MM-dd hh-mm-ss');
		unset($post["submit"]);
		
		$this->encuestaDAO->editarEncuesta($idEncuesta, $post);
		$this->_helper->redirector->gotoSimple("admin", "index", "encuesta", array("idEncuesta" => $idEncuesta));
    }

    public function bajaAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$this->encuestaDAO->eliminarEncuesta($idEncuesta);
		$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
    }

    public function seccionesAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
		$secciones = $this->seccionDAO->obtenerSecciones($idEncuesta);
		$this->view->secciones = $secciones;
		$this->view->encuesta = $encuesta;
    }

    public function tiposAction()
    {
        // action body
    }

    public function altaeAction()
    {
        // action body
        $formulario = new Encuesta_Form_AltaEncuestaEvaluativa;
		$this->view->formulario = $formulario;
    }

    public function altasAction()
    {
        // action body
    }


}

