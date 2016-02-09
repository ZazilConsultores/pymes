<?php

class Consulta_MovimientosController extends Zend_Controller_Action
{
	 public $links = array(
        'Inicio prueba' => array(
            'module' => 'consulta',
            'controller' => 'movtos',
            'action' => 'index'
            ),
        'Empresa - Cliente' => array(
            'module' => 'consulta',
            'controller' => 'movtos',
            'action' => 'index',
            'tipo' => '1'
            ),
        'Empresas - Cliente' => array(
            'module' => 'consulta',
            'controller' => 'movtos',
            'action' => 'index',
            'tipo' => '2'
            ),
        'Empresas - Clientes' => array(
            'module' => 'consulta',
            'controller' => 'movtos',
            'action' => 'index',
            'tipo' => '3'
            ),
        'Empresa - Proveedor' => array(
            'module' => 'consulta',
            'controller' => 'movtos',
            'action' => 'index',
            'tipo' => '4'
            ),
        'Empresas - Proveedor' => array(
            'module' => 'consulta',
            'controller' => 'movtos',
            'action' => 'index',
            'tipo' => '5'
            ),
        'Empresas - Proveedores' => array(
            'module' => 'consulta',
            'controller' => 'movtos',
            'action' => 'index',
            'tipo' => '6'
            )
        );
	

    public function init()
    {
        /* Initialize action controller here */
        		
		$this->formatter = new NumberFormatter('es_MX', NumberFormatter::CURRENCY);
		$this->view->links = $this->links;
        
    }

    public function indexAction()
    {
        // action body
    }


}

