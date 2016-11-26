<?php

class Sistema_VendedoresController extends Zend_Controller_Action
{

    private $vendedorDAO = null;

    public function init()
    {
        /* Initialize action controller here */
         $this->vendedorDAO = new Sistema_DAO_Vendedores;
    }

    public function indexAction()
    {
        // action body
        
		$formulario = new Sistema_Form_AltaVendedor;
		$this->view->vendedores = $this->vendedorDAO->obtenerVendedores();
     
    }

    public function altaAction()
    {
    	$request = $this->getRequest();
        $formulario = new Sistema_Form_AltaVendedor;
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				//$empresa = new Sistema_Model_Fiscal($datos[0]);
				//print_r($empresa->toArray());
				try{
					$this->vendedorDAO->crearVendedor($datos);
					$this->view->messageSuccess = "Vendedor dado de alta con exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
				
			}
		}
    }

    public function editarAction()
    {
        // action body
    }


}





