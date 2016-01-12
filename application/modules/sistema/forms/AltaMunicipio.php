<?php

class Sistema_Form_AltaMunicipio extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eMunicipio = new Zend_Form_Element_Text('municipio');
		$eMunicipio->setLabel('Municipio:');
		$eMunicipio->setAttrib("class", "form-control");
		
		
		
		$eAgregar = new Zend_Form_Element_Submit('agregar');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		$this->addElement($eMunicipio);
		$this->addElement($eAgregar);
    }


}

