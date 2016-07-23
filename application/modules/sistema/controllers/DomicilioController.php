<?php

class Sistema_DomicilioController extends Zend_Controller_Action
{
	private $domicilioDAO;
	private $estadoDAO;
	private $municipioDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->domicilioDAO = new Sistema_DAO_Domicilio;
		$this->estadoDAO = new Sistema_DAO_Estado;
		$this->municipioDAO = new Sistema_DAO_Municipio;
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
        // action body
        $formulario = new Sistema_Form_AltaDomicilio;
		$this->view->formulario = $formulario;
    }

    public function editaAction()
    {
        // action body
        $request = $this->getRequest();
		$idDomicilio = $this->getParam("idDomicilio");
		$domicilioModel = $this->domicilioDAO->obtenerDomicilio($idDomicilio);
		$municipio = $this->municipioDAO->obtenerMunicipio($domicilioModel->getIdMunicipio());
		//$estado = $this->estadoDAO->obtenerEstado($municipio->getIdEstado());
		$municipios = $this->municipioDAO->obtenerMunicipios($municipio->getIdEstado());
		//$municipios = $this->municipioDAO->obtenerMunicipios($domicilioModel->getIdEstado());
        $formulario = new Sistema_Form_AltaDomicilio;
		
		$formulario->getElement("idEstado")->setValue($municipio->getIdEstado());
		$formulario->getElement("idMunicipio")->clearMultiOptions();
		foreach ($municipios as $municipio) {
			$formulario->getElement("idMunicipio")->addMultiOption($municipio->getIdMunicipio(),$municipio->getMunicipio());
		}
		$formulario->getElement("idMunicipio")->setValue($domicilioModel->getIdMunicipio());
		$formulario->getElement("colonia")->setValue($domicilioModel->getColonia());
		$formulario->getElement("calle")->setValue($domicilioModel->getCalle());		
		$formulario->getElement("codigoPostal")->setValue($domicilioModel->getCodigoPostal());
		$formulario->getElement("numeroInterior")->setValue($domicilioModel->getNumeroInterior());
		$formulario->getElement("numeroExterior")->setValue($domicilioModel->getNumeroExterior());
		$formulario->getElement("submit")->setLabel("Actualizar");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		//$formulario->getElement("")->setValue($domicilioModel);
		
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}else{
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				unset($datos["idEstado"]);
				//$domicilio = new Sistema_Model_Domicilio($datos);
				try{
					$this->domicilioDAO->editarDomicilio($idDomicilio, $datos);
					$this->view->messageSuccess = "Domicilio editado exitosamente";
				}catch(Exception $ex){
					$this->view->messageFail = $ex->getMessage();
				}
			}
		}
		
		
    }


}





