<?php

class Encuesta_Form_AltaRegistro extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib("class", "form-horizontal");
		
        $tUsuario = Zend_Registry::get("tUsuario");
		
        $eNombres = new Zend_Form_Element_Text("nombres");
		$eNombres->setLabel("Nombres: ");
		$eNombres->setAttrib("class", "form-control");
		
		$eApellidos = new Zend_Form_Element_Text("apellidos");
		$eApellidos->setLabel("Apellidos: ");
		$eApellidos->setAttrib("class", "form-control");
		
		$eTipoUsuario = new Zend_Form_Element_Select("tipo");
		$eTipoUsuario->setMultiOptions($tUsuario);
		$eTipoUsuario->setLabel("Tipo de Usuario: ");
		$eTipoUsuario->setAttrib("class", "form-control");
        
        $eReferencia = new Zend_Form_Element_Text("referencia");
		$eReferencia->setLabel("Boleta o clave: ");
		$eReferencia->setAttrib("class", "form-control");
		
        $eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setAttrib("class", "btn btn-success");
		$eSubmit->setLabel("Agregar Usuario");
		
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
		
		$eNombres->setDecorators($inputStandarBootstrapDecorators);
		$eApellidos->setDecorators($inputStandarBootstrapDecorators);
		$eTipoUsuario->setDecorators($inputStandarBootstrapDecorators);
		$eReferencia->setDecorators($inputStandarBootstrapDecorators);
		$eSubmit->setDecorators($buttonStandarBootstrapDecorators);
		
		$this->addElements(array($eNombres, $eApellidos, $eTipoUsuario,$eReferencia,$eSubmit));
    }


}

