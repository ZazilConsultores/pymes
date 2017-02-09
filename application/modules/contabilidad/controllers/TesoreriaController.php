<?php

class Contabilidad_TesoreriaController extends Zend_Controller_Action
{
	private $tesoreriaDAO = null;
	
    public function init()
    {
        $this->tesoreriaDAO = new Contabilidad_DAO_Tesoreria; 
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
				$empresa = $datos[0];
				$fondeo = $datos[1];
				print_r($fondeo);
		
				try{
					$this->tesoreriaDAO->sumaBanco($fondeo);
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
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarNomina;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$empresa = $datos[0];
				$nomina = $datos[1];
				try{
					$this->tesoreriaDAO->guardaNomina($empresa, $nomina);
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
			}else{
				print_r("El formulario no es valido");
			}
		}
    }

    public function impuestosAction()
    {
    	
    }


}









