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
        // action body
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaEmpresa;
		$formulario->getSubForm("0")->getElement("tipo")->setMultiOptions(array("PR"=>"Proveedor"));
		//$formulario->getSubForm("0")->getElement("cuenta")->setAttrib("disabled", "true");
		$formulario->getElement("submit")->setLabel("Crear Proveedor");
		
		$this->view->formulario = $formulario;
		
		
		
		if($request->isPost()){
			print_r($request->getPost());
			print_r("<br />");
			
			if($formulario->isValid($request->getPost())){
				$contenedor = $formulario->getValues();
				
				$datos = $formulario->getValues();
				print_r($datos);
				print_r("<br />");
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
		$this->view->fiscales = $fiscales;
		$this->view->fiscalesDAO = $this->fiscalesDAO;
    }


}





