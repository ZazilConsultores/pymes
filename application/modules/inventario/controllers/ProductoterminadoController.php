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
			$datosf = $request->getPost();
			print_r($datosf);
			$datos = json_decode($datosf['datos'], TRUE);
				print_r($datos);
				print_r("<br />");
			$this->productoTerDAO->crearProductoTerminado($datos);
		}
        
    }

    public function crearAction()
    {
    	
    }

    public function editarAction()
    {
    	$request = $this->getRequest();
    	$idProdComp = $this->getParam("idProdComp");
		$desproducto= $this->productoTerDAO->obtenerIdProducto($idProdComp);
		$producto = $this->productoTerDAO->obtieneProductoTerminado($idProdComp);
		$multiplos = $this->productoTerDAO->obtenerMultiploProdCom($idProdComp);
		
		$this->view->desproducto = $desproducto;
		$this->view->producto = $producto;
		$this->view->multiplos = $multiplos;
		
		if($request->isPost()){		
			$datos = $request->getPost();
			print_r($datos);
			$this->productoTerDAO->editarProdCom($idProdComp, $datos);
			$this->_helper->redirector->gotoSimple("index", "productoterminado", "inventario");
		}
    }

    public function eliminarAction()
    {
    	$request = $this->getRequest();
    	$idProdComp = $this->getParam("idProdComp");
		print_r($idProdComp);
		$this->productoTerDAO->eliminarProdCom($idProdComp);
    }


}







