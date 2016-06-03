<?php

class Encuesta_Form_AltaGrupoE extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $planDAO = new Encuesta_DAO_Plan;
		$plan = $planDAO->obtenerPlanEstudiosVigente();
		
        $cicloDAO = new Encuesta_DAO_Ciclo;
		$ciclos = $cicloDAO->obtenerCiclos($plan["idPlanE"]);
        
        $eCiclo = new Zend_Form_Element_Select("ciclo");
        $eCiclo->setLabel("Ciclo: ");
		$eCiclo->setAttrib("class", "form-control");
		
		foreach ($ciclos as $ciclo) {
			$eCiclo->addMultiOption($ciclo->getIdCiclo(),$ciclo->getCiclo());
		}
		
		$eGrado = new Zend_Form_Element_Select("grado");
		$eGrado->setLabel("Grado: ");
		$eGrado->setAttrib("class", "form-control");
        
        $eGrupo = new Zend_Form_Element_Text("grupo");
        $eGrupo->setLabel("Grupo: ");
		$eGrupo->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Grupo");
        $eSubmit->setAttrib("class", "btn btn-success");
        
		
		$this->addElements(array($eCiclo,$eGrado,$eGrupo,$eSubmit));
    }
	
}

