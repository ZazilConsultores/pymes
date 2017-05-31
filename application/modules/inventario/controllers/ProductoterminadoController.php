<?php

class Inventario_ProductoterminadoController extends Zend_Controller_Action
{

    private $productoTerminado = null;

    public function init()
    {
    	$this->productoTerminado =  new Inventario_DAO_Productoterminado;
    }

    public function indexAction()
    {
    	$productoTerminadoDAO = new Inventario_DAO_Productoterminado;
		
		$this->view->productos = $productoTerminadoDAO->obtenerProducto();
		$this->view->busquedaProductoTerminado = $productoTerminadoDAO->obtenerProductoTerminado();
    	
    	$formulario = new Inventario_Form_ProductoTerminado	;
		$this->view->formulario = $formulario;
        
    }

    public function crearAction()
    {
        // action body
        $formulario = new Inventario_Form_CrearProductoTerminado;
		$this->view->formulario = $formulario;
    }


}



