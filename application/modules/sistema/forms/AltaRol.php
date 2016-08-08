<?php

class Sistema_Form_AltaRol extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eRol = new Zend_Form_Element_Text("rol");
		$eRol->setLabel("Rol: ");
		$eRol->setAttrib("class", "form-control");
        
        $eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear Rol");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElements(array($eRol,$eSubmit));
    }


}

