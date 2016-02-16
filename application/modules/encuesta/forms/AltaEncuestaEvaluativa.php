<?php

class Encuesta_Form_AltaEncuestaEvaluativa extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $subFormDecorators = array(
			"FormElements",
			"Fieldset",
			array(array("contenedor"=>"HtmlTag")),
		);
        
		$elementDecorators = array(
		
		);
		
		$formDecorators = array(
		
		);
        
        $subGeneral = new Zend_Form_SubForm;
		$subGeneral->setLegend("Datos Básicos");
        
        $eNombreEncuesta = new Zend_Form_Element_Text("nombre");
		$eNombreEncuesta->setLabel("Nombre Encuesta: ");
		$eNombreEncuesta->setAttrib("class", "form-control");
		$eNombreEncuesta->setAttrib("required", "required");
		
		$eNombreClaveEncuesta = new Zend_Form_Element_Text("nombreClave");
		$eNombreClaveEncuesta->setLabel("Nombre Clave Encuesta (Mínimo 15, Máximo 20 carácteres): ");
		$eNombreClaveEncuesta->setAttribs("class", "form-control");
		$eNombreClaveEncuesta->setAttrib("required", "required");
		
		$eDescripcion = new Zend_Form_Element_Text("descripcion");
		$eDescripcion->setLabel("Descripcion: ");
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setAttrib("required", "required");
		// =============================================================
		$subEvaluacion = new Zend_Form_SubForm;
		$subEvaluacion->setLegend("Objetivos a Evaluar: ");
		
		$niveles = array();
		$niveles[] = "Primaria";
		$niveles[] = "Secundaria";
		$niveles[] = "Preparatoria";
		
		$eNivel = new Zend_Form_Element_Select("nivel");
		$eNivel->setMultiOptions($niveles);
		
		$subGeneral->addElements(array($eNombreEncuesta,$eNombreClaveEncuesta,$eDescripcion));
        $this->addSubForms(array($subGeneral));
    }


}

