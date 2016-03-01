<?php

class Encuesta_Form_AltaGrupoE extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eGrupo = new Zend_Form_Element_Text("grupo");
        $eGrupo->setLabel("Grupo: ");
		$eGrupo->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Agregar Grupo");
        $eSubmit->setAttrib("class", "btn btn-success");
        
		
		$this->addElements(array($eGrupo,$eSubmit));
    }
	
}

