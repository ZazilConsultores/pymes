<?php

class Consulta_MovimientosController extends Zend_Controller_Action
{
	 public $links = array(
        'Inicio prueba' => array(
            'module' => 'consulta',
            'controller' => 'Movimientos',
            'action' => 'index'
            ),
        'Empresa - Cliente' => array(
            'module' => 'consulta',
            'controller' => 'movimientos',
            'action' => 'index',
            'tipo' => '1'
            ),
        'Empresas - Cliente' => array(
            'module' => 'consulta',
            'controller' => 'movimientos',
            'action' => 'index',
            'tipo' => '2'
            ),
        'Empresas - Clientes' => array(
            'module' => 'consulta',
            'controller' => 'movimientos',
            'action' => 'index',
            'tipo' => '3'
            ),
        'Empresa - Proveedor' => array(
            'module' => 'consulta',
            'controller' => 'movimientos',
            'action' => 'index',
            'tipo' => '4'
            ),
        'Empresas - Proveedor' => array(
            'module' => 'consulta',
            'controller' => 'movimientos',
            'action' => 'index',
            'tipo' => '5'
            ),
        'Empresas - Proveedores' => array(
            'module' => 'consulta',
            'controller' => 'movimientos',
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
    	// action bodyli
        $request = $this->getRequest();
        $tipo = $this->getParam('tipo');
        $formulario = null;
		$rowset = null;
		$mensajeFormulario = null;
		
		if(! is_null($tipo)){
			if($tipo >= 1 && $tipo <= 6){
				switch ($tipo) {
					case '1':
						$mensajeFormulario = "<h3>Consulta de Movimientos de una Empresa</h3>";
						$formulario = new Consulta_Form_EmpresaClienteFR;
						break;
						
					case '2':
						$mensajeFormulario = "<h3>Consulta de Movimientos de TODAS las Empresas con un Cliente</h3>";
						$formulario = new Consulta_Form_EmpresasClienteFR;
						break;
					
					case '3':
						$mensajeFormulario = "<h3>Consulta de Movimientos de TODAS las Empresas con TODOS los Clientes</h3>";
						$formulario = new Consulta_Form_EmpresasClientesFR;
						break;
					
					case '4':
						$mensajeFormulario = "<h3>Consulta de Movimientos de una Empresa con un Proveedor</h3>";
						$formulario = new Consulta_Form_EmpresaProveedorFR;
						break;
					
					case '5':
						$mensajeFormulario = "<h3>Consulta de Movimientos de TODAS las Empresas con un Proveedor</h3>";
						$formulario = new Consulta_Form_EmpresasProveedorFR;
						break;
					
					case '6':
						$mensajeFormulario = "<h3>Provando TODAS las Empresas</h3>";
						$formulario = new Consulta_Form_EmpresasProveedoresFR;
						break;
				}//	Del switch
			}//	Del if
		}//	Del if is_null($tipo)
		
		if($request->isGet()){
			$this->view->mensajeFormulario = $mensajeFormulario;
			$this->view->formulario = $formulario;
		}// Del if $request->isGet()
        
        if($request->isPost()) {
        	$this->view->tipo = $tipo;
        	//$tipo = $this->getParam('tipo');
        	$formulario->isValid($request->getPost());
			$datos = $formulario->getValues();
			
			$tablaFactura = new Application_Model_DbTable_Factura;
			$tablaEmpresa = new Application_Model_DbTable_Empresa;
			$tablaCliente = new Application_Model_DbTable_Clientes;
			$tablaProveedor = new Application_Model_DbTable_Proveedores;
			
			$empresa = null;
			$cliente = null;
			$proveedor = null;
			
			$mensaje = 'Detalle de movimientos (Facturas/Remisiones) de: <br />';
			
			if(! is_null($tipo)){
				if($tipo >= 1 && $tipo <= 6){
					switch ($tipo) {
						case '1':
							$rowset = $tablaFactura->obtenerMovimientosEmpresaCliente($datos);
	
							$empresa = $tablaEmpresa->obtenerEmpresa($datos['empresa']);
							$cliente = $tablaCliente->obtenerCliente($datos['cliente']);
							$mensaje .= $empresa['Nombre'] . ' clave::' . $empresa['CveEmp'] . ' con: <br />';
							$mensaje .= $cliente['Nombre'] . ' clave::' . $cliente['Cliente'] . '<br />';
							$this->view->empresa = $empresa;
							$this->view->cliente = $cliente;
							break;
						case '2':
							$rowset = $tablaFactura->obtenerMovimientosTodoEmpresaCliente($datos);
							$cliente = $tablaCliente->obtenerCliente($datos['cliente']);
							$mensaje .= 'TODAS LAS EMPRESAS con: ';
							$mensaje .= $cliente['Nombre'] . ' clave::' . $cliente['Cliente'] . '<br />';
							$this->view->cliente = $cliente;
							break;
						case '3':
							$rowset = $tablaFactura->obtenerMovimientosTodoEmpresaTodoCliente($datos);
							$mensaje .= 'TODAS LAS EMPRESAS con: ';
							$mensaje .= 'TODOS LOS CLIENTES<br />';
							break;
						case '4':
							$rowset = $tablaFactura->obtenerMovimientosEmpresaProveedor($datos);
							$empresa = $tablaEmpresa->obtenerEmpresa($datos['empresa']);
							$proveedor = $tablaProveedor->obtenerProveedor($datos['proveedor']);
							$mensaje .= $empresa['Nombre'] . ' clave::' . $empresa['CveEmp'] . ' con: <br />';
							$mensaje .= $proveedor['Empresa'] . ' clave::' . $proveedor['Proveedor'] . '<br />';
							$this->view->empresa = $empresa;
							$this->view->proveedor = $proveedor;
							break;
						case '5':
							$rowset = $tablaFactura->obtenerMovimientosTodoEmpresaProveedor($datos);
							$proveedor = $tablaProveedor->obtenerProveedor($datos['proveedor']);
							$mensaje .= 'TODAS LAS EMPRESAS con: ';
							$mensaje .= $proveedor['Empresa'] . ' clave::' . $proveedor['Proveedor'] . '<br />';
							$this->view->proveedor = $proveedor;
							break;
						case '6':
							$rowset = $tablaFactura->obtenerMovimientosTodoEmpresaTodoProveedor($datos);
							$mensaje .= 'TODAS LAS EMPRESAS con: ';
							$mensaje .= 'TODOS LOS PROVEEDORES<br />';
							break;
					}//	Del switch
					
					$this->view->mensaje = '<h3>' . $mensaje . '</h3>';
					$this->view->rowset = $rowset;
					$this->view->datosForm = $datos;
				}// Del if $tipo >=1 || $tipo <=6
			}//	Del if is_null($tipo)
        }//	Del if->isPost()
     
    }

}

