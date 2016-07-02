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
        $idInventario = $this -> getParam("idInventario");
	
	
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
		
		
		$this -> view -> inventario = $inventario;
		$this -> view -> formulario = $formulario;
    }

    public function editaAction()
    {
        // action body
        $idInventario = $this->getParam("idInventario");
		
		$datos = $this->getRequest()->getPost();
		unset($datos["submit"]);
			
		$this->inventarioDAO->editarInventario($idInventario, $datos);

		
		$this->_helper->redirector->gotoSimple("admin", "inventario", "inventario", array("idInventario"=>$idInventario));
    }
}





