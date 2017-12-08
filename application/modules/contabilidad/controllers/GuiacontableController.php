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
				try{
					$this->guiaContable->altaCuentaGuia($cta, $subparametro);
				}catch(Exception $ex){
					
				}
			}
		}
    }

    public function editarAction()
    {
        // action body
        $request = $this->getRequest();
		$idGuiaContable = $this->getParam("idGuiaContable");
		$guiaContable = $this->guiaContable->obtieneCuentaGuia($idGuiaContable);
		$formulario = new Contabilidad_Form_GuiaContable;
		$formulario->getSubForm("0")->getElement("cta")->setValue($guiaContable["cta"]);
		$formulario->getSubForm("0")->getElement("sub1")->setValue($guiaContable["sub1"]);
		$formulario->getSubForm("0")->getElement("sub2")->setValue($guiaContable["sub2"]);
		$formulario->getSubForm("0")->getElement("sub3")->setValue($guiaContable["sub3"]);
		$formulario->getSubForm("0")->getElement("sub4")->setValue($guiaContable["sub4"]);
		$formulario->getSubForm("0")->getElement("sub5")->setValue($guiaContable["sub5"]);
		$formulario->getSubForm("0")->getElement("descripcion")->setValue($guiaContable["descripcion"]);
		$formulario->getSubForm("1")->getElement("idModulo")->setValue($guiaContable["idModulo"]);
		$formulario->getSubForm("1")->getElement("idTipoProveedor")->setValue($guiaContable["idTipoProveedor"]);
		$formulario->getSubForm("1")->getElement("cargo")->setValue($guiaContable["cargo"]);
		$formulario->getSubForm("1")->getElement("abono")->setValue($guiaContable["abono"]);
		$formulario->getSubForm("1")->getElement("origen")->setValue($guiaContable["origen"]);
		$formulario->getElement("submit")->setLabel("Actualizar");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->formulario = $formulario;
		$this->view->guiaContable = $guiaContable;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$guiaCont = $formulario->getValues();
				$cta = $guiaCont;
				$subparametro = $guiaCont[1];
				$datos = array($cta);
				
				print_r("<br />");
				print_r($datos);
				
				try{
					$this->guiaContable->actualizarGuiaContable($idGuiaContable, $datos);
					$this->view->messageSuccess = "La cuenta contable se han actualizado correctamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "No se pudo actualizar los datos. Error: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
    }

    public function altamoduloAction()
    {
    	$request = $this->getRequest();
        $formulario = new Contabilidad_Form_GuiaContable;
		$formulario->getSubForm("0")->getElement("descripcion");
		$formulario->getSubForm("0")->removeElement("cta");
		$formulario->getSubForm("0")->removeElement("sub1");
		$formulario->getSubForm("0")->removeElement("sub2");
		$formulario->getSubForm("0")->removeElement("sub3");
		$formulario->getSubForm("0")->removeElement("sub4");
		$formulario->getSubForm("0")->removeElement("sub5");
		
		$formulario->removeSubForm("1");
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				
				$datos = $formulario->getValues();
				$descripcion = $datos[0];
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
		$formulario->removeSubForm("1");
		$formulario->getSubForm("0")->getElement("descripcion");
		$formulario->getSubForm("0")->removeElement("cta");
		$formulario->getSubForm("0")->removeElement("sub1");
		$formulario->getSubForm("0")->removeElement("sub2");
		$formulario->getSubForm("0")->removeElement("sub3");
		$formulario->getSubForm("0")->removeElement("sub4");
		$formulario->getSubForm("0")->removeElement("sub5");
	
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

















