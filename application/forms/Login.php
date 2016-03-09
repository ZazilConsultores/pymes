<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eUsuario = new Zend_Form_Element_Text("usuario");
		$eUsuario->setLabel("Usuario: ");
        $eUsuario->setAttrib("class", "form-control");
		$eUsuario->setAttrib("placeholder", "Proporcione un usuario");
		$eUsuario->setAttrib("required", "required");
        
		$ePassword = new Zend_Form_Element_Password("password");
        $ePassword->setLabel("Password: ");
		$ePassword->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Acceder");
		$eSubmit->setAttrib("class", "btn btn-info");
		
		$this->addElements(array($eUsuario,$ePassword,$eSubmit));
		
    }


}

