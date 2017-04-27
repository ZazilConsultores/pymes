<?php

class Contabilidad_JsonController extends Zend_Controller_Action
{
	private $bancoDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->bancoDAO = new Contabilidad_DAO_Banco;
    }

    public function indexAction()
    {
        // action body
    }

    public function bancosempresaAction()
    {
    	$idEmpresa = $this->getParam("emp");
		//print_r($idEmpresa);
		
		$bancosEmpresa = $this->bancoDAO->obtenerBancosEmpresa($idEmpresa);
		
		if(!is_null($bancosEmpresa)){
			echo Zend_Json::encode($bancosEmpresa);
		}else{
			echo Zend_Json::encode(array());
		}
    }


}



