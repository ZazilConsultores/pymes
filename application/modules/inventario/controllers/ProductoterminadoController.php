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
		$PT = $this->productoTerDAO->obtenerProductosTerminados();
		if($request->isGet()){
			$this->view->pt = $PT;	
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



