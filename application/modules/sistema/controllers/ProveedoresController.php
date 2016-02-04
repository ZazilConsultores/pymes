<?php

class Sistema_ProveedoresController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaEmpresa;
		$formulario->getSubForm("0")->getElement("tipo")->setMultiOptions(array("PR"=>"Proveedor"));
		
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$contenedor = $formulario->getValues();
				//Se guarda Domicilio, Telefono, Email y al Final Fiscales
				
				$datosFiscales = $contenedor[0];
				$datosDomicilio = $contenedor[1];
				$datosTelefono = $contenedor[2];
				$datosEmail = $contenedor[3];
				
				$modelFiscales = new Sistema_Model_Fiscal($datosFiscales);
				$fiscales = $this->fiscalDAO->crearFiscales($modelFiscales);
				$modelDomicilio = new Sistema_Model_Domicilio($datosDomicilio);
				$this->domicilioDAO->crearDomicilioFiscal($fiscales->getIdFiscales(), $modelDomicilio);
				$modelTelefono = new Sistema_Model_Telefono($datosTelefono);
				$this->telefonoDAO->crearTelefonoFiscal($fiscales->getIdFiscales(), $modelTelefono);
				$modelEmail = new Sistema_Model_Email($datosEmail);
				$this->emailDAO->crearEmailFiscales($fiscales->getIdFiscales(), $modelEmail);
				
				$datos = array();
				$datos["idFiscales"] = $fiscales->getIdFiscales();
				$datos["esEmpresa"] = "N";
				$datos["esCliente"] = "N";
				$datos["esProveedor"] = "S";
				$modelEmpresa = new Sistema_Model_Empresa($datos);
				$this->empresaDAO->crearEmpresa($modelEmpresa);
				
				$this->_helper->redirector->gotoSimple("proveedores", "empresa", "sistema");
			}
		}
    }


}



