<?php

class Encuesta_PlanController extends Zend_Controller_Action
{
	private $planDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->planDAO = new Encuesta_DAO_Plan;
    }

    public function indexAction()
    {
        // action body
        $planes = $this->planDAO->obtenerPlanesDeEstudio();
		$this->view->planes = $planes;
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Encuesta_Form_AltaPlan;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$plan = $formulario->getValues();
				try{
					$this->planDAO->agregarPlanEstudios($plan);
					$this->view->messageSuccess = "Plan de estudios: <strong>".$plan["planEducativo"]."</strong> dado de alta exitosamente.";
				}catch(Exception $ex){
					$this->view->messageFail = $ex->getMessage();
				}
				
			}
		}
    }

    public function adminAction()
    {
        // action body
    }

    public function editaAction()
    {
        // action body
    }


}







