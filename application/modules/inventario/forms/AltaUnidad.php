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
		$eUnidad->setAttrib('required', 'required');
		
		$eAbreviacion = new Zend_Form_Element_Text('abreviatura');
		$eAbreviacion->setLabel('Abreviatura: ');
		$eAbreviacion->setAttrib('class','form-control');
		$eAbreviacion->setAttrib('required', 'required');
		
		$eSAT = new Zend_Form_Element_Text('sat3');
		$eSAT->setLabel('SAT3: ');
		$eSAT->setAttrib('class','form-control');
		$eSAT->setAttrib('required', 'required');
		
		$subCero->addElements(array($eUnidad,$eAbreviacion,$eSAT));
		
		$eAgregar = new Zend_Form_Element_Submit('submit');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-success");
		
		$this->addSubForms(array($subCero));

		$this->addElement($eAgregar);
		
    }


}

