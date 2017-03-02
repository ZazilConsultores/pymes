<?php

class Contabilidad_ProyectosController extends Zend_Controller_Action
{
	private $proyectoDAO = null;
	private $fiscalesDAO = null;

    public function init()
    {
        $this->proyectoDAO= new Contabilidad_DAO_Proyecto;
		$this->fiscalesDAO= new Sistema_DAO_Fiscales;
    }

    public function indexAction()
    {
       $this->view->proyectos = $this->proyectoDAO->obtenerProyectos();
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
				
				$proyecto = new Contabilidad_Model_Proyecto($datos);
				//print_r($proyecto);
				try{
					$this->proyectoDAO->crearProyecto($proyecto);
					print_r("<br />");
					//print_r($proyecto);
					$this->view->messageSuccess = "Se ha agregado el proyecto: <strong>".$proyecto->getDescripcion()."</strong> exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
    }


}



