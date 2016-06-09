<?php

class Sistema_Form_AltaFiscales extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $decoratorsCategoria = array(
			//'Fieldset',
			'FormElements',
			//array(array('body' => 'HtmlTag'), array('tag' => 'tbody')),
			array(array('tabla' => 'HtmlTag'), array('tag' => 'table', 'class' => 'table table-striped table-condensed')),
			array('Fieldset', array('placement' => 'prepend')),
			//array(array('element' => 'HtmlTag'), array('tag' => 'td', 'colspan' => '2')),
			//array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
			'Form'
		);
		
		$decoratorsElemento = array(
			'ViewHelper', //array('ViewHelper', array('class' => 'form-control') ), //'ViewHelper', 
			array(array('element' => 'HtmlTag'), array('tag' => 'td')), 
			array('label', array('tag' => 'td') ), 
			//array('Description', array('tag' => 'td', 'class' => 'label')), 
			array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		);
        
        $eRFC = new Zend_Form_Element_Text('rfc');
		$eRFC->setLabel('RFC:');
		$eRFC->setAttrib("class", "form-control");
		
		$eRazonSocial = new Zend_Form_Element_Text('razonSocial');
		$eRazonSocial->setLabel('Razon Social:');
		$eRazonSocial->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar Fiscales');
		$eSubmit->setAttrib("class", "btn btn-success");
		
		//$this->setElementDecorators($decoratorsElemento);
		//$this->setDecorators($decoratorsCategoria);
		
		$this->addElements(array($eRFC,$eRazonSocial,$eSubmit));
    }


}

