<?php

class Encuesta_Form_AltaEncuesta extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib("id", "altaEncuesta");
		$this->setAttrib("class", "form-horizontal");
		
        $estatus = Zend_Registry::get('estatus');
        
		$eNombre = new Zend_Form_Element_Text("nombre");
		$eNombre->setLabel("Nombre de la Encuesta: ");
		$eNombre->setAttrib("class", "form-control");
		$eNombre->setAttrib("required", "required");
		$eNombre->setAttrib("placeholder", "Nombre de la Encuesta...");
		$eNombre->setAttrib("autofocus", "");
		
		$eDetalle = new Zend_Form_Element_Text("nombreClave");
		$eDetalle->setLabel("Nombre clave de la encuesta: (Máximo 20 caracteres)");
		$eDetalle->setAttrib("class", "form-control");
		$eDetalle->setAttrib("minlenght", "15");
		$eDetalle->setAttrib("maxlenght", "20");
		$eDetalle->setAttrib("required", "required");
		$eDetalle->setAttrib("placeholder", "Nombre Clave de la Encuesta...");
		
		$eDescripcion = new Zend_Form_Element_Text("descripcion");
		$eDescripcion->setLabel("Objetivo de la encuesta: ");
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setAttrib("required", "required");
		$eDescripcion->setAttrib("placeholder", "Objetivo de la Encuesta...");
		
		$eEstatus = new Zend_Form_Element_Select("estatus");
		$eEstatus->setLabel("Estatus de la encuesta");
		foreach ($estatus as $clave => $valor) {
			$eEstatus->addMultiOption($clave, $valor);
		}
		$eEstatus->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Generar Encuesta");
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
		
		$eNombre->setDecorators($inputStandarBootstrapDecorators);
		$eDetalle->setDecorators($inputStandarBootstrapDecorators);
		$eDescripcion->setDecorators($inputStandarBootstrapDecorators);
		$eEstatus->setDecorators($inputStandarBootstrapDecorators);
		
		$eSubmit->setDecorators($buttonStandarBootstrapDecorators);
		
		$this->addElement($eNombre);
		$this->addElement($eDetalle);
		$this->addElement($eDescripcion);
		$this->addElement($eEstatus);
		
		$this->addElement($eSubmit);
    }


}

