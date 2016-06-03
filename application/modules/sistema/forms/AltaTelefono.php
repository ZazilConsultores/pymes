<?php

class Sistema_Form_AltaTelefono extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $tipoTelefono = Zend_Registry::get("tipoTelefono");
		
        $eTipoTelefono = new Zend_Form_Element_Select('tipo');
		$eTipoTelefono->setLabel('Tipo Telefono:');
		$eTipoTelefono->setAttrib("class", "form-control");
		$eTipoTelefono->setMultiOptions($tipoTelefono);
		
		$eLada = new Zend_Form_Element_Text('lada');
		$eLada->setLabel('Lada:');
		$eLada->setAttrib("class", "form-control");
		
		$eTelefono = new Zend_Form_Element_Text('telefono');
		$eTelefono->setLabel('Telefono:');
		$eTelefono->setAttrib("class", "form-control");
		
		$eExtensiones = new Zend_Form_Element_Text('extensiones');
		$eExtensiones->setLabel('Extensiones:');
		$eExtensiones->setAttrib("class", "form-control");
		
		$eDescripcion = new Zend_Form_Element_Text('descripcion');
		$eDescripcion->setLabel('Descripción:');
		$eDescripcion->setAttrib("class", "form-control");
				
		$eAgregar = new Zend_Form_Element_Submit('submit');
		$eAgregar->setLabel('Agregar Teléfono');
		$eAgregar->setAttrib("class", "btn btn-success");
		
		$this->addElement($eTipoTelefono);
		$this->addElement($eLada);
		$this->addElement($eTelefono);
		$this->addElement($eExtensiones);
		$this->addElement($eDescripcion);
		$this->addElement($eAgregar);
    }


}

