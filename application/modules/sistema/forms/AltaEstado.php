<?php

class Sistema_Form_AltaEstado extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eEstado = new Zend_Form_Element_Text('estado');
		$eEstado->setLabel('Nombre:');
		$eEstado->setAttrib("class", "form-control");
		
		
		$eAgregar = new Zend_Form_Element_Submit('agregar');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		$this->addElement($eEstado);
		$this->addElement($eAgregar);
    }


}

