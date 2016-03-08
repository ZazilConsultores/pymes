<?php

class Encuesta_Form_MateriasProfesor extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $registroDAO = new Encuesta_DAO_Registro;
		$docentes = $registroDAO->obtenerDocentes();
        
        $eMateria = new Zend_Form_Element_Select("idMateria");
		$eMateria->setLabel("Materia");
		$eMateria->setAttrib("class", "form-control");
		$eMateria->setRegisterInArrayValidator(false);
		//$eMateria->clearMultiOptions()
		
		$eDocente = new Zend_Form_Element_Select("idProfesor");
		$eDocente->setLabel("Profesor");
		$eDocente->setAttrib("class", "form-control");
		
		foreach ($docentes as $docente) {
			$eDocente->addMultiOption($docente->getIdRegistro(),$docente->getApellidos(). " ".$docente->getNombres());
		}
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Asociar Docente");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElements(array($eMateria,$eDocente,$eSubmit));
    }


}

