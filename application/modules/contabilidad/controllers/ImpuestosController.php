<?php

class Contabilidad_ImpuestosController extends Zend_Controller_Action
{

    private $impuestoDAO = null;

    private $productoDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->impuestoDAO = new Contabilidad_DAO_Impuesto;
		$this->productoDAO =  new Inventario_DAO_Producto;
    }

    public function indexAction()
    {
    	//$idImpuestpo =$this->getParam('idImpuesto');
    	//$formulario =  new Contabilidad_Form_CrearImpuesto;
    	$impuestoDAO = $this->impuestoDAO;
		$this->view->impuestos  = $this->impuestoDAO->obtenerImpuestos();
		
    }

    public function altaAction()
    {
    	$request =$this->getRequest();
		$idImpuesto = $this->getParam("idImpuesto");
		$formulario = new Contabilidad_Form_CrearImpuesto;
		$this->view->formulario = $formulario;
		$formulario->removeElement("idImpuesto");
		$formulario->removeElement("idProducto");
		$formulario->removeElement("porcentaje");
		$formulario->removeElement("importe");
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$impuesto = new Contabilidad_Model_Impuesto($datos);
		
				$impuesto->setIdImpuesto($idImpuesto);
				//print_r($impuesto);
				try{
					$this->impuestoDAO->nuevoImpuesto($impuesto);
				}catch(Util_Exception_BussinessException $ex){
					
				}
			}
		}
        
    }

    public function editarAction()
    {
    	$request = $this->getRequest();
		$idImpuesto = $this->getParam('idImpuesto');
		$impuesto = $this->impuestoDAO->obtenerImpuesto($idImpuesto);
		$formulario = new Contabilidad_Form_CrearImpuesto;
		$formulario->getElement("abreviatura")->setValue($impuesto->getAbreviatura());
		$formulario->getElement("descripcion")->setValue($impuesto->getDescripcion());
		$formulario->getElement("submit")->setLabel("Actualizar Impuesto");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->impuesto = $impuesto;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost()))
			{
				$datos = $formulario->getValues();
				$impuesto = new Contabilidad_Model_Impuesto($datos);
				try{
					$this->impuestoDAO->editarImpuesto($idImpuesto, $datos);
					
				}catch(exception $ex){
					
				}
			}
    	}
    }

    public function enlazarAction()
    {
    	/*$idProducto = $this->getParam("idProducto");
		$idImpuesto = $this->getParam("idImpuesto");
		print_r($idProducto);
		//$producto = $this->productoDAO->obtenerProducto($idProducto);
    	//$this->view->productoImpuestos = $this->productoDAO->obtenerProductos();
    	//$productoImpuesto = $this->impuestoDAO->obtenerImpuetoProductos($idImpuesto);
		  $this->view->fiscalesEmpresas = $this->fiscalesDAO->obtenerFiscalesEmpresas(); */
		  //Obtener los productos
		
		  $request = $this->getRequest();
		$formulario = new Contabilidad_Form_CrearImpuesto;
		$formulario->removeElement("abreviatura");
		$formulario->removeElement("descripcion");
		  $this->view->impuestosProducto = $this->productoDAO->obtenerProductos();
		  $this->view->formulario = $formulario;
    }

   

    public function enlazarproductoAction()
    {
        // action body
        /*//$impuestosDAO = $this->impuestoDAO;
		//$productosDAO = $this->productoDAO;
        $idImpuesto = $this->getParam("idImpuesto");
		$idProducto = $this->getParam("idProducto");
		//$importe = $this->getParam("importe");
		$importe = $this->getAllParams();
		$porcentaje = $this->getParam("porcentaje");*/
		$request = $this->getRequest();
		$formulario = new Contabilidad_Form_CrearImpuesto;
		$formulario->removeElement("abreviatura");
		$formulario->removeElement("descripcion");
	
		//$impuestoProducto =  new Contabilidad_Model_ImpuestoProductos($datos);
		
		/*$impuestos = $impuestosDAO->obtenerByImpuestos($idImpuesto);
		$productos = $impuestosDAO->obtenerByProductos($idProducto);
		
		$impuestosDAO->enlazarProductoImpuesto($impuestos["idImpuesto"],$productos["idProducto"]);*/
		print_r($idImpuesto);
		print_r($idProducto);
		print_r($importe);
		print_r($porcentaje);
    }


}











