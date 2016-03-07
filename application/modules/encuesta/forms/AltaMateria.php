<?php

class Encuesta_Form_AltaMateria extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $cicloDAO = new Encuesta_DAO_Ciclo;
		$ciclo = $cicloDAO->obtenerCicloActual();
		
        $nivelDAO = new Encuesta_DAO_Nivel;
		$niveles = $nivelDAO->obtenerNiveles();
		
		$gradoDAO = new Encuesta_DAO_Grado;
		$grados = $gradoDAO->obtenerGrados("1");
		
		$eCiclo = new Zend_Form_Element_Select("idCiclo");
		$eCiclo->setLabel("Ciclo Escolar:");
		$eCiclo->setAttrib("class", "form-control");
		$eCiclo->addMultiOption($ciclo->getIdCiclo(),$ciclo->getCiclo());
		
		$eNivel = new Zend_Form_Element_Select("idNivel");
		$eNivel->setLabel("Nivel: ");
		$eNivel->setAttrib("class", "form-control");
		
		foreach ($niveles as $nivel) {
			$eNivel->addMultiOption($nivel->getIdNivel(),$nivel->getNivel());
		}
		
		$eGrado = new Zend_Form_Element_Select("idGrado");
		$eGrado->setAttrib("class", "form-control");
		$eGrado->setLabel("Grado: ");
		$eGrado->setRegisterInArrayValidator(false);
		if(!empty($grados)){
			foreach ($grados as $grado) {
				$eGrado->addMultiOption($grado->getIdGrado(),$grado->getGrado());
			}
		}
		
        $eMateria = new Zend_Form_Element_Text("materia");
		$eMateria->setLabel("Materia: ");
        $eMateria->setAttrib("class", "form-control");
		
		$eCreditos = new Zend_Form_Element_Text("creditos");
		$eCreditos->setLabel("Creditos: ");
		$eCreditos->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Materia");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		
		$this->addElements(array($eCiclo,$eNivel,$eGrado,$eMateria,$eCreditos,$eSubmit));
		
		
    }


}

