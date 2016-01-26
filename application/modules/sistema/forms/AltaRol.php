<?php

class Sistema_Form_AltaRol extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $subContenedor = new Zend_Form_SubForm;
		$subContenedor->setLegend("Nuevo Rol en el Sistema");
        $eRol = new Zend_Form_Element_Text("rol");
		$eRol->setLabel("Rol: ");
		$eRol->setAttrib("class", "form-control");
        
        $subContenedor->addElements(array($eRol));
		
        $eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear Rol");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addSubForms(array($subContenedor));
		$this->addElement($eSubmit);
    }


}

