<?php

class Encuesta_Form_AltaValor extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eValor = new Zend_Form_Element_Text("valor");
		$eValor->setLabel("Valor: ");
		$eValor->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Asignar Valor");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElements(array($eValor,$eSubmit));
    }


}

