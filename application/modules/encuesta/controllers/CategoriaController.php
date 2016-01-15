<?php

class Encuesta_CategoriaController extends Zend_Controller_Action
{

    private $categoriaDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->categoriaDAO = new Encuesta_DAO_Categoria;
    }

    public function indexAction()
    {
        // action body
        $this->view->categorias = $this->categoriaDAO->obtenerCategorias();
    }

    public function adminAction()
    {
        // action body
        $idCategoria = $this->getParam("idCategoria");
		$categoria = $this->categoriaDAO->obtenerCategoria($idCategoria);
		$opciones = $this->categoriaDAO->obtenerOpciones($idCategoria);
		
		$formulario = new Encuesta_Form_AltaCategoria();
		
		$formulario->getElement("categoria")->setValue($categoria->getCategoria());
		$formulario->getElement("descripcion")->setValue($categoria->getDescripcion());
		$formulario->getElement("submit")->setLabel("Actualizar Categoria");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->categoria = $categoria;
		$this->view->opciones = $opciones;
		$this->view->formulario = $formulario;
		
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
		$formulario = new Encuesta_Form_AltaCategoria;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$tablaCategoria = new Encuesta_Model_DbTable_Categoria;
				$datos = $formulario->getValues();
				$datos["fecha"] = date("Y-m-d H:i:s", time());
				
				$categoria = new Encuesta_Model_Categoria($datos);
				$categoria->setHash($categoria->getHash());
				$this->categoriaDAO->crearCategoria($categoria);
				//$tablaCategoria->insert($datos);
				$this->_helper->redirector->gotoSimple("index", "categoria", "encuesta");
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
        $idCategoria = $this->getParam("idCategoria");
		$categoria = $this->categoriaDAO->obtenerCategoria($idCategoria);
		$opciones = $this->categoriaDAO->obtenerOpciones($idCategoria);
		
		$this->view->categoria = $categoria;
		$this->view->opciones = $opciones;
		//$this->view->formulario = $formulario;
    }


}











