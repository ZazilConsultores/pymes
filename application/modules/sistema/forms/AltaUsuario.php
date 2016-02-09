<?php

class Sistema_Form_AltaUsuario extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $sub = new Zend_Form_SubForm;
		$sub->setLegend("Nuevo Usuario en el Sistema");
		
		$eUsuario = new Zend_Form_Element_Text("usuario");
		$eUsuario->setLabel("Usuario: ");
		$eUsuario->setAttrib("class", "form-control");
		
		$ePassword = new Zend_Form_Element_Password("password");
		$ePassword->setLabel("Password: ");
		$ePassword->setAttrib("class", "form-control");
		
		
		$eNombres = new Zend_Form_Element_Text("nombres");
		$eNombres->setLabel("Nombres: ");
		$eNombres->setAttrib("class", "form-control");
		
		$eApellidos = new Zend_Form_Element_Text("apellidos");
		$eApellidos->setLabel("Apellidos: ");
		$eApellidos->setAttrib("class", "form-control");
		
		$sub->addElements(array($eUsuario, $ePassword, $eNombres, $eApellidos));
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear Usuario");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addSubForms(array($sub));
		$this->addElement($eSubmit);
    }


}

