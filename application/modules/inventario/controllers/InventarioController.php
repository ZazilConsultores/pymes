<?php

class Inventario_InventarioController extends Zend_Controller_Action
{
	private $inventarioDAO;
    public function init()
    {
    	$this->inventarioDAO = new Inventario_DAO_Inventario;
    }

    public function indexAction()
    {
        $inventarioDAO = $this->inventarioDAO;
		$this->view->inventario = $inventarioDAO->obtenerInventario();
	
	}

    public function adminAction()
    {
        // action body
    }

    public function editaAction()
    {
        // action body
    }
}





