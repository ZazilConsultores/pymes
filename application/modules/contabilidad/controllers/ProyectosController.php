<?php

class Contabilidad_ProyectosController extends Zend_Controller_Action
{

    private $proyectoDAO = null;

    private $fiscalesDAO = null;

    private $notaSalidaDAO = null;

    private $empresaDAO = null;

    public function init()
    {
        $this->proyectoDAO= new Contabilidad_DAO_Proyecto;
		$this->fiscalesDAO= new Sistema_DAO_Fiscales;
		$this->notaSalidaDAO= new Contabilidad_DAO_NotaSalida;
		$this->empresaDAO= new Sistema_DAO_Empresa;
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
		$formulario->removeSubForm("0");
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				print_r ($datos);
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

    public function proyectoclienteAction()
    {
    	$fiscalesDAO  = new Contabilidad_DAO_NotaSalida;
		$proyectoDAO = new Contabilidad_DAO_Proyecto;
		$request = $this->getRequest();
		$clientes = $fiscalesDAO->obtenerClientes();
		$this->view->clientes = $clientes;	
		if($request->isGet()){
			$this->view->clientes = $clientes;		
		}if($request->isPost()){		
			$datos = $request->getPost();
			print_r($datos);
        	//$idCoP = $this->getParam("CoP"); 
        	//print_r($idCoP);
        	//$proyectos = $this->proyectoDAO->obtieneProyectoCliente($idCoP);
			//$this->view->proyectos = $proyectos;
		}
    }

    public function proyectoproveedorAction()
    {
        
    }

    public function proyectoxfechaAction()
    {
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AltaProyecto;
		$formulario->removeElement("numeroFolio");
		$formulario->removeElement("idCliente");
		$formulario->removeElement("descripcion");
		$formulario->removeElement("fechaApertura");
		$formulario->removeElement("fechaCierre");
		$formulario->removeElement("costoInicial");
		$formulario->removeElement("costoFinal");
		$formulario->removeElement("ganancia");
		$formulario->removeElement("submit");
		$formulario->getSubForm("0")->getElement("button")->setAttrib("class", "btn btn-success");
       	$this->view->formulario = $formulario;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}
    }

    public function proyectocafexfechaAction()
    {
        $request = $this->getRequest();
        $formulario = new Contabilidad_Form_AltaProyecto;
        $formulario->removeElement("numeroFolio");
        $formulario->removeElement("idCliente");
        $formulario->removeElement("descripcion");
        $formulario->removeElement("fechaApertura");
        $formulario->removeElement("fechaCierre");
        $formulario->removeElement("costoInicial");
        $formulario->removeElement("costoFinal");
        $formulario->removeElement("ganancia");
        $formulario->removeElement("submit");
        $formulario->getSubForm("0")->getElement("button")->setAttrib("class", "btn btn-success");
        $this->view->formulario = $formulario;
        if($request->isGet()){
            $this->view->formulario = $formulario;
        }
    }


}











