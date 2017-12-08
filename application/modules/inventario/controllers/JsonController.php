<?php

class Inventario_JsonController extends Zend_Controller_Action
{

    private $unidadDAO = null;
	private $productoDAO = null;
	private $productoTermindoDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$this->unidadDAO = new Inventario_DAO_Unidad;
		$this->productoDAO = new Inventario_DAO_Producto;
		$this->productoTermindoDAO = new Inventario_DAO_Productoterminado;
    }

    public function indexAction()
    {
        // action body
    }

    public function unidadesAction()
    {
        // action body
        $idUnidad = $this->getParam("idUnidad");
       	$unidades = $this->unidadDAO->obtenerUnidad($idUnidad);
		
		$arrayUnidades = array();
		
		foreach ($unidades as $unidad) {
			$arrayUnidades[] = array("idUnidad"=>$unidad->getIdUnidad(), "unidad"=>$unidad->getAbreviatura());
		}
		echo Zend_Json::encode($arrayUnidades);
    }
	
	public function multiplosAction()
    {
        // action body
        $idProducto = $this->getParam("idProducto");
		//print_r($idProducto);
       	$multiplos = $this->unidadDAO->obtenerMultiplos($idProducto);

		if(!is_null($multiplos)){
			echo Zend_Json::encode($multiplos);
		}else{
			echo Zend_Json::encode(array());
		}
    }
	
	public function productosAction()
    {
        // action body
        $idProducto = $this->getParam("idProducto");
		//print_r($idProducto);
       	$productos= $this->productoDAO->getProducto($idProducto);

		if(!is_null($productos)){
			echo Zend_Json::encode($productos);
		}else{
			echo Zend_Json::encode(array());
		}
    }
    
	public function productoterminadoAction()
    {
        // action body
        $idProductoTerminado = $this->getParam("productoTerminado");
       	$productoTer= $this->productoTermindoDAO->obtenerProductoTerminado($idProductoTerminado);
		
		if(!is_null($productoTer)){
			echo Zend_Json::encode($productoTer);
		}else{
			echo Zend_Json::encode(array());
		}
    }
	public function llenaproductoAction()
    {
        // action body
        $idPC = $this->getParam("idPC");
       	$productoC= $this->productoTermindoDAO->obtieneProductoTerminado($idPC);
		
		if(!is_null($productoC)){
			echo Zend_Json::encode($productoC);
		}else{
			echo Zend_Json::encode(array());
		}
    }


}



