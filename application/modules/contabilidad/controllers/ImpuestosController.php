<?php

class Contabilidad_ImpuestosController extends Zend_Controller_Action
{

    private $impuestoDAO = null;
    private $productoDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->impuestoDAO = new Contabilidad_DAO_Impuesto;
		$this->productoDAO = new Inventario_DAO_Producto;
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
    	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_CrearImpuesto;
		$idImpuesto = $this->getParam("idImpuesto");
		$this->view->formulario = $formulario;
		$formulario->removeElement("idImpuesto");
		$formulario->removeElement("idProducto");
		$formulario->removeElement("porcentaje");
		$formulario->removeElement("importe");
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$datos["fechaPublicacion"] = date ("Y-m-d H:i:s",time());
				//print_r($datos);
				try{
					$this->impuestoDAO->nuevoImpuesto($datos);
					$this->view->messageSuccess = "Impuesto dado de alta exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail =  "Error: <strong>".$ex->getMessage()."</strong>";
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
		$this->view->formulario = $formulario;
		$formulario->removeElement("idImpuesto");
		$formulario->removeElement("idProducto");
		$formulario->removeElement("porcentaje");
		$formulario->removeElement("importe");
		$formulario->getElement("abreviatura")->setValue($impuesto->getAbreviatura());
		$formulario->getElement("descripcion")->setValue($impuesto->getDescripcion());
		$formulario->getElement("estatus")->setValue($impuesto->getEstatus());
		$formulario->getElement("idEnlazarImpuesto")->setLabel("Actualizar");

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
    	$request = $this->getRequest();
		//Obtenemos el idProducto y el idImpuesto
		$idImpuesto = $this->getParam("idImpuesto");
		$idProducto = $this->getParam("idProducto");
		$formulario = new Contabilidad_Form_CrearImpuesto;
		$this->view->formulario = $formulario;
		$formulario->removeElement("abreviatura");
		$formulario->removeElement("descripcion");
		$formulario->removeElement("estatus");
		  
		if($request->isPost()){
			if($formulario->isValid($request->getPost()))
			{
				$datos = $formulario->getValues();
		   		$impuestoProducto = new Contabilidad_Model_ImpuestoProductos($datos);
				try{
		   			$this->impuestoDAO->enlazarProductoImpuesto($impuestoProducto, $idImpuesto, $idProducto);
				}catch(exception $ex){
					
				}
			}
    	}
    }

   

    public function enlazarproductoAction()
    {
        // action body
        $impuestosDAO = $this->impuestoDAO;
        $productosDAO = $this->productoDAO;
        $idImpuesto = $this->getParam("idImpuesto");
		$idProducto = $this->getParam("idProducto");
		/*
		//$importe = $this->getParam("importe");
		$importe = $this->getAllParams();
		$porcentaje = $this->getParam("porcentaje");*/
		$request = $this->getRequest();
		$formulario = new Contabilidad_Form_CrearImpuesto;
		$formulario->removeElement("abreviatura");
		$formulario->removeElement("descripcion");
	
		//$impuestoProducto =  new Contabilidad_Model_ImpuestoProductos($datos);
		
		$impuestos = $impuestosDAO->obtenerByImpuestos($idImpuesto);
		$productos = $impuestosDAO->obtenerByProductos($idProducto);
		
		$impuestosDAO->enlazarProductoImpuesto($impuestos["idImpuesto"],$productos["idProducto"]);
		//$impuestosDAO->enlazarProductoImpuesto($impuestoProducto, $impuestos ["idImpuesto"], $productos["idProducto"]);

		print_r($idImpuesto);
		print_r($idProducto);
		print_r($importe);
		print_r($porcentaje);
    }


}











