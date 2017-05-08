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

















