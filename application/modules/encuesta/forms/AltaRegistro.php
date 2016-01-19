<?php

class Encuesta_Form_AltaRegistro extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
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
		
		$this->addElements(array($eNombres, $eApellidos, $eTipoUsuario,$eReferencia,$eSubmit));
    }


}

