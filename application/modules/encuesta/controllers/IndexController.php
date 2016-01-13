<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_IndexController extends Zend_Controller_Action
{
	private $encuestaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->encuestaDAO = new Encuesta_DAO_Encuesta;
    }

    public function indexAction()
    {
        // action body
        $this->view->encuestas = $this->encuestaDAO->obtenerEncuestas();
    }

    public function adminAction()
    {
        // action body
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
				$valores = $formulario->getValues();
				$datos = array();
				$fechaInicio = new Zend_Date($valores["fechaInicio"], 'yyyy-MM-dd');
				$fechaFin = new Zend_Date($valores["fechaFin"], 'yyyy-MM-dd');
				//$datos["idEncuesta"] = $this->idEncuesta; en la base esta como autoincrement
				$datos["nombre"] = $valores["nombre"];
				$datos["nombreClave"] = $valores["nombreClave"];
				$datos["descripcion"] = $valores["descripcion"];
				$datos["fecha"] = date("Y-m-d", time());
				$datos["fechaInicio"] = $fechaInicio->toString('yyyy-MM-dd');
				$datos["fechaFin"] = $fechaFin->toString('yyyy-MM-dd');
				$datos["estatus"] = $valores["estatus"];
				
				$encuesta = new Encuesta_Model_Encuesta($datos);
				$this->encuestaDAO->crearEncuesta($encuesta);
				$this->_helper->redirector->gotoSimple("index", "encuesta", "default", array("idEncuesta" => $encuesta->getIdEncuesta()));
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


}









