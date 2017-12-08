<?php

class Contabilidad_Form_AltaDivisa extends Zend_Form
{

    public function init()
    {
        $eClave = new Zend_Form_Element_Text('claveDivisa');     
    	$eClave->setLabel('Clave divisa:');
		$eClave->setAttrib("class", "form-control");
		$eClave->setAttrib("required", "true");
		$eClave->setAttrib("maxlength", "5" );
		
		$eDescripcion = new Zend_Form_Element_Text('descripcion');     
    	$eDescripcion->setLabel('Descripcion:');
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setAttrib("required", "true");
		
		$eTipoCambio = new Zend_Form_Element_Text('tipoCambio');     
    	$eTipoCambio->setLabel('Tipo Cambio:');
		$eTipoCambio->setAttrib("class", "form-control");
		$eTipoCambio->setAttrib("required", "true");
		
		$submit = new Zend_Form_Element_Submit("submit");
		$submit->setLabel("Agregar");
		$submit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eClave);
		$this->addElement($eDescripcion);
		$this->addElement($eTipoCambio);
		$this->addElement($submit);
		
    }


}

