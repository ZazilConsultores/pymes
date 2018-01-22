<?php

class Sistema_Form_AltaMunicipio extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $subForm = new Zend_Form_SubForm();
		$subForm->setLegend("Alta de Municipio");
		
		$eClaveMunicipio = new Zend_Form_Element_Text('claveMunicipio');
		$eClaveMunicipio->setLabel('Clave Municipio:');
		$eClaveMunicipio->setAttrib("class", "form-control");
		
       	$eMunicipio = new Zend_Form_Element_Text('municipio');
		$eMunicipio->setLabel('Municipio:');
		$eMunicipio->setAttrib("class", "form-control");
		
		
		
		$eAgregar = new Zend_Form_Element_Submit('agregar');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		$subForm->addElements(array($eMunicipio,$eAgregar));
		$this->addElements(array($eClaveMunicipio,$eMunicipio,$eAgregar));
	
    }


}

