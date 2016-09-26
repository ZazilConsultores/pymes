<?php

class Encuesta_Form_AltaCiclo extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $decoratorsForm = array(
			'FormElements',
			//'Fieldset',
			'Form'
		);
		
		$decoratorsSeccion = array(
			'FormElements',
			array(array('body' => 'HtmlTag'), array('tag' => 'tbody')),
			array(array('tabla' => 'HtmlTag'), array('tag' => 'table', 'class' => 'table table-striped table-condensed')),
			array('Fieldset', array('placement' => 'prepend')),
		);
		
		$decoratorsGrupo = array(
			//'Fieldset',
			'FormElements',
			array(array('body' => 'HtmlTag'), array('tag' => 'tbody')),
			array(array('tabla' => 'HtmlTag'), array('tag' => 'table', 'class' => 'table table-striped table-condensed')),
			array('Fieldset', array('placement' => 'prepend')),
			array(array('element' => 'HtmlTag'), array('tag' => 'td', 'colspan' => '2')),
			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		);
		
		$decoratorsPregunta = array(
			'ViewHelper', //array('ViewHelper', array('class' => 'form-control') ), //'ViewHelper', 
			array(array('element' => 'HtmlTag'), array('tag' => 'td')), 
			array('Label', array('tag' => 'td') ), 
			//array('Description', array('tag' => 'td', 'class' => 'label')), 
			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		);
        
        $this->setLegend("Alta de Ciclo Escolar");
		
        $eCiclo = new Zend_Form_Element_Text("ciclo");
		$eCiclo->setLabel("Ciclo: ");
		$eCiclo->setAttrib("class", "form-control");
		$eCiclo->setAttrib("placeholder", "Ejem: 2015-A");
		//$eCiclo->setAttrib("minlength", "5");
		//$eCiclo->setAttrib("maxlength", "5");
		//$eCiclo->setDecorators($decoratorsPregunta);
		
		$eInicio = new Zend_Form_Element_Text("inicio");
		$eInicio->setLabel("Fecha Inicio:");
		$eInicio->setAttrib("class", "form-control fechaInicio");
		$eInicio->setAttrib("placeholder", "Fecha de inicio...");
		//$eInicio->setDecorators($decoratorsPregunta);
		
		$eTermino = new Zend_Form_Element_Text("termino");
		$eTermino->setLabel("Fecha Termino:");
		$eTermino->setAttrib("class", "form-control fechaTermino");
		$eTermino->setAttrib("placeholder", "Fecha de término...");
		//$eTermino->setDecorators($decoratorsPregunta);
		
		$eActual = new Zend_Form_Element_Checkbox("vigente");
		$eActual->setLabel("Ciclo en curso");
		//$eActual->setDecorators($decoratorsPregunta);
		
        $eDescripcion = new Zend_Form_Element_Textarea("descripcion");
		$eDescripcion->setLabel("Descripción: ");
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setAttrib("rows", "2");
		$eDescripcion->setAttrib("placeholder", "Descripción del ciclo escolar");
		//$eDescripcion->setDecorators($decoratorsPregunta);
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Ciclo");
		$eSubmit->setAttrib("class", "btn btn-success");
        
        $this->addElements(array($eCiclo,$eInicio,$eTermino,$eActual,$eDescripcion,$eSubmit));
		
		//print_r($this->getDecorators());
    }


}

