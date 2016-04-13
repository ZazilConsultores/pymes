<?php
/**
 * 
 */
class Encuesta_OpcionController extends Zend_Controller_Action
{

    private $opcionDAO = null;
	
    private $categoriaDAO = null;

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
				try{
					$this->opcionDAO->crearOpcion($idCategoria, $opcion);
					$this->view->messageSuccess = "Opcion: <strong>".$opcion->getOpcion()."</strong> dada de alta exitosamente en el sistema";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
				
				
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

    public function avalorAction()
    {
        // action body
        $request = $this->getRequest();
        
        $idOpcion = $this->getParam("idOpcion");
		$idCategoria = $this->getParam("idCategoria");
		
		$opcion = $this->opcionDAO->obtenerOpcion($idOpcion);
		$categoria = $this->categoriaDAO->obtenerCategoria($idCategoria);
		
		$this->view->opcion = $opcion;
		$this->view->categoria = $categoria;
		
		$formulario = new Encuesta_Form_AltaValor;
		
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$datos["idOpcion"] = $idOpcion;
				
				try{
					$this->opcionDAO->asignarValorOpcion($idOpcion, $datos);
					$this->view->messageSuccess = "Valor: <strong>".$datos["valor"]." asignado a la Opcion: <strong>".$opcion->getOpcion()."</strong> exitosamente !!";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
			}
		}
    }


}

