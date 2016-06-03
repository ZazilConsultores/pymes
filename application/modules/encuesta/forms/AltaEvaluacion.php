<?php

class Encuesta_Form_AltaEvaluacion extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $cicloDAO = new Encuesta_DAO_Ciclo;
		$cicloActual = $cicloDAO->obtenerCicloActual();
		
		$nivelDAO = new Encuesta_DAO_Nivel;
		$niveles = $nivelDAO->obtenerNiveles();
        
        $eCicloEscolar = new Zend_Form_Element_Select("idCicloEscolar");
		$eCicloEscolar->setLabel("Ciclo Escolar: ");
		$eCicloEscolar->setAttrib("class", "form-control");
		$eCicloEscolar->setAttrib("disabled", "disabled");
		$eCicloEscolar->addMultiOption($cicloActual->getIdCiclo(),$cicloActual->getCiclo());
		
		$eNivel = new Zend_Form_Element_Select("idNivel");
		$eNivel->setAttrib("class", "form-control");
		$eNivel->setLabel("Nivel: ");
		
		foreach ($niveles as $nivel) {
			$eNivel->addMultiOption($nivel->getIdNivel(),$nivel->getNivel());
		}
		
		$eGrado = new Zend_Form_Element_Select("idGrado");
		$eGrado->setAttrib("class", "form-control");
		$eGrado->setLabel("Grado: ");
		
		$eGrupo = new Zend_Form_Element_Select("idGrupo");
		$eGrupo->setLabel("Grupo: ");
		$eGrupo->setAttrib("class", "form-control");
		
		$this->addElements(array($eCicloEscolar,$eNivel,$eGrado,$eGrupo));
		
    }


}

