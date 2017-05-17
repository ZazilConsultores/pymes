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
        $guiaContableDAO = $this->guiaContable;
		$this->view->guiaContable = $guiaContableDAO->obtenerCuentasGuia();        
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
		
        $formulario = new Contabilidad_Form_GuiaContable;
		$formulario->getSubForm("1")->removeElement("clave");
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$cta = $datos[0];
				$subparametro = $datos[1];
				print_r($cta);
				print_r($subparametro);
				
				//$guiacontable = new Contabilidad_Model_GuiaContable($cta, $subparametro);
				//print_r($guiacontable);
			}
		}
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
				$descripcion =$datos[1];
				try{
					$this->guiaContable->altaModulo($descripcion);
				}catch(Exception $ex){
				}
				
			}
		}
        
    }

    public function altatipoproveedorAction()
    {
    	$request = $this->getRequest();
        $formulario = new Contabilidad_Form_GuiaContable;
		$formulario->removeSubForm("0");
		$formulario->getSubForm("1")->removeElement("descripcion");
	
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$tipoProveedor = $datos[1];
				print_r($tipoProveedor);
				try{
					$this->guiaContable->altaTipoProvedor($tipoProveedor);
				}catch(Exception $ex){
				}
				
			}
		}
        
    }


}

















