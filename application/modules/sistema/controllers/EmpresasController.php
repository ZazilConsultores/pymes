<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_EmpresasController extends Zend_Controller_Action
{
	private $empresaDAO;
	private $domicilioDAO;
	private $fiscalesDAO;
	private $telefonoDAO;
	private $emailDAO;
    

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Sistema_DAO_Empresa;
		$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		$this->domicilioDAO = new Sistema_DAO_Domicilio;
		$this->telefonoDAO = new Sistema_DAO_Telefono;
		$this->emailDAO = new Sistema_DAO_Email;
    }

    public function indexAction()
    {
        // action body
        $fiscales = $this->fiscalesDAO->obtenerFiscalesEmpresa();
		$this->view->fiscales = $fiscales;
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaEmpresa;
		$formulario->getSubForm("0")->getElement("tipo")->setMultiOptions(array("EM"=>"Empresa"));
		
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
				$fiscales = $this->fiscalesDAO->crearFiscales($modelFiscales);
				$modelDomicilio = new Sistema_Model_Domicilio($datosDomicilio);
				$this->domicilioDAO->crearDomicilioFiscal($fiscales->getIdFiscales(), $modelDomicilio);
				$modelTelefono = new Sistema_Model_Telefono($datosTelefono);
				$this->telefonoDAO->crearTelefonoFiscal($fiscales->getIdFiscales(), $modelTelefono);
				$modelEmail = new Sistema_Model_Email($datosEmail);
				$this->emailDAO->crearEmailFiscales($fiscales->getIdFiscales(), $modelEmail);
				
				$datos = array();
				$datos["idFiscales"] = $fiscales->getIdFiscales();
				$datos["esEmpresa"] = "S";
				$datos["esCliente"] = "N";
				$datos["esProveedor"] = "N";
				$modelEmpresa = new Sistema_Model_Empresa($datos);
				$this->empresaDAO->crearEmpresa($modelEmpresa);
				
				$this->_helper->redirector->gotoSimple("index", "empresas", "sistema");
			}
		}
		
    }


}



