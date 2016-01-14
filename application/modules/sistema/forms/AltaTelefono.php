<?php

class Sistema_Form_AltaTelefono extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eTipo = new Zend_Form_Element_Text('tipo');
		$eTipo->setLabel('Tipo:');
		$eTipo->setAttrib("class", "form-control");
		
		$eLada = new Zend_Form_Element_Text('lada');
		$eLada->setLabel('Lada:');
		$eLada->setAttrib("class", "form-control");
		
		$eTelefono = new Zend_Form_Element_Text('telefono');
		$eTelefono->setLabel('Telefono:');
		$eTelefono->setAttrib("class", "form-control");
		
		$eExtensiones = new Zend_Form_Element_Text('extensiones');
		$eExtensiones->setLabel('Extenciones:');
		$eExtensiones->setAttrib("class", "form-control");
		
		$eDescripcion = new Zend_Form_Element_Text('descripcion');
		$eDescripcion->setLabel('Descripcion:');
		$eDescripcion->setAttrib("class", "form-control");
				
		$eAgregar = new Zend_Form_Element_Submit('agregar');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		$this->addElement($eTipo);
		$this->addElement($eLada);
		$this->addElement($eTelefono);
		$this->addElement($eExtensiones);
		$this->addElement($eDescripcion);
		$this->addElement($eAgregar);
    }


}

