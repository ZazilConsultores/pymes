<?php

class Sistema_Form_AltaEstado extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $subForm = new Zend_Form_SubForm();
		$subForm->setLegend("Alta de Estado");
		
		$eClave = new Zend_Form_Element_Text('claveEstado');
		$eClave->setLabel('Clave Estado:');
		$eClave->setAttrib("class", "form-control");
		
        $eEstado = new Zend_Form_Element_Text('estado');
		$eEstado->setLabel('Estado:');
		$eEstado->setAttrib("class", "form-control");
		
		$eCapital = new Zend_Form_Element_Text('capital');
		$eCapital->setLabel('Capital:');
		$eCapital->setAttrib("class", "form-control");
		
		$eAgregar = new Zend_Form_Element_Submit('agregar');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		$subForm->addElements(array($eEstado, $eCapital, $eAgregar));
		
		//$this->addSubForm($subForm, "alta");
		//$this->addElement($eEstado);
		//$this->addElement($eAgregar);
		$this->addElements(array($eClave,$eEstado, $eCapital, $eAgregar));
    }


}

