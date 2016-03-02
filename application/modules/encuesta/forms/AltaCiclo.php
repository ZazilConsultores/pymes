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
		$eCiclo->setAttrib("minlength", "5");
		$eCiclo->setAttrib("maxlength", "5");
		
		$eInicio = new Zend_Form_Element_Text("inicio");
		$eInicio->setLabel("Fecha Inicio:");
		$eInicio->setAttrib("class", "form-control fechaInicio");
		
		$eTermino = new Zend_Form_Element_Text("termino");
		$eTermino->setLabel("Fecha Termino:");
		$eTermino->setAttrib("class", "form-control fechaTermino");
        
        $eDescripcion = new Zend_Form_Element_Textarea("descripcion");
		$eDescripcion->setLabel("Descripción: ");
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setAttrib("rows", "2");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Ciclo");
		$eSubmit->setAttrib("class", "btn btn-success");
        
        $this->addElements(array($eCiclo,$eInicio,$eTermino,$eDescripcion,$eSubmit));
		
		//print_r($this->getDecorators());
    }


}

