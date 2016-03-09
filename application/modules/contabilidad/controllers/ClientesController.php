<?php

class Contabilidad_ClientesController extends Zend_Controller_Action
{
	public $links = array(
        'Inicio' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index'
            ),
        'Factura Cliente' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index',
            'tipo' => '1'
            ),
        'Remision Cliente' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index',
            'tipo' => '2'
            ),
		'Cobro Factura' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index',
            'tipo' => '3'
            ),
		'Cancelar Factura' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index',
            'tipo' => '4'
            ),
         'Cancelar Remision' => array(
            'module' => 'contabilidad',
            'controller' => 'clientes',
            'action' => 'index',
            'tipo' => '5'
            )
);

    public function init()
    {
        /* Initialize action controller here */
        $this->formatter = new NumberFormatter('es_MX', NumberFormatter::CURRENCY);
		$this->view->links = $this->links;
    }

    public function indexAction()
    {
    	 // action body
        $request = $this->getRequest();
        $tipo = $this->getParam('tipo');
        $formulario = null;
		$rowset = null;
		$mensajeFormulario = null;
		
		if(! is_null($tipo)){
			if($tipo >= 1 && $tipo <= 5){
				switch ($tipo) {
					case '1':
						$mensajeFormulario = "<h3>Nueva Factura Cliente</h3>";
						$formulario = new Contabilidad_Form_AgregarFacturaCliente;
						break;
						
					case '2':
						$mensajeFormulario = "<h3>Nueva Remision Cliente</h3>";
						$formulario = new Contabilidad_Form_AgregarRemisionCliente;
						break;
					case '3':
						$mensajeFormulario = "<h3>Cobro Factura</h3>";
						$formulario = new Contabilidad_Form_Cobrofactura;
						break;
					case '4':
						$mensajeFormulario = "<h3>Cancelar Factura</h3>";
						$formulario = new Contabilidad_Form_CancelarFacturaCliente;
						break;
					case '5':
						$mensajeFormulario = "<h3>Cancelar Remision</h3>";
						$formulario = new Contabilidad_Form_CancelarRemisionCliente;
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


