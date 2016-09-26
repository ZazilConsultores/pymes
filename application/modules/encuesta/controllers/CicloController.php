<?php

class Encuesta_CicloController extends Zend_Controller_Action
{
    private $cicloDAO = null;
	private $planDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->cicloDAO = new Encuesta_DAO_Ciclo;
		$this->planDAO = new Encuesta_DAO_Plan;
    }

    public function indexAction()
    {
        // action body
        $idPlan = $this->getParam("idPlan");
        $ciclos = $this->cicloDAO->obtenerCiclos($idPlan);
		$plan = $this->planDAO->obtenerPlanEstudios($idPlan);
        $this->view->ciclos = $ciclos;
		$this->view->plan = $plan;
    }

    public function adminAction()
    {
        // action body
        $idCiclo = $this->getParam("idCiclo");
		$ciclo = $this->cicloDAO->obtenerCiclo($idCiclo);
		
		$formulario = new Encuesta_Form_AltaCiclo;
		$formulario->getElement("ciclo")->setValue($ciclo["ciclo"]);
		$formulario->getElement("inicio")->setValue($ciclo["inicio"]);
		$formulario->getElement("termino")->setValue($ciclo["termino"]);
		$formulario->getElement("vigente")->setValue($ciclo["vigente"]);
		$formulario->getElement("descripcion")->setValue($ciclo["descripcion"]);
		$formulario->getElement("submit")->setLabel("Actualizar Ciclo");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->ciclo = $ciclo;
		$this->view->formulario = $formulario;
    }

    public function altaAction()
    {
        // action body
        $idPlan = $this->getParam("idPlan");
		$plan = $this->planDAO->obtenerPlanEstudios($idPlan);
        $request = $this->getRequest();
        $formulario = new Encuesta_Form_AltaCiclo;
		$this->view->formulario = $formulario;
		$this->view->plan = $plan;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				
				$inicio = new Zend_Date($datos["inicio"], 'yyyy-MM-dd hh-mm-ss');
				$termino = new Zend_Date($datos["termino"], 'yyyy-MM-dd hh-mm-ss');
				
				$datos["inicio"] = $inicio->toString('yyyy-MM-dd hh-mm-ss');
				$datos["termino"] = $termino->toString('yyyy-MM-dd hh-mm-ss');
				$datos["idPlanEducativo"] = $idPlan;
				
				try{
					$this->cicloDAO->crearCiclo($datos);
					$this->view->messageSuccess = "Ciclo Escolar: <strong>".$datos["ciclo"]. "</strong> dato de alta efectivamente." ;
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
				
			}
		}
    }

    public function editaAction()
    {
        // action body
    }


}







