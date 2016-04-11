<?php

class Encuesta_Form_AltaGrado extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $grados = Zend_Registry::get("gradosEscolares");
        
        $abreviaturas = array(
			"1" => "1°",
			"2" => "2°",
			"3" => "3°",
			"4" => "4°",
			"5" => "5°",
			"6" => "6°",
			"7" => "7°",
			"8" => "8°",
			"9" => "9°",
			"10" => "10°"
		);
        
        $eGrado = new Zend_Form_Element_Text("grado");
		$eGrado->setLabel("Grado: ");
        $eGrado->setAttrib("class", "form-control");
		
		$eAbreviatura = new Zend_Form_Element_Select("abreviatura");
		$eAbreviatura->setLabel("Abreviatura: ");
		$eAbreviatura->setMultiOptions($grados);
		$eAbreviatura->setAttrib("class", "form-control");
		
		$eDescripcion = new Zend_Form_Element_Text("descripcion");
		$eDescripcion->setLabel("Descripción (opcional): ");
		$eDescripcion->setAttrib("class", "form-control");
		
		$eObjetivo = new Zend_Form_Element_Text("objetivo");
		$eObjetivo->setLabel("Objetivo (opcional): ");
		$eObjetivo->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Grado");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElements(array($eGrado,$eAbreviatura,$eDescripcion,$eSubmit));
    }
}

