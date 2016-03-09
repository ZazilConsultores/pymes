<?php

class Inventario_Form_AltaUnidad extends Zend_Form
{

    public function init()
    {
        $subCero = new Zend_Form_SubForm();
		$subCero->setLegend("Alta unidad");
		
		
		$eUnidad = new Zend_Form_Element_Text('unidad');
		$eUnidad->setLabel('Unidad: ');
		$eUnidad->setAttrib('class','form-control');
		
		$eAbreviacion = new Zend_Form_Element_Text('abreviatura');
		$eAbreviacion->setLabel('Abreviatura: ');
		$eAbreviacion->setAttrib('class','form-control');
		
		
		$subCero->addElements(array($eUnidad,$eAbreviacion));
		
		$eAgregar = new Zend_Form_Element_Submit('submit');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		$this->addSubForms(array($subCero));

		$this->addElement($eAgregar);
		
		
    }


}

