<?php

class Encuesta_Form_AltaEncuesta extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib("id", "altaEncuesta");
        $estatus = Zend_Registry::get('estatus');
        
		$eNombre = new Zend_Form_Element_Text("nombre");
		$eNombre->setLabel("Nombre de la Encuesta: ");
		$eNombre->setAttrib("class", "form-control");
		$eNombre->setAttrib("required", "required");
		
		$eDetalle = new Zend_Form_Element_Text("nombreClave");
		$eDetalle->setLabel("Nombre clave de la encuesta: (Máximo 20 caracteres)");
		$eDetalle->setAttrib("class", "form-control");
		$eDetalle->setAttrib("minlenght", "15");
		$eDetalle->setAttrib("maxlenght", "20");
		$eDetalle->setAttrib("required", "required");
		
		$eDescripcion = new Zend_Form_Element_Text("descripcion");
		$eDescripcion->setLabel("Objetivo de la encuesta: ");
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setAttrib("required", "required");
		
		$eEstatus = new Zend_Form_Element_Select("estatus");
		$eEstatus->setLabel("Estatus de la encuesta");
		foreach ($estatus as $clave => $valor) {
			$eEstatus->addMultiOption($clave, $valor);
		}
		$eEstatus->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Generar Encuesta");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eNombre);
		$this->addElement($eDetalle);
		$this->addElement($eDescripcion);
		$this->addElement($eEstatus);
		
		$this->addElement($eSubmit);
    }


}

