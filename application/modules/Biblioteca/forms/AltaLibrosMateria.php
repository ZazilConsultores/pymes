<?php

class Biblioteca_Form_AltaLibrosMateria extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib("id", "altaLibrosMateria");
		
		 
	    $materiaDAO = new Biblioteca_DAO_Materia;
		$materias = $materiaDAO->obtenerMateriaB("9");
		
		
		$eMateria = new Zend_Form_Element_Select("idMateria");
		$eMateria->setLabel("Seleccione Materia: ");
		$eMateria->setAttrib("class", "form-control");
		$eMateria->setRegisterInArrayValidator(FALSE);
		foreach ($materias as $materia) {
			$eMateria->addMultiOption($materia->getIdMateria(),$materia->getMateria());
		
		}
		
		$libroDAO = new Biblioteca_DAO_Libro;
		$libros = $libroDAO->obtenerLibro("9");
		
		$eLibro = new Zend_Form_Element_Select("idsLibro");
		$eLibro->setLabel("Selecciona un Libro");
		$eLibro->setAttrib("class", "form-control");
		$eLibro->setRegisterInArrayValidator(FALSE);
		foreach ($libros as $libro) {
			$eLibro->addMultiOption($libro->getIdLibro(),$libro->getTitulo());
		}
		
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Guardar");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		
		$this->addElement($eMateria);
		$this->addElement($eLibro);
		
		$this->addElement($eSubmit);
    }


}

