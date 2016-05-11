<?php

class Contabilidad_ProveedorController extends Zend_Controller_Action
{
	private $movimientosDAO;
	private $capasDAO;
	private $inventarioDAO;
	

    /*public $links = array(
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
        );*/

    public function init()
    {
        /* Initialize action controller here */
       	//$this->formatter = new NumberFormatter('es_MX', NumberFormatter::CURRENCY);
		//$this->view->links = $this->links;
		
		$this->notaEntradaDAO = new Contabilidad_DAO_NotaEntrada;
		 
		
		//$this->fiscalDAO = new Sistema_DAO_Fiscal;
		//$this->fiscalesDAO = new Sistema_DAO_Fiscales;
		
    }

    public function indexAction()
    {
    	 /* action body
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
		}**/
		
		/*$request = $this->getRequest();
        $formulario = new Contabilidad_Form_NotaEntradaProveedor;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				
				$notaEntrada= new Contabilidad_Model_Movimientos($datos);
				$this->movimientosDAO->crearNotaEntrada($notaEntrada);
				print_r($datos);
			}
    	}*/
    	$formulario = new Contabilidad_Form_NotaEntradaProveedor;
		
		//Obtengo lista de estados y los envio a la vista
		//$this->view->bancos = $this->bancoDAO->obtenerBancos();
		//Envio a la vista el formulario de Alta de Estado, si el usuario lo llega se recibe la informacion en altaAction
		$this->view->formulario = $formulario;	

    }

    public function agregarnotaentradaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Contabilidad_Form_NotaEntradaProveedor;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				
				$notaentrada = new Contabilidad_Model_Movimientos($datos);
				$this->notaEntradaDAO->crearNotaEntrada($datos);
				print_r($datos);
			}
		}
        

	}
}









