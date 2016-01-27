<?php

class Sistema_EmpresaController extends Zend_Controller_Action
{
	private $empresaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Inventario_DAO_Empresa;
    }

    public function indexAction()
    {
        // action body
        //$empresas = $this->empresaDAO->o
        
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaEmpresa;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//---
				$empresa = new Sistema_Model_Fiscal($datos);
				$this->empresasDAO->crearEmpresa($empresa);
				print_r($datos);
			}
		}
    }
}
