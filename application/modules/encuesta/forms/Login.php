<?php

class Encuesta_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        
        $eClaveOrganizacion = new Zend_Form_Element_Text("claveOrganizacion");
        $eClaveOrganizacion->setLabel("Clave de la Organizacion:");
        $eClaveOrganizacion->setAttrib("class", "form-control");
        $eClaveOrganizacion->setAttrib("required", "required");
        $eClaveOrganizacion->setAttrib("autofocus", "");
        
        $eUsuario = new Zend_Form_Element_Text("usuario");
        $eUsuario->setLabel("Usuario: ");
        $eUsuario->setAttrib("class", "form-control");
        $eUsuario->setAttrib("required", "required");
        
        $ePassword = new Zend_Form_Element_Password("password");
        $ePassword->setLabel("Password: ");
        $ePassword->setAttrib("class", "form-control");
        $ePassword->setAttrib("required", "required");
        
        $eSubmit = new Zend_Form_Element_Submit("submit");
        $eSubmit->setLabel("Login");
        $eSubmit->setAttrib("class", "btn btn-info");
        
        $this->addElements(array($eClaveOrganizacion,$eUsuario,$ePassword,$eSubmit));
        
    }


}

