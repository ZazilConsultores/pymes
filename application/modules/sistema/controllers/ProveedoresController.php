<?php

class Sistema_ProveedoresController extends Zend_Controller_Action
{
	private $empresaDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Sistema_DAO_Empresa;
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaEmpresa;
		$formulario->getSubForm("0")->getElement("tipo")->setMultiOptions(array("PR"=>"Proveedor"));
		
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$contenedor = $formulario->getValues();
				
				$datos = $formulario->getValues();
				//print_r($datos);
				try{
					$this->empresaDAO->crearEmpresa($datos);
					$this->view->messageSuccess = "Proveedor creado exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = "Error al registrar el proveedor: <strong>". $ex->getMessage()."</strong>";
				}
				
			}
		}
    }

    public function proveedorAction()
    {
        // action body
        $idEmpresa = $this->getParam("idEmpresa");
		$empresaDAO = $this->empresaDAO;
		
		$empresa = $empresaDAO->obtenerEmpresa($idEmpresa);
		$this->view->empresa = $empresa;
    }


}





