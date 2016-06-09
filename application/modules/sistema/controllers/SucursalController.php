<?php

class Sistema_SucursalController extends Zend_Controller_Action
{
	private $empresaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->empresaDAO = new Sistema_DAO_Empresa;
    }

    public function indexAction()
    {
        // action body
    }
	
	public function altaAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		$empresa = $this->empresaDAO->obtenerEmpresaPorIdFiscales($idFiscales);
		print_r($empresa);
        
        $formulario = new Sistema_Form_AltaEmpresa;
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
