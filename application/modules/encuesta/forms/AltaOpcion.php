<?php

class Encuesta_Form_AltaOpcion extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eOpcion = new Zend_Form_Element_Text("opcion");
        $eOpcion->setLabel("Opcion: ");
		$eOpcion->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Guardar Opción");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElements(array($eOpcion, $eSubmit));
    }


}

