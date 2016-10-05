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
    	
		$formulario = new Contabilidad_Form_AltaBanco;
		$this->view->bancos = $this->bancoDAO->obtenerBancos();
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
				//$this->bancoDAO->crearBanco($banco);
				//print_r($datos);
				try{
					$this->bancoDAO->crearBanco($banco);
					//print_r($subparametro->toArray());
					$mensaje = "Banco <strong>" . $banco->getBanco() . "</strong> creado exitosamente";
					$this->view->messageSuccess = $mensaje;
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}			
			}
			//$this->_helper->redirector->gotoSimple("index", "banco", "contabilidad");
		}
    }

    public function adminAction()
    {
        $idBanco = $this->getParam("idBanco"); //1
		$banco = $this->bancoDAO->obtenerBanco($idBanco);
	
		
		$formulario = new Contabilidad_Form_AltaBanco;
		
		$formulario->getElement("cuenta")->setValue($banco->getCuenta());
		$formulario->getElement("banco")->setValue($banco->getBanco());
		$formulario->getElement("cuentaContable")->setValue($banco->getCuentaContable());
		$formulario->getElement("tipo")->setValue($banco->getTipo());
		$formulario->getElement("fecha")->setValue($banco->getFecha());
		$formulario->getElement("saldo")->setValue($banco->getSaldo());

		$formulario->getElement("submit")->setLabel("Actualizar");
		
		//$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		$this->view->banco = $banco;
		$this->view->formulario = $formulario;
    }

    public function editaAction()
    {
        $request = $this->getRequest();
		$idBanco = $this->getParam("idBanco");
		$datos = $request->getPost();
		unset($datos["submit"]);
		
		$this->bancoDAO->editarBanco($idBanco, $datos);
		//print_r($datos);
		$this->_helper->redirector->gotoSimple("admin", "banco", "contabilidad", array("idBanco"=>$idBanco));
    }

		
    

}







