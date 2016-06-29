<?php

class Sistema_ClientesController extends Zend_Controller_Action
{
	private $fiscalesDAO;
	private $empresaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->fiscalesDAO = new Sistema_DAO_Fiscales;
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
		$formulario->getSubForm("0")->getElement("tipo")->setMultiOptions(array("CL"=>"Cliente"));
		
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$contenedor = $formulario->getValues();
				
				try{
					$this->empresaDAO->crearEmpresa($contenedor);
					$this->view->messageSuccess = "Cliente <strong>".$datos["0"]["razonSocial"]."</strong> creado exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = "Error al crear el cliente: <strong>".$ex->getMessage()."</strong>";
				}
				//$this->_helper->redirector->gotoSimple("clientes", "empresa", "sistema");
			}
		}
    }

    public function clienteAction()
    {
        // action body
        $idEmpresa = $this->getParam("idEmpresa");
		$empresaDAO = $this->empresaDAO;
		
		$empresa = $empresaDAO->obtenerEmpresa($idEmpresa);
		$this->view->empresa = $empresa;
		//print_r($empresa);
		
    }


}





