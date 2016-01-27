<?php

class Sistema_EmpresasController extends Zend_Controller_Action
{
	private $domicilioDAO;
    private $empresaDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Inventario_DAO_Empresa;
		$this->domicilioDAO = new Sistema_DAO_Domicilio;
    }

    public function indexAction()
    {
        // action body
        //$empresas = $this->empresaDAO->ob
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaEmpresa;
		$formulario->getSubForm("subFiscal")->getElement("tipo")->setMultiOptions(array("EM"=>"Empresa"));
		
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$contenedor = $formulario->getValues();
				$datosFiscales = $contenedor[0];
				$datosDomicilio = $contenedor[1];
				$datosTelefono = $contenedor[2];
				$datosEmail = $contenedor[3];
				
			}
		}
		
    }


}



