<?php

class Contabilidad_ProveedorController extends Zend_Controller_Action
{

    private $empresaDAO = null;
    private $notaEntradaDAO = null;
    private $remisionEntradaDAO = null;
    private $facturaDAO = null;
    private $pagoProveedor = null;
    private $anticipoDAO = null;

    public function init()
    {
    	$this->empresaDAO = new Sistema_DAO_Empresa;
    	$this->notaEntradaDAO = new Contabilidad_DAO_NotaEntrada;
    	$this->remisionEntradaDAO =  new Contabilidad_DAO_RemisionEntrada;
    	$this->facturaDAO = new Contabilidad_DAO_FacturaProveedor;
		$this->pagoProveedorDAO = new Contabilidad_DAO_PagoProveedor;
		$this->anticipoDAO = new Contabilidad_DAO_Anticipos;
		//==============Muestra los links del submenu=======================
		//$this->view->links = $this->links;
		$adapter = Zend_Registry::get('dbmodgeneral');
		$this->db = $adapter;
		// =================================================== >>> Obtenemos todos los productos de la tabla producto
		$select = $this->db->select()->from("Producto")->order("producto ASC");
		$statement = $select->query();
		$rowsProducto =  $statement->fetchAll();
		
		$select = $this->db->select()->from("Unidad");
		$statement = $select->query();
		$rowsUnidad =  $statement->fetchAll();
	
		$select = $this->db->select()->from("Multiplos")
		->join("Unidad", "Unidad.idUnidad = Multiplos.idUnidad");
		$statement = $select->query();
		$rowsMultiplos = $statement->fetchAll();
		
		// =================================== Codificamos los valores a formato JSON
		$jsonProductos = Zend_Json::encode($rowsProducto);
		$this->view->jsonProductos = $jsonProductos;
		
		$jsonUnidad = Zend_Json::encode($rowsUnidad);
		$this->view->jsonUnidad = $jsonUnidad;
		
		$jsonMultiplos = Zend_Json::encode($rowsMultiplos);
		$this->view->jsonMultiplos = $jsonMultiplos;
    }

    public function indexAction()
    {
  
    }

    public function notaAction()
    {
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_NuevaNotaProveedor;
        $this->view->formulario = $formulario;	
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$encabezado = $datos[0];				
				$productos = json_decode($encabezado['productos'], TRUE);
				try{
					$notaentrada = $this->notaEntradaDAO->agregarProducto($encabezado, $productos);
					$actualizaProducto = $this->notaEntradaDAO->actulizaProducto($encabezado, $productos);
					$actualizaCostoProducto = $this->notaEntradaDAO->actulizaCostoProducto($encabezado, $productos);
					$this->view->messageSuccess = "Nota: <strong>" .$encabezado["numFolio"] . " </strong> guardada exitosamente!!";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = "Error al crear el Nota Proveedor: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
    }

    public function remisionAction()
    {
    	$request = $this->getRequest();
        $formulario = new Contabilidad_Form_AgregarRemisionProveedor;
		$this->view->formulario = $formulario;	
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$remisionEntradaDAO = new Contabilidad_DAO_RemisionEntrada;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago = $datos[1];
				$productos = json_decode($encabezado['productos'],TRUE);
				$contador = 0;
				try{
					foreach ($productos as $producto){
						$movimiento = $this->remisionEntradaDAO->agregarProducto($encabezado, $producto, $formaPago);
						$actualizaProducto = $this->remisionEntradaDAO->actulizaProducto($encabezado, $formaPago, $producto);
						$contador++;
					}
					$guardaPago = $this->remisionEntradaDAO->guardaPago($encabezado, $formaPago,$productos);
					$saldoBanco = $this->remisionEntradaDAO->saldoBanco($formaPago, $productos);
					$actualizaCostoProducto = $this->remisionEntradaDAO->actulizaCostoProducto($encabezado, $productos);
					$this->view->messageSuccess = "Remisión: <strong>" .$encabezado["numFolio"] . " </strong> guardada exitosamente!!";
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
					
			}
		}
    }

    public function facturaAction()
    {
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarFacturaProveedor;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago = $datos[1];
				$productos = json_decode($encabezado['productos'], TRUE);
				$importe = json_decode($formaPago['importes'], TRUE);
				$contador = 0;
				try{
				    $guardaFactura = $this->facturaDAO->guardaFactura($encabezado, $importe, $formaPago, $productos);
					foreach ($productos as $producto){
						$guardaDetalle = $this->facturaDAO->guardaDetalleFactura($encabezado, $producto, $importe);
						$actualizaProducto = $this->facturaDAO->actulizaProducto($encabezado,$formaPago, $producto, $importe);
						$actualizaPT = $this->facturaDAO->actulizaCostoProducto($encabezado, $formaPago, $producto, $importe);
						$contador++;
					}
					$this->view->messageSuccess = "Factura: <strong>" .$guardaFactura["numeroFactura"] . " </strong> guardada exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: La factura no se ha ejecutado correctamente: <strong>". $ex->getMessage()."</strong>";;
				}
			}
			
		}
			
    }

    public function pagosAction()
    {
		$request = $this->getRequest();
		$empresas = $this->empresaDAO->obtenerFiscalesEmpresas(); 
        $this->view->empresas = $empresas;	
		if($request->isGet()){
			$this->view->empresas = $empresas;	
		}if($request->isPost()){		
			$datos = $request->getPost();
			$idSucursal = $this->getParam("sucursal");
        	$pr = $this->getParam("proveedor"); 
		}
    }

    public function aplicarpagoAction()
    {
        $request = $this->getRequest();
		$idFactura = $this->getParam("idFactura");
		$formulario = new Contabilidad_Form_PagosProveedor;
		$this->view->formulario = $formulario;
		$pagosDAO = new Contabilidad_DAO_PagoProveedor;
		$datosFactura = $pagosDAO->obtiene_Factura($idFactura);
		$this->view->datosFactura = $pagosDAO->obtiene_Factura($idFactura);	
		$this->view->proveedorFac = $pagosDAO->obtenerProveedoresEmpresa($idFactura);
		$this->view->sucursalFac = $pagosDAO->obtenerSucursal($idFactura);
	
    	if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				try{
					$pago = $this->pagoProveedorDAO->aplica_Pago($idFactura, $datos);
					$this->view->messageSuccess = "Pago: <strong>".$datosFactura["numeroFactura"]."</strong> se ha efectuado exitosamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
    }

    public function anticipoAction()
    {
    	$request = $this->getRequest();
        $formulario = new Contabilidad_Form_AnticipoProveedor;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$anticipo = $formulario->getValues();
				try{
					$this->anticipoDAO->guardaAnticipoProveedor($anticipo);
					$this->view->messageSuccess = "Anticipo: <strong>".$anticipo["numeroReferencia"]."</strong> creado exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = "Error al guardar el anticipo: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
        
    }

    public function movimientosAction()
    {
        $ProvDAO  = new Contabilidad_DAO_NotaEntrada;
		$facturaProvDAO = new Contabilidad_DAO_FacturaProveedor;
		$request = $this->getRequest();
		$proveedores = $ProvDAO->obtenerProveedores();
		$this->view->proveedores = $proveedores;	
		if($request->isGet()){
			$this->view->proveedores = $proveedores;		
		}if($request->isPost()){		
			$datos = $request->getPost();
		}
    }

    public function cancelarAction()
    {
    	$request = $this->getRequest();
		$empresas = $this->empresaDAO->obtenerFiscalesEmpresas(); 
        $this->view->empresas = $empresas;
		if($request->isPost()){					
			$datos = $request->getPost();
			$idFactura = $datos["fac"];
			$this->facturaDAO->cancelaFactura($idFactura);
		}    
    }
}


























