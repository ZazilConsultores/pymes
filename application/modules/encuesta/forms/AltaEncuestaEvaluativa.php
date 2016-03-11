<?php

class Encuesta_Form_AltaEncuestaEvaluativa extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $cicloDAO = new Encuesta_DAO_Ciclo;
		$nivelDAO = new Encuesta_DAO_Nivel;
		$gradoDAO = new Encuesta_DAO_Grado;
        
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
		$subEvaluacion->setLegend("Grupo a Evaluar: ");
		
		$eCiclo = new Zend_Form_Element_Select("idCiclo");
		$eCiclo->setLabel("Ciclo Escolar");
		$eCiclo->setAttrib("class", "form-control");
		
		$ciclos = $cicloDAO->obtenerCiclos();
		foreach ($ciclos as $ciclo) {
			$eCiclo->addMultiOption($ciclo->getIdCiclo(),$ciclo->getCiclo());
		}
		
		$niveles = $nivelDAO->obtenerNiveles();
		
		$eNivel = new Zend_Form_Element_Select("idNivel");
		$eNivel->setLabel("Nivel Educativo");
		$eNivel->setAttrib("class", "form-control");
		
		foreach ($niveles as $nivel) {
			$eNivel->addMultiOption($nivel->getIdNivel(),$nivel->getNivel());
		}
		
		$grados = $gradoDAO->obtenerGrados("1");
		
		$eGrado = new Zend_Form_Element_Select("idGrado");
		$eGrado->setLabel("Grado Educativo");
		$eGrado->setAttrib("class", "form-control");
		
		foreach ($grados as $grado) {
			$eGrado->addMultiOption($grado->getIdGrado(),$grado->getGrado());
		}
		
		$eGrupo = new Zend_Form_Element_Select("idGrupo");
		$eGrupo->setLabel("Grupo: ");
		$eGrupo->setAttrib("class", "form-control");
		
		$subEvaluacion->addElements(array($eCiclo,$eNivel,$eGrado,$eGrupo));
        $this->addSubForms(array($subGeneral, $subEvaluacion));
        
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear Encuesta");
		$eSubmit->setAttrib("class", "btn btn-success");
		$this->addElement($eSubmit);
    }


}

