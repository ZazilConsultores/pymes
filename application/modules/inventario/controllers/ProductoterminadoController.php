<?php

class Inventario_ProductoterminadoController extends Zend_Controller_Action
{

    private $productoTerDAO = null;

    public function init()
    {
		$this->productoTerDAO =  new Inventario_DAO_Productoterminado;
    }

    public function indexAction()
    {
    	$request = $this->getRequest();
    	$productoTerminadoDAO = new Inventario_DAO_Productoterminado;
		
		$productos = $this->view->productos = $productoTerminadoDAO->obtenerProducto();
		$this->view->busquedaProductoTerminado = $productoTerminadoDAO->obtenerProductosTerminados();
    	
    	/**$formulario = new Inventario_Form_CrearProductoTerminado;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				$envio = json_decode($datos['datos'],TRUE);
				print_r($envio);
				try{
					$this->productoTerDAO->crearProductoTerminado($envio);
					$this->view->messageSuccess = "El producto terminado fue creado exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = "Error al crear el producto terminado";
				}
			}		
		}*/
		if($request->isGet()){
			$this->view->productos = $produstos;	
		}if($request->isPost()){		
			$datos = $request->getPost();
			print_r($datos);
		}
        
    }

    public function crearAction()
    {
        /*$request = $this->getRequest();
        $formulario = new Inventario_Form_CrearProductoTerminado;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				print_r($datos);
				$envio = json_decode($datos['datos'],TRUE);
				print_r($envio);
			}else{
				print_r("El formulario no valido <br />");
			}
		}*/
    }


}



