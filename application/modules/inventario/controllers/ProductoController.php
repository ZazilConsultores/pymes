<?php

class Inventario_ProductoController extends Zend_Controller_Action
{

    private $productoDAO = null;
	private $subparametroDAO = null;
	private $parametroDAO = null;

    public function init()
    {
        /* Initialize action controller here */	
        $this->productoDAO = new Inventario_DAO_Producto;
        $this->subparametroDAO = new Sistema_DAO_Subparametro;
		$this->parametroDAO = new Inventario_DAO_Parametro;
    }

    public function indexAction()
    {
        $productoDAO = $this->productoDAO;
		$this->view->productos = $productoDAO->obtenerProductos();
    }

    public function altaAction()
    {
    	$subparametroDAO = new Sistema_DAO_Subparametro;
		
        $request = $this->getRequest();
		$idProducto = $this->getParam("idProducto");
		$formulario = new Inventario_Form_AltaProducto;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
		
				$producto = new Inventario_Model_Producto($datos);
				$producto->setClaveProducto($subparametroDAO->generarClaveProducto($datos['0']));
				$producto->setIdsSubparametros($subparametroDAO->generarIdsSubparametros($datos['0']));
				//$producto->setIdsSubparametros($subparametroDAO->generarIdsSubparametros($datos['Configuracion']));
				//print_r($subparametroDAO->generarIdsSubparametros($datos['Configuracion']));
				try{
					$this->productoDAO->crearProducto($producto);
					$this->view->messageSuccess = "Se ha agregado el producto: <strong>".$producto->getProducto()."</strong> exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = "Error: <strong>".$ex->getMessage()."</strong>";
				}
				
				//$this->_helper->redirector->gotoSimple("index", "producto", "inventario");
			}
		}
		
    }

    public function adminAction()
    {
      
		$idProducto = $this -> getParam("idProducto");
		$producto = $this -> productoDAO ->obtenerProducto($idProducto);

		$formulario = new Inventario_Form_AltaProducto;
		$formulario->getElement("claveProducto")->setValue($producto->getClaveProducto());
		$formulario->getElement("producto")->setValue($producto->getProducto());
		$formulario -> getElement("submit")->setAttrib("class", "btn btn-warning");
		$formulario -> getElement("submit")->setLabel("Actualizar Producto");
		
		$this -> view -> producto = $producto;
		$this -> view -> formulario = $formulario;	
	 }

    public function bajaAction()
    {
        // action body
    }

    public function editaAction()
    {
    	$request = $this->getRequest();
		
		$idProducto= $this->getParam("idProducto");
		$producto = $this->productoDAO->obtenerProducto($idProducto);
		$subparametro = $this->subparametroDAO->obtenerSubparametroProducto($idProducto);
		
		$formulario = new Inventario_Form_EditaProducto;
		//$formulario->getElement("producto")->setValue($subparametro->getIdSubparametro());
		$formulario->getElement("producto")->setValue($producto->getProducto());
		//$formulario->getElement("codigoBarras")->setValue($producto->getCodigoBarras());
		$formulario->getElement("submit")->setLabel("Actualizar Producto");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->producto = $producto;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				/*$datos = $formulario->getValues();
				//print_r($datos);
				$producto = new Inventario_Model_Producto($datos);
				$producto->setClaveProducto($this->subparametroDAO->generarClaveProducto($datos['0']));
				$producto->setIdsSubparametros($this->subparametroDAO->generarIdsSubparametros($datos['0']));
				$arrProducto = $producto->toArray();
				unset($arrProducto["idProducto"]);
				
				try{
					$this->productoDAO->editarProducto($idProducto, $arrProducto);
					$this->view->messageSuccess = "El producto: <strong>".$producto->getProducto()."</strong> ha sido actualizado exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = "El producto: <strong>".$producto->getProducto()."</strong>  no se pudo actualizar. Error: <strong>".$ex->getMessage()."</strong>";
				}
				//print_r("<br /><br />");
				//print_r($producto->toArray());*/
			}
		}
		
		
    }
}









