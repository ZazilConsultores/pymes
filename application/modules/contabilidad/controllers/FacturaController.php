<?php

class Contabilidad_FacturaController extends Zend_Controller_Action
{
	private $tablaEmpresa = null;
    private $tablaClientes = null;
    private $tablaProveedores = null;
    private $tablaFactura = null;
    private $tablaCuentasxc = null;
    private $tablaCuentasxp = null;
	
	public $links = array(
        'Inicio' => array(
            'module' => 'contabilidad',
            'controller' => 'factura',
            'action' => 'index'
            ),
        'Factura Cliente' => array(
            'module' => 'contabilidad',
            'controller' => 'factura',
            'action' => 'index',
            'tipo' => '1'
            ),
        'Factura Proveedor' => array(
            'module' => 'contabilidad',
            'controller' => 'factura',
            'action' => 'index',
            'tipo' => '2'
            )
);
    public function init()
    {
        /* Initialize action controller here */
        //$this->tablaEmpresa = new Application_Model_DbTable_Empresa;
        
		//$this->tablaClientes = new Application_Model_DbTable_Clientes;
		//$this->tablaProveedores = new Application_Model_DbTable_Proveedores;
		//$this->tablaFactura = new Application_Model_DbTable_Factura;

		$this->formatter = new NumberFormatter('es_MX', NumberFormatter::CURRENCY);
		$this->view->links = $this->links;    }

    public function indexAction()
    {
        // action body
        $request = $this->getRequest();
        $tipo = $this->getParam('tipo');
        $formulario = null;
		$rowset = null;
		$mensajeFormulario = null;
		
		if(! is_null($tipo)){
			if($tipo >= 1 && $tipo <= 2){
				switch ($tipo) {
					case '1':
						$mensajeFormulario = "<h3>Agregar factura Clientes</h3>";
						$formulario = new Contabilidad_Form_AgregarFacturaCliente;
						break;
						
					case '2':
						$mensajeFormulario = "<h3>Agregar Factura Proveedor</h3>";
						$formulario = new Contabilidad_Form_AgregarFacturaProveedor;
						break;
					
				}//	Del switch
			}//	Del if
		}//	Del if is_null($tipo)
		
		if($request->isGet()){
			$this->view->mensajeFormulario = $mensajeFormulario;
			$this->view->formulario = $formulario;
		}

	}
}