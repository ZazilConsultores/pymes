<?php

class Sistema_EstadosController extends Zend_Controller_Action
{
	private $estadosDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->estadosDAO = new Inventario_DAO_Estado;
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
    	$request = $this->getRequest();
		$formulario = new Sistema_Form_AltaEstado;
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				$estado = new Application_Model_Estado($datos);
				//print_r($estado->toArray());
				$this->estadosDAO->crearEstado($estado);
			}
		}
		
		
    }


}



