<?php

class Encuesta_Form_AltaNivel extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib("class", "form-horizontal");
        
        $eNivel = new Zend_Form_Element_Text("nivelEducativo");
		$eNivel->setLabel("Nivel Educativo: ");
		$eNivel->setAttrib("class", "form-control");
		$eNivel->setAttrib("minlength", "5");
		$eNivel->setAttrib("placeholder", "Preescolar, Primaria, etc...");
		
		$eDescripcion = new Zend_Form_Element_Text("descripcion");
		$eDescripcion->setLabel("Descripcion: ");
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setAttrib("placeholder", "Agregue una descripción a este nivel educativo...");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Nivel Educativo");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$inputStandarBootstrapDecorators = array(
			'ViewHelper',	// Elemento
			'Errors',		// Errores
			array(array('data'=>'HtmlTag'), array('tag'=>'div', "class"=>"col-xs-8")),
			array('Label', array('class' => 'col-xs-4')),
			array(array('element'=>'HtmlTag'), array('tag'=>'div', 'class' => 'form-group'))
		);
		
		$buttonStandarBootstrapDecorators = array(
			'ViewHelper',	// Elemento
			array(array('data'=>'HtmlTag'), array('tag'=>'div', "class"=>"col-xs-12")),
			//'Label',
			array(array('element'=>'HtmlTag'), array('tag'=>'div', 'class' => 'form-group'))
		);
		
		$eNivel->setDecorators($inputStandarBootstrapDecorators);
		$eDescripcion->setDecorators($inputStandarBootstrapDecorators);
		$eSubmit->setDecorators($buttonStandarBootstrapDecorators);
		
        $this->addElements(array($eNivel,$eDescripcion,$eSubmit));
    }


}

