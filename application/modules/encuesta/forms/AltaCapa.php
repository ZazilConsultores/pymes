<?php

class Encuesta_Form_AltaCapa extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eNombreCapa = new Zend_Form_Element_Text("nombre");
		$eNombreCapa->setLabel("Nombre de la capa: ");
		$eNombreCapa->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Capa");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElements(array($eNombreCapa,$eSubmit));
    }


}

