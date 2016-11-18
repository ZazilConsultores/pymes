<?php

class Contabilidad_Form_CrearImpuesto extends Zend_Form
{

    public function init()
    {
    	$eAbreviatura = new Zend_Form_Element_Text('abreviatura');
		$eAbreviatura->setLabel('Abrevitura:');
		$eAbreviatura->setAttrib("class", "form-control");
		$eAbreviatura->setAttrib("required", "true");
		
		$eDescripcion = new Zend_Form_Element_Text('descripcion');
		$eDescripcion->setLabel('Descripción:');
		$eDescripcion->setAttrib("class", "form-control");
		
		$eEstatus = new Zend_Form_Element_Checkbox('estatus');
		$eEstatus->setLabel('Estatus:');
		
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-warning");
		
		$this->addElement($eAbreviatura);
		$this->addElement($eDescripcion);
		//$this->addElement($eEstatus);
		$this->addElement($eSubmit);
        
    }


}

