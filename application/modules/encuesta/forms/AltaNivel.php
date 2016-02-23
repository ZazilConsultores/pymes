<?php

class Encuesta_Form_AltaNivel extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setLegend("Alta de Nivel Educativo");
        
        $eNivel = new Zend_Form_Element_Text("nivel");
		$eNivel->setLabel("Nivel Educativo: ");
		$eNivel->setAttrib("class", "form-control");
		$eNivel->setAttrib("minlength", "5");
		
		$eDescripcion = new Zend_Form_Element_Text("descripcion");
		$eDescripcion->setLabel("Descripcion: ");
		$eDescripcion->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Nivel Educativo");
		$eSubmit->setAttrib("class", "form-control");
		
        $this->addElements(array($eNivel,$eDescripcion,$eSubmit));
    }


}

