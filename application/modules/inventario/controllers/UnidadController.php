<?php

class Inventario_UnidadController extends Zend_Controller_Action {
	private $unidadDAO;
	private $multiploDAO;

	public function init() {
		$this -> unidadDAO = new Inventario_DAO_Unidad;
		$this -> multiploDAO = new Inventario_DAO_Multiplo;
	}

	public function indexAction() {
		$formulario = new Inventario_Form_AltaUnidad;
		
		$this->view->unidad = $this->unidadDAO->obtenerUnidades();
		
		$this->view->formulario = $formulario;

	}

	public function adminAction() {
		$idUnidad = $this -> getParam("idUnidad");
		$unidad = $this -> unidadDAO -> obtenerUnidad($idUnidad);

		$formulario = new Inventario_Form_AltaUnidad;
		$formulario -> getSubForm("0") -> getElement("unidad") -> setValue($unidad -> getUnidad());
		$formulario -> getSubForm("0") -> getElement("abreviatura") -> setValue($unidad -> getAbreviatura());
		$formulario -> getElement("submit") -> setLabel("Actualizar");
		$formulario -> getElement("submit") -> setAttrib("class", "btn btn-warning");

		$this -> view -> unidad = $unidad;
		$this -> view -> formulario = $formulario;
	}

	public function altaAction() {
			
		$request = $this->getRequest();
		$idUnidad = $this->getParam("idUnidad");
		$formulario = new Inventario_Form_AltaUnidad;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$unidad = new Inventario_Model_Unidad($datos[0]);
				//print_r($datos[0]);
				//print_r('<br />');
				//print_r($unidad->toArray());
				try{
					$this->unidadDAO->crearUnidad($unidad);
					$mensaje = "Unidad <strong>" . $unidad->getUnidad() . "</strong> creado exitosamente";
					$this->view->messageSuccess = $mensaje;
					
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();		
				}
			}			
		}	

	}

	public function bajaAction() {
		// action body
	}

	public function editaAction() {
		
		$idUnidad = $this->getParam("idUnidad");
		
		$datos = $this->getRequest()->getPost();
		unset($datos["submit"]);
		
		$this->unidadDAO->editarUnidad($idUnidad, $datos);
		
		
		$this->_helper->redirector->gotoSimple("admin", "unidad", "inventario", array("idUnidad"=>$idUnidad));
    	
		}
}
