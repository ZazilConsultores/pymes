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

    public function editarAction()
    {
    	$idProdComp = $this->getParam("idProdComp");
		print_r($idProdComp);
		$productoCom = $this->productoTerDAO->obtenerProducCom($idProdComp);
		$desproducto= $this->productoTerDAO->obtenerIdProducto($idProdComp);
		$this->view->desproducto = $desproducto;
    	//$idPC = $this->getParam("idProductoCompuesto");
		//$productoCompuesto = $this->productoTerDAO->obtenerProductoTerminado($idPC);  
    }

    public function eliminarAction()
    {
        // action body
    }


}







