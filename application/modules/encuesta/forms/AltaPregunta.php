<?php

class Encuesta_Form_AltaPregunta extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $tipo = Zend_Registry::get("tipo");
        
        $eNombre = new Zend_Form_Element_Text("nombre");
		$eNombre->setLabel("Pregunta:");
		$eNombre->setAttrib("class", "form-control");
		
		$eTipo = new Zend_Form_Element_Select("tipo");
		$eTipo->setLabel("Tipo de pregunta:");
		$eTipo->setAttrib("class", "form-control");
		$eTipo->addMultiOptions($tipo);
		//$eTipo->setMultiOptions($tipo);
		//$eTipo->clearMultiOptions();
		//$eTipo->addMultiOption($option);
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear pregunta");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eNombre);
		$this->addElement($eTipo);
		$this->addElement($eSubmit);
    }


}

