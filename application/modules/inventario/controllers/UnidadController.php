<?php

class Inventario_UnidadController extends Zend_Controller_Action
{
	private $unidadDAO;
	private $multiploDAO;

    public function init()
    {
        $this->unidadDAO = new Inventario_DAO_Unidad;
		$this->multiploDAO = new Inventario_DAO_Multiplo;
    }

    public function indexAction()
    {
        $idMultiplo = $this->getParam("idMultiplos");
		$formulario = new Inventario_Form_AltaUnidad;
		//Obtengo lista de unidad y los envio a la vista
		$this->view->unidades = $this->unidadDAO->obtenerUnidades($idMultiplo);
		
		$this->view->formulario = $formulario;
		$this->view->Multiplos = $this->multiploDAO->obtenerMultiplo($idMultiplos);

    }

    public function adminAction()
    {
       	$idUnidad = $this->getParam("idUnidad");
		$unidad = $this->unidadDAO->obtenerUnidad($idUnidad);
		
		
		$formulario = new Inventario_Form_AltaUnidad;
		$formulario->getSubForm("0")->getElement("unidad")->setValue($unidad->getUnidad());
		$formulario->getSubForm("0")->getElement("abreviatura")->setValue($unidad->getAbrevitura());
		$formulario->getElement("submit")->setLabel("Actualizar");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->unidad = $unidad;
		$this->view->formulario = $formulario;
    }

    public function altaAction()
    {
        // action body
    }

    public function bajaAction()
    {
        // action body
    }

    public function editaAction()
    {
        // action body
    }


}









