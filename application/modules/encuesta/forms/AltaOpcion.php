<?php

class Encuesta_Form_AltaOpcion extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eOpcion = new Zend_Form_Element_Text("nombreOpcion");
        $eOpcion->setLabel("Opcion: ");
		$eOpcion->setAttrib("class", "form-control");
		
		$eTipoValor = new Zend_Form_Element_Select("tipoValor");
		$eTipoValor->setMultiOptions(Zend_Registry::get("tiposValores"));
		$eTipoValor->setLabel("Tipo de valor de la Opcion: ");
		$eTipoValor->setAttrib("class", "form-control");
		
		$eValor = new Zend_Form_Element_Text("valor");
		$eValor->setLabel("Valor de la Opción: ");
		$eValor->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Guardar Opción");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElements(array($eOpcion, $eTipoValor, $eValor, $eSubmit));
    }


}

