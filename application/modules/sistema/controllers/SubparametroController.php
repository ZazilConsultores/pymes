<?php

class Sistema_SubparametroController extends Zend_Controller_Action
{

    private $subParametrosDAO = null;

    private $parametroDAO = null;

    public function init()
    {
    	$this->subParametrosDAO = new Sistema_DAO_Subparametro;
		$this->parametroDAO = new Inventario_DAO_Parametro;

    }

    public function indexAction()
    {
    	$idParametro = $this->getParam("idParametro");
		$formulario = new Sistema_Form_AltaSubparametro;
		$this->view->subparametros = $this->subParametrosDAO->obtenerSubparametros($idParametro);
     	
     	$this->view->formulario = $formulario;
        $this->view->parametro = $this->parametroDAO->obtenerParametro($idParametro);
	
    }

    public function altaAction()
    {
    	
        $request = $this->getRequest();
		$idParametro = $this->getParam("idParametro");
		$formulario = new Sistema_Form_AltaSubparametro;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$subparametro = new Sistema_Model_Subparametro($datos[0]);
				$subparametro->setIdParametro($idParametro);
				//print_r($datos);		
				//subparametro->setClaveSubparametro($claveSubparametro);
				//$subparametro->setHash($subparametro->getHash());
				//$subparametro->setFecha(date("Y-m-d H:i:s", time()));		
				try{
					$this->subParametrosDAO->crearSubparametro($subparametro);
					//print_r($subparametro->toArray());
					$mensaje = "SubParametro <strong>" . $subparametro->getSubParametro() . "</strong> creado exitosamente";
					$this->view->messageSuccess = $mensaje;
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}			
			}
		}	
    }

    public function adminAction()
    {
    	$idSubparametro = $this->getParam("idSubparametro");
		$subParametro = $this->subParametrosDAO->obtenerSubparametro($idSubparametro);
		$this->view->subParametro = $subParametro;
		
		$formulario = new Sistema_Form_AltaSubparametro;
		$formulario->getSubForm("0")->getElement("subparametro")->setValue($subParametro->getSubparametro());
		$formulario->getSubForm("0")->getElement("claveSubparametro")->setValue($subParametro->getClaveSubparametro());
		$formulario->getElement("submit")->setLabel("Actualizar Subparametro");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->formulario = $formulario;
	}

    public function bajaAction()
	    {
        // action body
    }

    public function editaAction()
    {
    	$idSubparametro = $this->getParam("idSubparametro");
		
		$datos = $this->getRequest()->getPost();
		unset($datos["submit"]);
		
		$this->subParametrosDAO->editarSubparametro($idSubparametro, $datos);
		
		
		$this->_helper->redirector->gotoSimple("admin", "subparametro", "sistema", array("idSubparametro"=>$idSubparametro));
    	
    }
}









