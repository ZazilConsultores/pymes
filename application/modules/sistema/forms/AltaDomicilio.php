<?php

class Sistema_Form_AltaDomicilio extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eCalle = new Zend_Form_Element_Text('calle');
		$eCalle->setLabel('Calle:');
		$eCalle->setAttrib("class", "form-control");
		
		$eColonia = new Zend_Form_Element_Text('colonia');
		$eColonia->setLabel('Colonia:');
		$eColonia->setAttrib("class", "form-control");
		
		$eCP = new Zend_Form_Element_Text('codigoPostal');
		$eCP->setLabel('Codigo Postal:');
		$eCP->setAttrib("class", "form-control");
		
		$eNumeroInterior = new Zend_Form_Element_Text('numeroInterior');
		$eNumeroInterior->setLabel('Numero Interior:');
		$eNumeroInterior->setAttrib("class", "form-control");
		
		$eNumeroExterior = new Zend_Form_Element_Text('numeroExterior');
		$eNumeroExterior->setLabel('Numero Exterior:');
		$eNumeroExterior->setAttrib("class", "form-control");
		
		$eAgregar = new Zend_Form_Element_Submit('agregar');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		
		$this->addElement($eCalle);
		$this->addElement($eColonia);
		$this->addElement($eCP);
		$this->addElement($eNumeroInterior);
		$this->addElement($eNumeroExterior);
		$this->addElement($eAgregar);
    }


}

