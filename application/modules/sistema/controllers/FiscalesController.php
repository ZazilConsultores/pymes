<?php

class Sistema_FiscalesController extends Zend_Controller_Action
{
	
	private $fiscalesDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->fiscalesDAO = new Sistema_DAO_Fiscales;
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
        $formulario = new Sistema_Form_AltaFiscales;
		$this->view->formulario = $formulario;
    }

    public function editaAction()
    {
        // action body
        $request = $this->getRequest();
		$idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		$fiscalesCuentaContable = $this->fiscalesDAO->obtenerFiscalesCuentaContable($idFiscales);
		$formulario = new Sistema_Form_AltaFiscales;
		$formulario->getElement("rfc")->setValue($fiscales->getRfc());
		$formulario->getElement("razonSocial")->setValue($fiscales->getRazonSocial());
		$formulario->getElement("rfc")->setValue($fiscales->getRfc());
		$formulario->getElement("tipoProveedor")->setValue($fiscalesCuentaContable["idTipoProveedor"]);
		$formulario->getElement("cuenta")->setValue($fiscalesCuentaContable["cuenta"]);
		$formulario->getElement("submit")->setLabel("Actualizar	Fiscales");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$rfc = $formulario->getValue('rfc');
				$razonSocial = $formulario->getValue('razonSocial');
				$tipoProveedor = $formulario->getValue('tipoProveedor');
				$cuenta = $formulario->getValue('cuenta');
				
				try{
					//$this->fiscalesDAO->actualizarFiscales($idFiscales, $datos);
					//$this->fiscalesDAO->actualizarFiscalesCuentaContable($idFiscales, $rfc, $razonSocial, $cuenta);
					$this->fiscalesDAO->actualizarFiscalesCuentaContable($idFiscales, $rfc, $razonSocial,$tipoProveedor, $cuenta);
					$this->view->messageSuccess = "Los datos fiscales se han actualizado correctamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "No se pudo actualizar los datos fiscales. Error: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
		
    }


}





