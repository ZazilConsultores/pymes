<?php

class Sistema_ClientesController extends Zend_Controller_Action
{
	private $fiscalesDAO;
	private $empresaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->fiscalesDAO = new Sistema_DAO_Fiscales;
		$this->empresaDAO = new Sistema_DAO_Empresa;
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
		$formulario->getSubForm("0")->getElement("tipo")->setMultiOptions(array("CL"=>"Cliente"));
		$formulario->getSubForm("0")->removeElement("tipoProveedor");
		$formulario->getSubForm("0")->removeElement("regFiscal");
		$formulario->getSubForm("0")->getElement("cuenta")->setAttrib("class", "form-control");
		$formulario->getElement("submit")->setLabel("Actualizar	Fiscales");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$contenedor = $formulario->getValues();
				//print_r($contenedor);
				try{
					$this->empresaDAO->crearEmpresa($contenedor);
					$this->view->messageSuccess = "Cliente <strong>".$contenedor["0"]["razonSocial"]."</strong> creado exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = "Error al crear el cliente: <strong>".$ex->getMessage()."</strong>";
				}
				//$this->_helper->redirector->gotoSimple("clientes", "empresa", "sistema");
			}
		}
    }

    public function clienteAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
        $fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
        $fiscalesCuentaContable = $this->fiscalesDAO->obtenerFiscalesCuentaContableCli($idFiscales);
		
		$this->view->fiscalesDAO = $this->fiscalesDAO;
		$this->view->fiscalesCuentaContable = $fiscalesCuentaContable;
		$this->view->fiscales = $fiscales;
		
    }
	
	
	public function editaAction(){
		$request = $this->getRequest();
		$idFiscales = $this->getParam("idFiscales");
		$fiscalesCuentaContable = $this->fiscalesDAO->obtenerFiscalesCuentaContableCli($idFiscales);
		$formulario = new Sistema_Form_AltaEmpresa;
		$formulario->getSubForm("0")->getElement("tipo")->setMultiOptions(array("CL"=>"Cliente"));
		$formulario->getSubForm("0")->getElement("tipo")->removeMultiOption("EM");
		$formulario->getSubForm("0")->getElement("tipo")->removeMultiOption("PR");
		$formulario->getSubForm("0")->removeElement("tipo");
		$formulario->getSubForm("0")->removeElement("tipoProveedor");
		$formulario->getSubForm("0")->getElement("razonSocial")->setValue($fiscalesCuentaContable["razonSocial"]);
		$formulario->getSubForm("0")->getElement("rfc")->setValue($fiscalesCuentaContable["rfc"]);
		$formulario->getSubForm("0")->getElement("cuenta")->setValue($fiscalesCuentaContable["cuenta"]);
		$formulario->getElement("submit")->setLabel("Actualizar	Fiscales");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		$formulario->removeSubForm("1");
		$formulario->removeSubForm("2");
		$formulario->removeSubForm("3");
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$rfc = $formulario->getSubForm("0")->getValue("rfc");
				$razonSocial = $formulario->getSubForm("0")->getValue('razonSocial');
				$tipoProveedor = $formulario->getSubForm("0")->getValue('tipoProveedor');
				$cuenta = $formulario->getSubForm("0")->getValue('cuenta');
				try{
					$this->fiscalesDAO->actualizarFiscalesCuentaContableCli($idFiscales, $rfc, $razonSocial, $cuenta);
					$this->view->messageSuccess = "Los datos fiscales se han actualizado correctamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "No se pudo actualizar los datos fiscales. Error: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
	}

}





