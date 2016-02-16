<?php

class Sistema_SubparametroController extends Zend_Controller_Action
{
	private $subParametrosDAO;
	private $parametroDAO;
	

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
				//$subparametro->setHash($subparametro->getHash());
				//$subparametro->setFecha(date("Y-m-d H:i:s", time()));		
				try{
					$this->subParametrosDAO->crearSubparametro($subparametro);
					//print_r($subparametro->toArray());
					//$mensaje = "SubParametro <strong>" . $subparametro->getSubParametro() . "</strong> creado exitosamente";
					$this->view->messageSuccess = $mensaje;
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
			}
		}
	
			
	}

}



