<?php

class Encuesta_Form_AltaEncuesta extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $estatus = Zend_Registry::get('estatusEncuesta');
        
		$eNombre = new Zend_Form_Element_Text("nombre");
		$eNombre->setLabel("Nombre de la Encuesta: ");
		$eNombre->setAttrib("class", "form-control");
		
		$eDetalle = new Zend_Form_Element_Text("detalle");
		$eDetalle->setLabel("Breve identificador de la encuesta: (Máximo 20 caracteres)");
		$eDetalle->setAttrib("class", "form-control");
		
		$eDescripcion = new Zend_Form_Element_Text("descripcion");
		$eDescripcion->setLabel("Objetivo de la encuesta");
		$eDescripcion->setAttrib("class", "form-control");
		
		$eEstatus = new Zend_Form_Element_Select("estatus");
		$eEstatus->setLabel("Estatus de la encuesta");
		foreach ($estatus as $clave => $valor) {
			if($clave > 2){
				break;
			}
			$eEstatus->addMultiOption($clave, $valor);
		}
		$eEstatus->setAttrib("class", "form-control");
		
		$eFechaInicio = new Zend_Form_Element_Text("fechaInicio");
		$eFechaInicio->setLabel("Inicio de la encuesta");
		$eFechaInicio->setAttrib("class", "form-control fecha");
		$eFechaInicio->setAttrib("tipo", "fecha");
		
		$eFechaFin = new Zend_Form_Element_Text("fechaFin");
		$eFechaFin->setLabel("Término de la encuesta");
		$eFechaFin->setAttrib("class", "form-control fecha");
		$eFechaFin->setAttrib("tipo", "fecha");
		
		$eSubmit = new Zend_Form_Element_Submit("eSubmit");
		$eSubmit->setLabel("Generar Encuesta");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eNombre);
		$this->addElement($eDetalle);
		$this->addElement($eDescripcion);
		$this->addElement($eFechaInicio);
		$this->addElement($eFechaFin);
		$this->addElement($eEstatus);
		
		$this->addElement($eSubmit);
    }


}

