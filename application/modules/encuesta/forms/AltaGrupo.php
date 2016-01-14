<?php

class Encuesta_Form_AltaGrupo extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $tipos = Zend_Registry::get("tipo");
        $eNombre = new Zend_Form_Element_Text("nombre");
		$eNombre->setLabel("Nombre del Grupo: ");
		$eNombre->setAttrib("class", "form-control");
		
		$eTipo = new Zend_Form_Element_Select("tipo");
		$eTipo->setLabel("Tipo del grupo: ");
		$eTipo->setAttrib("class", "form-control");
		$eTipo->addMultiOptions($tipos);
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Grupo");
		//$eTipo->setAttrib("class", "btn btn-primary");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eNombre);
		$this->addElement($eTipo);
		$this->addElement($eSubmit);
    }


}

