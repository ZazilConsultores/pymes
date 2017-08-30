<?php

class Contabilidad_DivisaController extends Zend_Controller_Action
{
	private $divisaDAO = null;

    public function init()
    {
        $this->divisaDAO = new Contabilidad_DAO_Divisa;
    }

    public function indexAction()
    {
    	$formulario = new Contabilidad_Form_AltaDivisa;
        $this->view->divisas = $this->divisaDAO->obtenerDivisas();
		$this->formulario = $formulario;
		
    }

    public function altaAction()
    {
        $request = $this->getRequest();
		$formulario = new Contabilidad_Form_AltaDivisa;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$divisa = new Contabilidad_Model_Divisa($datos);
				try{
					$this->divisaDAO->nuevaDivisa($divisa);
					$mensaje = "Divisa <strong>". $divisa->getDescripcion()."</stong> creado exitosamente";
					$this->view->messageSuccess = $mensaje;
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
			}
		}	
	}

    public function adminAction()
    {
        $idDivisa = $this->getParam("idDivisa");
		$divisa = $this->divisaDAO->obtenerDivisa($idDivisa);
		
		$formulario = new Contabilidad_Form_AltaDivisa;
		
		$formulario->getElement("descripcion")->setValue($divisa->getDescripcion());
		$formulario->getElement("claveDivisa")->setValue($divisa->getClaveDivisa());
		$formulario->getElement("tipoCambio")->setValue($divisa->getTipoCambio());
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		$formulario->getElement("submit")->setLabel("Actualizar");
		$this->view->divisa = $divisa;
		$this->view->formulario = $formulario;
		
    }

    public function editarAction()
    {
        $request = $this->getRequest();
		$idDivisa = $this->getParam("idDivisa");
		print_r($idDivisa);
		$datos = $request->getPost();
		unset($datos["submit"]);
		
		$this->divisaDAO->editaDivisa($idDivisa, $datos);
		/*$this->divisaDAO->editaDivisa($idDivisa, $datos);
		$this->_helper->redirector->gotoSimple("admin", "divisa", "contabilidad", array("idDivisa"=>$idDivisa));*/
		
    }


}







