<?php

class Encuesta_Form_AltaOpcion extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib("class", "form-horizontal");
        
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
		
		$eOpcion->setDecorators($inputStandarBootstrapDecorators);
		$eTipoValor->setDecorators($inputStandarBootstrapDecorators);
		$eValor->setDecorators($inputStandarBootstrapDecorators);
		$eSubmit->setDecorators($buttonStandarBootstrapDecorators);
		
		
		$this->addElements(array($eOpcion, $eTipoValor, $eValor, $eSubmit));
    }


}

