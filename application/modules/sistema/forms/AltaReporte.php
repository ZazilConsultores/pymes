<?php

class Sistema_Form_AltaReporte extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        
        
        $eTipoReporte = new Zend_Form_Element_Text("tipoReporte");
		$eTipoReporte->setLabel("Clave Reporte - (4 Caracteres)");
		$eTipoReporte->setAttrib("class", "form-control");
		
		$eDescripcion = new Zend_Form_Element_Textarea("descripcion");
		$eDescripcion->setLabel("Descripción del Reporte: ");
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setAttrib("rows", "3");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Tipo de Reporte");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		
		$this->addElements(array($eTipoReporte,$eDescripcion,$eSubmit));
    }


}

