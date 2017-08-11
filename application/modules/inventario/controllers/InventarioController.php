<?php

class Inventario_InventarioController extends Zend_Controller_Action
{

    private $inventarioDAO = null;

    private $productoDAO = null;

    public function init()
    {
    	$this->inventarioDAO = new Inventario_DAO_Inventario;  
		$this->productoDAO = new Inventario_DAO_Producto;
    }

    public function indexAction()
    {
        $inventarioDAO = $this->inventarioDAO;
		$this->view->inventario = $inventarioDAO->obtenerInventario();
	
    }

    public function adminAction()
    {
    	$request = $this->getRequest();
        $idInventario = $this->getParam("idInventario");
		$inventario = $this->inventarioDAO->obtenerProductoInventario($idInventario);
		$formulario = new Inventario_Form_AdminInventario;
		$formulario->getElement("minimo")->setValue($inventario->getMinimo());
		$formulario->getElement("maximo")->setValue($inventario->getMaximo());
		$formulario->getElement("costoUnitario")->setValue($inventario->getCostoUnitario());
		$formulario->getElement("porcentajeGanancia")->setValue($inventario->getPorcentajeGanancia());
		$formulario->getElement("cantidadGanancia")->setValue($inventario->getCantidadGanancia());
		$formulario->getElement("costoCliente")->setValue($inventario->getCostoCliente());
		$formulario->getElement("submit")->setLabel("Actualizar Producto");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->inventario = $inventario;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				
				try{
					$this->inventarioDAO->editarInventario($idInventario, $datos);
				}catch(Exception $ex){
				}
				
			}
		}
    }

    public function editaAction()
    {
    	$request = $this->getRequest();
    	$idInventario = $this->getParam("idInventario");
		//$inventario = $this->inventarioDAO->obtenerProductoInventario($idInventario);
		/*if($request->isPost()){
			if($inventario = $this->getRequest()->getPost()){
				$this->inventarioDAO->editarInventario($idInventario, $inventario);
			}
		}*/
		//$this->_helper->redirector->gotoSimple("admin", "inventario", "inventario");
		//$inventario = $this->getRequest()->getPost();
		//unset($inventario["submit"]);
		$inventario = $this->getRequest()->getPost();
		unset($inventario["submit"]);
		
		//print_r($inventario);	
		$this->inventarioDAO->editarInventario($idInventario, $inventario);
		
		//$this->_helper->redirector->gotoSimple("admin", "inventario", "inventario",$idInventario);
		
    }

    public function editartodoAction()
    {
        // action body
       /* $inventarioDAO = $this->inventarioDAO;
		$this->view->inventario = $inventarioDAO->editarTodo($inventario);
		$formulario = new Inventario_Form_AdminInventario;
		
		/*$formulario->getElement("minimo")->setValue(0);
		$formulario->getElement("maximo")->setValue(0);
		$formulario->getElement("costoUnitario")->setValue(0);
		$formulario->getElement("porcentajeGanancia")->setValue(0);
		$formulario->getElement("cantidadGanancia")->setValue(0);
		$formulario->getElement("costoCliente")->setValue(0);
			
		
		//$this -> view -> inventario = $inventario;
		$this -> view -> formulario = $formulario;
		
	}    */
	$request = $this->getRequest();
		$formulario = new Inventario_Form_EditarTodoInventario;
		$formulario->getElement("minimo")->setValue(0);
		$formulario->getElement("maximo")->setValue(0);
		$formulario->getElement("porcentajeGanancia")->setValue(0);
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				print_r($datos);
				
				$this->inventarioDAO->editarTodo($datos);		
			}
		}
	}
}









