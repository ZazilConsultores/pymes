<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_IndexController extends Zend_Controller_Action
{
	private $encuestaDAO;
	private $seccionDAO;

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
		$formulario->getElement("fechaInicio")->setValue($encuesta->getFechaInicio());
		$formulario->getElement("fechaFin")->setValue($encuesta->getFechaFin());
		$formulario->getElement("estatus")->setValue($encuesta->getEstatus());
		$formulario->getElement("submit")->setLabel("Actualizar Encuesta");
		
		$this->view->formulario = $formulario;
		
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Encuesta_Form_AltaEncuesta;
		//$formulario->setAction($this->view->url(array("controller" => "encuesta"), null, true));
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}else if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$datos["fecha"] = date("Y-m-d H:i:s", time());
				$fechaInicio = new Zend_Date($datos["fechaInicio"], 'yyyy-MM-dd');
				$fechaFin = new Zend_Date($datos["fechaFin"], 'yyyy-MM-dd');
				$datos["fechaInicio"] = $fechaInicio->toString('yyyy-MM-dd');
				$datos["fechaFin"] = $fechaFin->toString('yyyy-MM-dd');
				$encuesta = new Encuesta_Model_Encuesta($datos);
				$encuesta->setHash($encuesta->getHash());
				
				$encuesta = new Encuesta_Model_Encuesta($datos);
				$encuesta->setHash($encuesta->getHash());
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
		
		$encuestaModel = new Encuesta_Model_Encuesta($post);
		//print_r($estadoModel->toArray());
		$this->encuestaDAO->editarEncuesta($idEncuesta, $encuestaModel);
		$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
    }

    public function bajaAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$this->encuestaDAO->eliminarEncuesta($idEncuesta);
		$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
    }


}









