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
		$eNombreClaveEncuesta->setAttrib("class", "form-control");
		$eNombreClaveEncuesta->setAttrib("required", "required");
		
		$eDescripcion = new Zend_Form_Element_Text("descripcion");
		$eDescripcion->setLabel("Descripcion: ");
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setAttrib("required", "required");
		
		$subGeneral->addElements(array($eNombreEncuesta,$eNombreClaveEncuesta,$eDescripcion));
		// ==================================================================================
		$subEvaluacion = new Zend_Form_SubForm;
		$subEvaluacion->setLegend("Objetivos a Evaluar: ");
		
		$periodos = array();
		$periodos[] = "2016A";
		$periodos[] = "2016B";
		$periodos[] = "2017A";
		
		$ePeriodos = new Zend_Form_Element_Select("periodo");
		$ePeriodos->setLabel("Periodo Educativo");
		$ePeriodos->setMultiOptions($periodos);
		$ePeriodos->setAttrib("class", "form-control");
		
		$niveles = array();
		$niveles[] = "Primaria";
		$niveles[] = "Secundaria";
		$niveles[] = "Preparatoria";
		
		$eNivel = new Zend_Form_Element_Select("nivel");
		$eNivel->setLabel("Nivel Educativo");
		$eNivel->setMultiOptions($niveles);
		$eNivel->setAttrib("class", "form-control");
		
		$eGrado = new Zend_Form_Element_Select("grado");
		$eGrado->setLabel("Grado Educativo");
		$eGrado->setAttrib("class", "form-control");
		
		$eGrupo = new Zend_Form_Element_Select("grupo");
		$eGrupo->setLabel("Grupo: ");
		$eGrupo->setAttrib("class", "form-control");
		
		$subEvaluacion->addElements(array($ePeriodos,$eNivel,$eGrado,$eGrupo));
        $this->addSubForms(array($subGeneral, $subEvaluacion));
        
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear Encuesta");
		$eSubmit->setAttrib("class", "btn btn-success");
		$this->addElement($eSubmit);
    }


}

