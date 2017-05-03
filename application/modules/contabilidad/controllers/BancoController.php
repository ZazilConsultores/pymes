<?php

class Contabilidad_BancoController extends Zend_Controller_Action
{

    private $bancoDAO = null;

    private $divisaDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->bancoDAO = new Contabilidad_DAO_Banco;
	
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
		$formulario->removeElement("idEmpresa");
		$formulario->removeElement("idSucursal");
		$formulario->removeElement("idBanco");
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				try{
					$this->bancoDAO->crearBanco($datos);
					//print_r($subparametro->toArray());
					$mensaje = "Banco <strong>" . $datos["banco"] . "</strong> creado exitosamente";
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
       
    }

    public function editaAction()
    {
    	$idBanco = $this->getParam("idBanco");
		$banco = $this->bancoDAO->obtenerBanco($idBanco);
		
		$formulario = new Contabilidad_Form_AltaBanco;
		$formulario->removeElement("idEmpresa");
		$formulario->removeElement("idSucursal");
		$formulario->removeElement("idBanco");
		$formulario->getElement("cuenta")->setValue($banco->getCuenta());
		$formulario->getElement("banco")->setValue($banco->getBanco());
		$formulario->getElement("cuentaContable")->setValue($banco->getCuentaContable());
		$formulario->getElement("tipo")->setValue($banco->getTipo());
		$formulario->getElement("saldo")->setValue($banco->getSaldo());
		$formulario->getElement("submit")->setLabel("Actualizar");
		$this->view->banco = $banco;
		$this->view->formulario = $formulario;
		$request = $this->getRequest();
       	if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos=$formulario->getValues();
				try{
					$this->bancoDAO->editarBanco($idBanco, $datos);
					$this->view->messageSuccess = "Banco se han actualizado correctamente!!";
				}catch(Exception $ex){
					$this->view->messageFail = "No se pudo actualizar Error: <strong>".$ex->getMessage()."</strong>";
				}
			}
		}
    }

    /*public function enlazaAction()
    {
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				unset($datos["idSucursal"]);
				$idEmpresa = $datos["idEmpresa"];
				$idBanco = $datos["idBanco"];
				try{
					$this->bancoDAO->altaBancoEmpresa($idEmpresa, $idBanco);
					//print_r($subparametro->toArray());
					$mensaje = "Banco <strong>" . $datos["idEmpresa"] . "</strong> creado exitosamente";
					$this->view->messageSuccess = $mensaje;
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}			
			}
			//$this->_helper->redirector->gotoSimple("index", "banco", "contabilidad");
		}
    }*/

    public function enlazarAction()
    {
        $request = $this->getRequest();
		$idEmpresa = $this->getParam("idEmpresa");
		$idBanco = $this->getParam("idBanco");
		$formulario = new Contabilidad_Form_AltaBanco;
		$this->view->formulario = $formulario;
		$formulario->removeElement("cuenta");
		$formulario->removeElement("banco");
		$formulario->removeElement("idDivisa");
		$formulario->removeElement("tipo");
		$formulario->removeElement("cuentaContable");
		$formulario->removeElement("saldo");
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//$bancosEmpresa = new Contabilidad_Model_BancosEmpresa($datos);
				try{
					$this->bancoDAO->altaBancoEmpresa($idEmpresa, $idBanco);
				}catch(exception $ex){
					
				}			
			}
		}
    }


}









