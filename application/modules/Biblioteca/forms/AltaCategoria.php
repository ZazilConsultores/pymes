<?php

class Biblioteca_Form_AltaCategoria extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
      	$this->setAttrib("id", "altaCategoria");
	   
	    $materiaDAO = new Biblioteca_DAO_Materia;
		$materias = $materiaDAO->obtenerMateriaB("9");
		
		
		$eMateria = new Zend_Form_Element_Select("idMateria");
		$eMateria->setLabel("Seleccione Materia: ");
		$eMateria->setAttrib("class", "form-control");
		$eMateria->setRegisterInArrayValidator(FALSE);
		foreach ($materias as $materia) {
			$eMateria->addMultiOption($materia->getIdMateria(),$materia->getMateria());
		
		}
		$eMateria->setValue("9");
		
		/*$eMateria = new Zend_Form_Element_Text("materia");
		$eMateria->setLabel("Materia");
		$eMateria->setAttrib("class", "form-control");
		$eMateria->setAttrib("required", "required");*/
		
		$eCategoria = new Zend_Form_Element_Text("categoria");
		$eCategoria->setLabel("Nombre de la categoria");
		$eCategoria->setAttrib("class", "form-control");
		$eCategoria->setAttrib("required", "required");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Guardar Categoría");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eMateria);
		$this->addElement($eCategoria);
		
		$this->addElement($eSubmit);

	}
}

