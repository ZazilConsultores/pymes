<?php

class Sistema_VendedoresController extends Zend_Controller_Action
{
	private $vendedorDAO = null;

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $this->vendedorDAO = new Sistema_DAO_Vendedores;
    }

    public function altaAction()
    {
    	$request = $this->getRequest();
		//$idVendedor = $this->getParam("idVendedor");
		$formulario = new Sistema_Form_AltaVendedor;
		$this->view->formulario = $formulario;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif ($request->isPost()) {
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//$vendedor = new Sistema_Model_Vendedor($datos[0]) ;
				//print_r($vendedor);
				try{
					$this->vendedorDAO->altaVendedor($datos);
					$this->view->messageSuccess = "Empresa dada de alta con exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
			
		}
		}
        
    }


}



