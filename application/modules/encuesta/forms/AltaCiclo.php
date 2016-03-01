<?php

class Encuesta_Form_AltaCiclo extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setLegend("Alta de Ciclo Escolar");
		
        $eCiclo = new Zend_Form_Element_Text("ciclo");
		$eCiclo->setLabel("Ciclo: ");
		$eCiclo->setAttrib("class", "form-control");
        
        $eAnotaciones = new Zend_Form_Element_Text("anotaciones");
		$eAnotaciones->setLabel("Anotaciones: ");
		$eAnotaciones->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Ciclo");
		$eSubmit->setAttrib("class", "btn btn-success");
        
        $this->addElements(array($eCiclo,$eAnotaciones,$eSubmit));
		
		print_r($this->getDecorators());
    }


}

