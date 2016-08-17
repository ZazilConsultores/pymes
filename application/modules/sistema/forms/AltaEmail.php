<?php

class Sistema_Form_AltaEmail extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eEmail = new Zend_Form_Element_Text('email');
		$eEmail->setLabel('Email:');
		$eEmail->setAttrib("class", "form-control");
		
		$eDescripcion= new Zend_Form_Element_Text('descripcion');
		$eDescripcion->setLabel('Descripcion:');
		$eDescripcion->setAttrib("class", "form-control");
		
		
		$eAgregar = new Zend_Form_Element_Submit('submit');
		$eAgregar->setLabel('Agregar Email');
		$eAgregar->setAttrib('class', 'btn btn-success');
		
		$this->addElement($eEmail);
		$this->addElement($eDescripcion);
		$this->addElement($eAgregar);
    }


}

