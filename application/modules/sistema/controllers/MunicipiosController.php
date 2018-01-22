<?php

class Sistema_MunicipiosController extends Zend_Controller_Action
{
	private $municipiosDAO;
	private $estadoDAO;
	
    public function init()
    {
        /* Initialize action controller here */
        $this->municipiosDAO = new Sistema_DAO_Municipio;
		$this->estadoDAO = new Sistema_DAO_Estado;
    }

    public function indexAction()
    {
    	// action body
        //Creo un formulario de Alta de Municipio
        $idEstado = $this->getParam("idEstado");
		$formulario = new Sistema_Form_AltaMunicipio;
		//Obtengo lista de estados y los envio a la vista
		$this->view->municipios = $this->municipiosDAO->obtenerMunicipios($idEstado);
		//Envio a la vista el formulario de Alta de Estado, si el usuario lo llega se recibe la informacion en altaAction
		$this->view->formulario = $formulario;
		$this->view->estado = $this->estadoDAO->obtenerEstado($idEstado);
		
    }

    public function altaAction()
    {
        //$formulario = new Sistema_Form_AltaMunicipio;
		//$this->view->formulario = $formulario;
    	$request = $this->getRequest();
		$idEstado = $this->getParam("idEstado");
		$formulario = new Sistema_Form_AltaMunicipio;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$municipio = new Sistema_Model_Municipio($datos);
				$this->municipiosDAO->crearMunicipio($municipio);
				$this->_helper->redirector->gotoSimple("index", "municipios", "sistema", array("idEstado"=>$idEstado));
			}
		}else{
			$this->_helper->redirector->gotoSimple("index", "municipios", "sistema");
		}
    }
    

    public function adminAction()
    {
    	$idMunicipio = $this->getParam("idMunicipio");
		$municipio = $this->municipiosDAO->obtenerMunicipio($idMunicipio);
		
		$formulario = new Sistema_Form_AltaMunicipio;
		$formulario->getElement("claveMunicipio")->setValue($municipio->getClaveMunicipio());
		$formulario->getElement("municipio")->setValue($municipio->getmunicipio());
		$formulario->getElement("agregar")->setLabel("Actualizar");
		
		$this->view->municipio = $municipio;
		$this->view->formulario = $formulario;
    }

    public function bajaAction()
    {
        // action body
    }

    public function editaAction()
    {
        $request = $this->getRequest();
        $idMunicipio = $this->getParam("idMunicipio");
         if($request->isPost()){
            $datos = $request->getPost();
            //print_r($datos);
           
            $this->municipiosDAO->editarMunicipio($idMunicipio, $datos);
            
            
        }
    }


}









