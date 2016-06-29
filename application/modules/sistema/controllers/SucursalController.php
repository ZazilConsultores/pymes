<?php

class Sistema_SucursalController extends Zend_Controller_Action
{
	private $empresaDAO;
	private $fiscalesDAO;

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
        $idFiscales = $this->getParam("idFiscales");
		$tipoSucursal = $this->getParam("tipoSucursal");
		
		$empresa = $this->empresaDAO->obtenerEmpresaPorIdFiscales($idFiscales);
		$fiscal = $this->fiscalesDAO->obtenerFiscales($idFiscales);
        
        $formulario = new Sistema_Form_AltaSucursal;
		
		$tiposSucursales = Zend_Registry::get("tipoSucursal");
		//print_r("Es empresa: " . $this->empresaDAO->esEmpresa($idFiscales));
		//print_r("<br />");
		
		// Si el IdFiscales no es empresa
		if( !$this->empresaDAO->esEmpresa($idFiscales)){
			// Si no es empresa cambiamos el valor por defecto del formulario tipoSucursal
			$formulario->getSubForm("0")->getElement("tipoSucursal")->setMultiOptions(array($tipoSucursal=> ($tipoSucursal == "SC") ? "Sucursal Cliente" : "Sucursal Proveedor"));
		}
		
		$this->view->fiscal = $fiscal;
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				//print_r("<br />");
				//print_r("==========================================");
				//print_r("<br />");
				try{
					$this->empresaDAO->agregarSucursal($idFiscales, $datos, $tipoSucursal);
					$this->view->messageSuccess = "Sucursal dada de alta exitosamente en la empresa: <strong>".$fiscal->getRazonSocial()."</strong>";
				}catch(Exception $ex){
					$this->view->messageFail = "Ha ocurrido un error: <strong>".$ex->getMessage()."</strong>";
				}
				//$this->empresaDAO->agregarSucursal($idFiscales, $datos, $tipoSucursal);
			}
		} 
    }
	
	public function edomicilioAction()
    {
        // action body
    }

    public function atelefonoAction()
    {
        // Agregar un telefono a la sucursal
    }

    public function etelefonoAction()
    {
        // Editar un telefono de la sucursal
    }

    public function dtelefonoAction()
    {
        // Eliminar un telefono de la sucursal
    }

    public function aemailAction()
    {
        // Agregar un email a la sucursal
    }

    public function eemailAction()
    {
        // Editar un email de la sucursal
    }

    public function demailAction()
    {
        // action body
    }
	
}
