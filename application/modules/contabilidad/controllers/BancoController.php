<?php

class Contabilidad_BancoController extends Zend_Controller_Action
{
	private $bancoDAO = null;
	private $divisaDAO = null;
	

    public function init()
    {
        /* Initialize action controller here */
        $this->bancoDAO = new Inventario_DAO_Banco;
    }

    public function indexAction()
    {
    	//Creo un formulario de Alta de Estado
		$formulario = new Contabilidad_Form_AltaBanco;
		
		//Obtengo lista de estados y los envio a la vista
		$this->view->bancos = $this->bancoDAO->obtenerBancos();
		//Envio a la vista el formulario de Alta de Estado, si el usuario lo llega se recibe la informacion en altaAction
		$this->view->formulario = $formulario;	
			
    	
    	//$tablaBanco = new Contabilidad_Model_DbTable_Banco();
		//$this->bancoDAO->obtenerBancos();
    }

    public function altaAction()
    {
       	$request = $this->getRequest();
		$formulario = new Contabilidad_Form_AltaBanco;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$banco = new Contabilidad_Model_Banco($datos);
				$this->bancoDAO->crearBanco($banco);
				print_r($datos);
			}
			$this->_helper->redirector->gotoSimple("index", "banco", "contabilidad");
			}
		}
 }



