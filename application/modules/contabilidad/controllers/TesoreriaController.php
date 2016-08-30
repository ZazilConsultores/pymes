<?php

class Contabilidad_TesoreriaController extends Zend_Controller_Action
{
	private $fondeoDAO = null;
	private $subparametroDAO =null;

    public function init()
    {
        /* Initialize action controller here */
         $this->fondeoDAO = new Contabilidad_DAO_Fondeo;
		 
    }

    public function indexAction()
    {
        // action body
    }

    public function fondeoAction()
    {
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarFondeo;
		$this->view->$formulario = $formulario;
		if ($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				print_r($datos);
				try{
					$fondeoDAO = new Contabilidad_DAO_Fondeo;
					$fondeoDAO->guardarFondeo($datos);
					//print_r("$fondeoDAO");
				}catch(exception $ex){
					$this->view->messageFail= "Error";
				}
			//}
			}else{
				print_r("formulario no valido <br />");
			}				
			//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
		}	
		
    }

    public function inversionesAction()
    {
        $formulario = new Contabilidad_Form_AgregarInversiones;
		$this->view->formulario = $formulario;
    }

    public function nominaAction()
    {
    	$formulario = new Contabilidad_Form_AgregarNomina;
		$this->view->formulario = $formulario;
    }

    public function impuestosAction()
    {
        // action body
    }


}









