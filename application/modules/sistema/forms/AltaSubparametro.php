<?php

class Sistema_Form_AltaSubparametro extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $subWrapper = new Zend_Form_SubForm;
		//$subWrapper->setLegend("Alta de Subparametro");
		
        $eSubparametro = new Zend_Form_Element_Text("subparametro");
		$eSubparametro->setLabel("Subparametro: ");
		//$eSubparametro->setAttrib("class", "form-control");
		//$eSubparametro->setAttrib("required");
		$eSubparametro->setAttrib("class", "form-control");
		$eSubparametro->setAttrib("required", "true");
		
		$eClaveSubparametro = new Zend_Form_Element_Text("claveSubparametro");
		$eClaveSubparametro->setLabel("Clave (2 Caracteres): ");
		
		$eClaveSubparametro->setAttrib("maxlength", "2");
		
		$eClaveSubparametro->setAttrib("class", "form-control");
		//$eClaveSubparametro->setAttrib("presence", "required");
		
		$subWrapper->addElements(array($eSubparametro,$eClaveSubparametro));
        
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear Subparametro");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addSubForms(array($subWrapper));
		$this->addElement($eSubmit);
    }


}

