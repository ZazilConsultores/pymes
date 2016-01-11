<?php

class Encuesta_Form_AltaCategoria extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
         $eNombre = new Zend_Form_Element_Text("nombre");
		$eNombre->setLabel("Categoria");
		$eNombre->setAttrib("class", "form-control");
		
		$eDescripcion = new Zend_Form_Element_Textarea("descripcion");
		$eDescripcion->setLabel("Agregue una descripcion de esta categoria");
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setAttrib("rows", "5");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Guardar Categoria");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElements(array($eNombre, $eDescripcion, $eSubmit));
    }


}

