<?php

class Inventario_JsonController extends Zend_Controller_Action
{

    private $unidadDAO = null;

    private $productoDAO = null;

    private $productoTermindoDAO = null;

    private $inventarioDAO = null;

    private $cardexoDAO = null;
    
    private $descuentoDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$this->unidadDAO = new Inventario_DAO_Unidad;
		$this->productoDAO = new Inventario_DAO_Producto;
		$this->productoTermindoDAO = new Inventario_DAO_Productoterminado;
		$this->inventarioDAO = new Inventario_DAO_Inventario;
		$this->cardexoDAO = new Inventario_DAO_Cardex;
		$this->descuentoDAO = new Contabilidad_DAO_Descuentos;
    }

    public function indexAction()
    {
        // action body
    }

    public function unidadesAction()
    {
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
        $idPC = $this->getParam("idPC");
       	$productoC= $this->productoTermindoDAO->obtieneProductoTerminado($idPC);
		
		if(!is_null($productoC)){
			echo Zend_Json::encode($productoC);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function productoxmovimientoAction()
    {
    	$idSucursal = $this->getParam("idSucursal");
       	$productoMovto= $this->inventarioDAO->obtenerProductoxMovto($idSucursal);
		
		if(!is_null($productoMovto)){
			echo Zend_Json::encode($productoMovto);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function productoxsucursalAction()
    {
    	$idProducto = $this->getParam("idProducto");
       	$obtenerProducto= $this->inventarioDAO->obtenerMovtoxproducto($idProducto);
		
		if(!is_null($obtenerProducto)){
			echo Zend_Json::encode($obtenerProducto);
		}else{
			echo Zend_Json::encode(array());
		}
    }

    public function eliminarproductoenlazadoAction()
    {
        $idProdComp = $this->getParam("productoCompuesto");
        //$obtenerProducto = $this->inventarioDAO->obtenerMovtoxproducto($idProducto);
        $eliminarProdComp  = $this->productoTermindoDAO->eliminarProdCom($idProdComp);
        if(!is_null($eliminarProdComp)){
            echo Zend_Json::encode($eliminarProdComp);
        }else{
            echo Zend_Json::encode(array());
        }
    }

    public function obtienecardexAction()
    {
        $idSucursal= $this->getParam("suc");
        $idProducto= $this->getParam("prod");

        $cardex  = $this->cardexoDAO->obtenerIdProductoCardex($idSucursal, $idProducto);
        if(!is_null($cardex)){
            echo Zend_Json::encode($cardex);
        }else{
            echo Zend_Json::encode(array());
        }
        
    }

    public function obtenerdescuentoAction()
    {
        $idDescuento= $this->getParam("de");
       
        $desc = $this->descuentoDAO->obtenerDescuento($idDescuento);
        if(!is_null($desc)){
            echo Zend_Json::encode($desc);
        }else{
            echo Zend_Json::encode(array());
        }
        
    }


}





















