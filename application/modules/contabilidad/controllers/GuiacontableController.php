<?php

class Contabilidad_GuiacontableController extends Zend_Controller_Action
{

    private $guiaContable = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->guiaContable = new Contabilidad_DAO_GuiaContable;
    }

    public function indexAction()
    {
        // action body
			
    }

    public function altaAction()
    {
        // action body
        $formulario = new Contabilidad_Form_GuiaContable;
		$this->view->formulario = $formulario;
    }

    public function editarAction()
    {
        // action body
    }

    public function altamoduloAction()
    {
    	$request = $this->getRequest();
        $formulario = new Contabilidad_Form_GuiaContable;
		$formulario->removeSubForm("0");
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				print_r($datos);
				try{
					$this->modulosDAO->altaModulo($datos);
					$this->view->messageSuccess = "Empresa dada de alta con exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
				
			}
		}
        
    }

    public function altamodulosAction()
    {
    	$request = $this->getRequest();
        $formulario = new Contabilidad_Form_GuiaContable;
		$formulario->removeSubForm("0");
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$modulo = new Contabilidad_Model_Modulos($datos);
				print_r($modulo);
				try{
					//$thos  ->nuevaDivisa($divisa);
					//$mensaje = "Divisa <strong>". $divisa->getDescripcion()."</stong> creado exitosamente";
					//$this->view->messageSuccess = $mensaje;
				}catch(Util_Exception_BussinessException $ex){
					//$this->view->messageFail = $ex->getMessage();
				
				//
				}
			}
    	}

		}
		
}















