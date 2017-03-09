<?php

class Contabilidad_ProveedorController extends Zend_Controller_Action
{

   
	private $inventarioDAO = null;
	private $notaEntradaDAO =null;
	private $remisionEntradaDAO = null;
	private $facturaDAO = null;
	private $pagoProveedor = null;

    public function init()
    {
    	$this->facturaDAO = new Contabilidad_DAO_FacturaProveedor;
		$this->notaEntradaDAO = new Contabilidad_DAO_NotaEntrada;
		$this->remisionEntradaDAO =  new Contabilidad_DAO_RemisionEntrada;
		$this->pagoProveedor = new Contabilidad_DAO_PagoProveedor;
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

		//Impuesto Producto
		$select = $this->db->select()->from('ImpuestoProductos');
		$statement = $select->query();
		$rowImpuesto =$statement->fetchAll();
		///////////////////
		$jsonImpuestoProductos = Zend_Json::encode($rowImpuesto);
		$this->view->jsonImpuestos = $jsonImpuestoProductos;
		
		//============================================>>>Multiplos
		//$idProducto = $this->getParam("idProducto");
	
		/*$select = $this->db->select()->from("Multiplos","idMultiplos")
		->join("Unidad", "Unidad.idUnidad = Multiplos.idUnidad")->where("idProducto=?",$idProducto);
		$statement = $select->query();
		$rowsMultiplo = $statement->fetchAll();*/
		
		// =================================== Codificamos los valores a formato JSON
		$jsonProductos = Zend_Json::encode($rowsProducto);
		$this->view->jsonProductos = $jsonProductos;
		
		$jsonUnidad = Zend_Json::encode($rowsUnidad);
		$this->view->jsonUnidad = $jsonUnidad;
		
		/*$jsonMultiplos = Zend_Json::encode($rowsMultiplo);
		$this->view->jsonMultiplo = $jsonMultiplos;*/
		
		$this->inventarioDAO = new Inventario_DAO_Empresa;
	
    }

    public function indexAction()
    {
  
    }

    public function agregarnotaentradaAction()
    {
        
    }

    public function notaAction()
    {
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_NuevaNotaProveedor;
        //$formulario->getSubForm("0")->removeElement("submit");
        
		//$formulario->removeElement("submit");
		if($request->isGet()){
			$this->view->formulario = $formulario;		
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$notaEntradaDAO = new Contabilidad_DAO_NotaEntrada;
				$datos = $formulario->getValues();
				//print_r($datos);
				$encabezado = $datos[0];
				//print_r($encabezado);
				$productos = json_decode($encabezado['productos'],TRUE);
				//print_r($encabezado);
				//print_r('<br />');
				print_r($productos);
				$contador=0;
			
				foreach ($productos as $producto){
					//$producto->encabezado();
					//sprint_r($producto);
					try{
						$agregarProducto = $this->notaEntradaDAO->agregarProducto($encabezado, $producto);
						$suma = $this->notaEntradaDAO->suma($encabezado, $producto);
						//$notaEntradaDAO->agregarProducto($encabezado, $producto);
						//print_r($contador);
						$contador++;
					}catch(Util_Exception_BussinessException $ex){
						$this->view->messageFail = $ex->getMessage();
					}
						
				}
				
			}/*else{
				print_r("formulario no valido <br />");
			}	*/				
			//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
		}
    }

    public function remisionAction()
    {
        // action body
		$request = $this->getRequest();
        $formulario = new Contabilidad_Form_AgregarRemisionProveedor;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago =$datos[1];
				$productos = json_decode($encabezado['productos'],TRUE);
				print_r('<br />');
				$contador=0;
				//$saldoBanco = $this->remisionEntradaDAO->actulizaSaldoBanco($encabezado, $formaPago);
				$guardaPago = $this->remisionEntradaDAO->guardaPago($encabezado, $formaPago,$productos);
				$editaBanco = $this->remisionEntradaDAO->editarBanco($formaPago, $productos); 
				foreach ($productos as $producto){
					//$producto->encabezado();
					//sprint_r($producto);
					//$notaEntradaDAO->agregarProducto($encabezado, $producto, $formaPago);
					/*$remisionEntradaDAO->agregarProducto($encabezado, $producto, $formaPago);
					print_r($remisionEntradaDAO);
					$contador++;*/
					//try{
						//$guardaProducto =$this-($encabezado, $producto, $formaPago);
						//$guardaMovimiento = $this->remisionEntradaDAO->
						//$suma = $this->notaEntradaDAO->suma($encabezado, $producto);
						//$guardaProducto = $this->remisionEntradaDAO->agregarProducto($encabezado, $producto, $formaPago);
						//$contador++;
						//$this->view->messageSuccess ="Remision de Entrada realizada efectivamente" ;
					//}catch(Util_Exception_BussinessException $ex){
						//$this->view->messageFail = $ex->getMessage();
					}
					
				}
			
			}
		
    }

    public function facturaAction()
    {
    	//$idImpuesto = $this->getParam("idImpuesto");
		//$idImpuesto = $this->setParam($paramName, $value)
		$idImpuesto = $this->setParam("idImpuesto", '15');
		//print_r($idImpuesto);
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AgregarFacturaProveedor;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$formaPago = $datos[1];
				$productos = json_decode($encabezado['productos'], TRUE);
				$importe = json_decode($formaPago['importes'], TRUE);
				print_r($productos);
				
				$guardaFactura = $this->facturaDAO->guardaFactura($encabezado, $importe, $formaPago, $productos);
				
				$saldoProveedor = $this->facturaDAO->actualizaSaldoProveedor($encabezado, $formaPago);
				$saldoBanco = $this->facturaDAO->actualizarSaldoBanco($formaPago);
					 	
				foreach ($productos as $producto){
					$guardaDetalle = $this->facturaDAO->guardaDetalleFactura($encabezado, $producto, $importe);	
				}
					
			}
			
		}
    }

    public function pagosAction()
    {
		$idCoP = $this->getParam("idCoP");
		$idSucursal = $this->getParam("idSucursal");
		//$idCoP = $this->getParam("idCoP");

		$request = $this->getRequest();
		$formulario = new Contabilidad_Form_PagosProveedor;
		$this->view->formulario = $formulario;
	
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$facturasp = $this->pagoProveedor->busca_facturap($datos["idCoP"]);
				$cuentaxp = $this->pagoProveedor->busca_Cuentasxp($datos["idSucursal"], $datos["idCoP"],$datos["numeroFactura"]);
				$this->view->facturasp = $facturasp;
			}	
		}
    }
}
















