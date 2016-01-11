<?php

class Encuesta_Form_AltaSeccion extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eNombre = new Zend_Form_Element_Text("nombre");
		$eNombre->setLabel("Nombre de la Seccion");
		$eNombre->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setAttrib("class", "btn btn-info");
		$eSubmit->setLabel("Agregar seccion");
		
		$this->addElement($eNombre);
		$this->addElement($eSubmit);
    }


}

