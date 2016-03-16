<?php

class Contabilidad_ProveedorController extends Zend_Controller_Action
{
	public $links = array(
        'Inicio' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index'
            ),
          'Nota Entrada' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' => '1'
            ),
          'Remision Proveedor' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' => '2'
            ),   
        'Factura Proveedor' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' => '3'
            ),
        
		'Cobro Factura' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' => '4'
            ),
		'Cancelar Factura' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' => '5'
            ),
         'Cancelar Remision' => array(
            'module' => 'contabilidad',
            'controller' => 'proveedor',
            'action' => 'index',
            'tipo' => '6'
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
			if($tipo >= 1 && $tipo <= 6){
				switch ($tipo) {
					case '1':
						$mensajeFormulario = "<h3>Nueva Nota Entrada Proveedor</h3>";
						$formulario = new Contabilidad_Form_NotaEntradaProveedor;
						break;
							
					case '2':
						$mensajeFormulario = "<h3>Remision Proveedor</h3>";
						
						break;
					case '3':
						$mensajeFormulario = "<h3>Pago Factura</h3>";
						
						break;
					case '4':
						$mensajeFormulario = "<h3>Cancelar Factura</h3>";
						
						break;
					case '5':
						$mensajeFormulario = "<h3>Cancelar Remision</h3>";
						
						break;
					case '6':
						$mensajeFormulario = "<h3>Cancelar Remision</h3>";
						
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

