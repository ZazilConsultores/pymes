<?php
/**
 * 
 */
class Encuesta_OpcionController extends Zend_Controller_Action
{
	private $opcionDAO;
	private $categoriaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->opcionDAO = new Encuesta_DAO_Opcion;
		$this->categoriaDAO = new Encuesta_DAO_Categoria;
    }

    public function indexAction()
    {
        // action body
        $idCategoria = $this->getParam("idCategoria");
        $opciones = $this->categoriaDAO->obtenerOpciones($idCategoria);
        $this->view->opciones = $opciones;
    }

    public function adminAction()
    {
        // action body
        $idOpcion = $this->getParam("idOpcion");
		$opcion = $this->opcionDAO->obtenerOpcion($idOpcion);
		$this->view->opcion = $opcion;
		$formulario = new Encuesta_Form_AltaOpcion;
		$formulario->getElement("submit")->setLabel("Actualiza Opcion");
		
		$this->view->formulario = $formulario;
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
		$idCategoria = $this->getParam("idCategoria");
		$categoria = $this->categoriaDAO->obtenerCategoria($idCategoria);
		$formulario = new Encuesta_Form_AltaOpcion();
		$this->view->categoria = $categoria;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())) {
				$datos = $formulario->getValues();
				$datos["idCategoria"] =$idCategoria;
				//print_r($datos);
				$opcion = new Encuesta_Model_Opcion($datos);
				//print_r($opcion->toArray());
				$this->opcionDAO->crearOpcion($idCategoria, $opcion);
				
				//$this->_helper->redirector->gotoSimple("alta", "opcion", "encuesta", array("idCategoria"=>$idCategoria));
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
