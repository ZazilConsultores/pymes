<?php

class Sistema_ProveedoresController extends Zend_Controller_Action
{
	private $empresaDAO = null;
	private $fiscalesDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Sistema_DAO_Empresa;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaEmpresa;
		$formulario->getSubForm("0")->getElement("tipo")->setMultiOptions(array("PR"=>"Proveedor"));
		$formulario->getSubForm("0")->removeElement("regFiscal");
		//$formulario->getSubForm("0")->getElement("cuenta")->setAttrib("disabled", "true");
		$formulario->getElement("submit")->setLabel("Crear Proveedor");
		$this->view->formulario = $formulario;
		if($request->isPost()){
		    if($formulario->isValid($request->getPost())){
		        $contenedor = $formulario->getValues();
				$datos = $formulario->getValues();
				try{
					$this->empresaDAO->crearEmpresa($datos);
					$this->view->messageSuccess = "Proveedor creado exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = "Error al registrar el proveedor: <strong>". $ex->getMessage()."</strong>";
				}
				
			}
		}
    }

    public function proveedorAction()
    {
        // action body
		//	======================================================
		$idFiscales = $this->getParam("idFiscales");
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		$fiscalesCuentaContable = $this->fiscalesDAO->obtenerFiscalesCuentaContable($idFiscales);
		$this->view->fiscales = $fiscales;
		$this->view->fiscalesCuentaContable = $fiscalesCuentaContable;
		$this->view->fiscalesDAO = $this->fiscalesDAO;
    }

	public function editaAction(){
		$request = $this->getRequest();
		$idFiscales = $this->getParam("idFiscales");
		$fiscalesCuentaContable = $this->fiscalesDAO->obtenerFiscalesCuentaContable($idFiscales);
		$formulario = new Sistema_Form_AltaEmpresa;
		$formulario->getSubForm("0")->getElement("tipo")->setMultiOptions(array("PR"=>"Proveedor"));
		$formulario->getSubForm("0")->getElement("tipo")->removeMultiOption("EM");
		$formulario->getSubForm("0")->getElement("tipo")->removeMultiOption("CL");
		$formulario->getSubForm("0")->removeElement("tipo");
		
		$formulario->getSubForm("0")->getElement("razonSocial")->setValue($fiscalesCuentaContable["razonSocial"]);
		$formulario->getSubForm("0")->getElement("rfc")->setValue($fiscalesCuentaContable["rfc"]);
		$formulario->getSubForm("0")->getElement("cuenta")->setValue($fiscalesCuentaContable["cuenta"]);
		$formulario->getSubForm("0")->getElement("tipoProveedor")->setValue($fiscalesCuentaContable["idTipoProveedor"]);
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
					$this->fiscalesDAO->actualizarFiscalesCuentaContable($idFiscales, $rfc, $razonSocial, $tipoProveedor, $cuenta);
					$this->view->messageSuccess = "Los datos fiscales se han actualizado correctamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "No se pudo actualizar los datos fiscales. Error: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
	}
}





