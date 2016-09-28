<?php

class Encuesta_Form_AltaSeccion extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib("class", "form-horizontal");
        
        $eNombre = new Zend_Form_Element_Text("nombre");
		$eNombre->setLabel("Nombre de la Seccion");
		$eNombre->setAttrib("class", "form-control");
		$eNombre->setAttrib("minlenght", "");
		$eNombre->setAttrib("placeholder", "Nombre de la sección...");
		$eNombre->setAttrib("autofocus", "");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setAttrib("class", "btn btn-info");
		$eSubmit->setLabel("Agregar seccion");
		
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
		
		$eNombre->setDecorators($inputStandarBootstrapDecorators);
		$eSubmit->setDecorators($buttonStandarBootstrapDecorators);
		
		$this->addElement($eNombre);
		$this->addElement($eSubmit);
    }


}

