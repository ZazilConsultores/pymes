<?php

class Encuesta_Form_AltaPlan extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $ePlan = new Zend_Form_Element_Text("planEducativo");
		$ePlan->setLabel("Plan de Estudios: ");
		$ePlan->setAttrib("class", "form-control");
		$ePlan->setAttrib("minlength", "5");
		$ePlan->setAttrib("maxlength", "15");
		$ePlan->setAttrib("placeholder", "Ejem: 2015-A");
        
        $eDescripcion = new Zend_Form_Element_Textarea("descripcion");
		$eDescripcion->setLabel("Descripcion: ");
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setAttrib("rows", "2");
		$eDescripcion->setAttrib("placeholder", "Agregue características a este plan de estudios...");
		
		$eVigente = new Zend_Form_Element_Checkbox("vigente");
		$eVigente->setLabel("Esta Vigente?:");
		//$eVigente->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Plan de Estudios");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElements(array($ePlan,$eDescripcion,$eVigente,$eSubmit));
    }


}

