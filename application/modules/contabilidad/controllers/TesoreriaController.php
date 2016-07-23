<?php

class Contabilidad_TesoreriaController extends Zend_Controller_Action
{
	private $fondeoDAO = null;
	private $subparametroDAO =null;

    public function init()
    {
        /* Initialize action controller here */
         $this->fondeoDAO = new Contabilidad_DAO_Fondeo;
		 $this->subparametroDAO = new Sistema_DAO_Subparametro;
    }

    public function indexAction()
    {
        // action body
    }

    public function fondeoAction()
    {
      /* 	$fondeDAO = $this->fondeoDAO;
		$idEmpresa = 1;
		//$select =$fondeDAO->obtenerBancosEmpresas();
		$select = $fondeDAO->obtenerBancosEmpresas($idEmpresa);
		
		$this->view->select = $select;**/
		
		/*$subparmetrosDAO = $this->subparametroDAO;
		$idParametro =1;
		$select = $subparmetrosDAO->obtenerSubparametros($idParametro);
		$this->view->select = $select;*/
				
		$select = new Contabilidad_Form_AgregarFondeo;
		$this->view->select = $select;
    }

    public function inversionesAction()
    {
        $formulario = new Contabilidad_Form_AgregarInversiones;
		$this->view->formulario = $formulario;
    }

    public function nominaAction()
    {
    	
    }

    public function impuestosAction()
    {
        // action body
    }


}









