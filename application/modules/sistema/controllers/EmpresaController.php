<?php

class Sistema_EmpresaController extends Zend_Controller_Action
{

    private $empresaDAO = null;

    private $domicilioDAO = null;

    private $fiscalesDAO = null;

    private $telefonoDAO = null;

    private $emailDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Sistema_DAO_Empresa;
		//$this->fiscalDAO = new Sistema_DAO_Fiscal;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		$this->domicilioDAO = new Sistema_DAO_Domicilio;
		$this->telefonoDAO = new Sistema_DAO_Telefono;
		$this->emailDAO = new Sistema_DAO_Email;
    }

    public function indexAction()
    {
        // action body
        //$empresas = $this->empresaDAO->o
        
    }

    public function altaAction()
    {
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaEmpresa;
		$formulario->getSubForm("0")->getElement("tipo")->removeMultiOption("CL");
		$formulario->getSubForm("0")->getElement("tipo")->removeMultiOption("PR");
		//$formulario->getSubForm("0")->removeElement("tipoProveedor");
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				print_r($datos);
				//$empresa = new Sistema_Model_Fiscal($datos[0]);
				//print_r($empresa->toArray());
				try{
					$this->empresaDAO->crearEmpresa($datos);
					$this->view->messageSuccess = "Empresa dada de alta con exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
				
			}
		}
    }

    public function empresasAction()
    {
        // action body
        $idFiscales = $this->empresaDAO->obtenerIdFiscalesEmpresas();
		//$idFiscales = $this->empresaDAO->obtenerIdFiscalesEmpresas();
		$fiscales = array();
		foreach ($idFiscales as $id) {
			$fiscales[] = $this->fiscalesDAO->obtenerFiscales($id);
		}
        //$fiscales = $this->fiscalDAO->obtenerFiscalesEmpresa();
		$this->view->fiscales = $fiscales;
    }

    public function clientesAction()
    {
        // action body
        $eClientes = $this->empresaDAO->obtenerEmpresasClientes();
		$fiscales = array();
		foreach ($eClientes as $eCliente) {
			$fiscales[] = $this->fiscalesDAO->obtenerFiscales($eCliente["idFiscales"]);
		}
        //$fiscales = $this->fiscalDAO->obtenerFiscalesCliente();
		$this->view->fiscales = $fiscales;
    }

    public function proveedoresAction()
    {
        // action body
        $eProveedores = $this->empresaDAO->obtenerEmpresasProveedores();
		//print_r($idFiscales);
		$fiscales = array();
		
		foreach ($eProveedores as $eProveedor) {
			$fiscales[] = $this->fiscalesDAO->obtenerFiscales($eProveedor["idFiscales"]);
		}
        
		$this->view->fiscales = $fiscales;
    }

    public function sucursalesAction()
    {
        // action body
        //$empresaDAO = $this->empresaDAO;
		//$sucursales = $empresaDAO;
		$idFiscales = $this->getParam("idFiscales");
		$tipoSucursal = $this->getParam("tipoSucursal");
		//$empresaDAO->obtenerSucursales($idFiscales);
		$this->view->empresaDAO = $this->empresaDAO;
		$this->view->fiscalesDAO = $this->fiscalesDAO;
		$this->view->idFiscales = $idFiscales;
		$this->view->tipoSucursal = $tipoSucursal;
    }


}








