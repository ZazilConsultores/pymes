<?php

class Consulta_FiscalesController extends Zend_Controller_Action
{
	private $fiscalesDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->fiscalesDAO = new Inventario_DAO_Fiscales;
    }

    public function indexAction()
    {
        // action body
        $idFiscales = $this->getParam("idFiscales");
		//if(is_null($idFiscales)) $this->redirect(array());
		
		$fiscales = $this->fiscalesDAO->obtenerFiscales($idFiscales);
		$this->view->fiscales = $fiscales;
		
    }


}

