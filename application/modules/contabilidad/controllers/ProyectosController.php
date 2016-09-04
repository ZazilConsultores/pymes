<?php

class Contabilidad_ProyectosController extends Zend_Controller_Action
{
	private $proyectoDAO = null;

    public function init()
    {
        $this->proyectoDAO= new Contabilidad_DAO_Proyecto;
    }

    public function indexAction()
    {
        $proyectoDAO = $this->proyectoDAO;
		
		$formulario = new Contabilidad_Form_AltaProyecto;
		$this->view->proyectos = $this->proyectoDAO->obtenerProyectos();
		$this->view->formulario = $formulario;	
			
    }

    public function altaAction()
    {
        $proyectoDAO = new Contabilidad_DAO_Proyecto;
		
        $request = $this->getRequest();
		$idProyecto = $this->getParam("idProyecto");
		$formulario = new Contabilidad_Form_AltaProyecto;
		
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$datos = $formulario->getValue("idCliente");
				$idCliente = $datos;
				print_r("Es Cliente:");
				print_r("<br />");
				print_r("$idCliente");
				$datos = $formulario->getValue("idProveedor");
				$idProveedor = $datos;
				print_r("Es proveedor:");
				print_r("<br />");
				print_r("$idProveedor");
				/*$proyecto = new Contabilidad_Model_Proyecto($datos);
				try{
					$this->proyectoDAO->crearProyecto($proyecto);
					$this->view->messageSuccess = "Se ha agregado el proyecto: <strong>".$proyecto->getDescripcion()."</strong> exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}*/
			}
		}
    }


}



