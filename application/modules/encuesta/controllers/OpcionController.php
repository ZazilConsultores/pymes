<?php

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
		$formulario = new Application_Form_AltaOpcion();
		if($request->isGet()){
			$this->view->formulario = $formulario; 
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$tablaOpcion = new Application_Model_DbTable_Opcion;
				$datos = $formulario->getValues();
				$datos["idOpcion"] = hash("adler32", $datos["nombre"]. $datos["idCategoria"]);
				$select = $tablaOpcion->select()->from($tablaOpcion)->where("idCategoria = ?", $datos["idCategoria"]);
				$elementos = count($tablaOpcion->fetchAll($select));
				$datos["orden"] = $elementos;
				$tablaOpcion->insert($datos);
				$this->_helper->redirector->gotoSimple("alta", "opcion", "default");
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









