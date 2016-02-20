<?php

class Inventario_Form_AltaUnidad extends Zend_Form
{

    public function init()
    {
        $subForm = new Zend_Form_SubForm();
		$subForm->setLegend("Alta de Producto");
		
		
		$eUnidad = new Zend_Form_Element_Select('unidad');
		$eUnidad->setLabel('Unidad: ');
		$eUnidad->setAttrib('class','form-control');
		
		$eAbreviacion = new Zend_Form_Element_Select('abreviatura');
		$eAbreviacion->setLabel('Abreviatura: ');
		$eAbreviacion->setAttrib('class','form-control');
		
		$eAgregar = new Zend_Form_Element_Submit('agregar');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		$this->addSubForms(array($subForm));
		$this->addElement($eAgregar);
		
		
    }


}

