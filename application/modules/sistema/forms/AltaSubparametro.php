<?php

class Sistema_Form_AltaSubparametro extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $subWrapper = new Zend_Form_SubForm;
		$subWrapper->setLegend("Alta de Subparametro");
		
        $eSubparametro = new Zend_Form_Element_Text("subparametro");
		$eSubparametro->setLabel("Subparametro: ");
		$eSubparametro->setAttrib("class", "form-control");
		
		$eDescripcion = new Zend_Form_Element_Text("descripcion");
		$eDescripcion->setLabel("Descripcion: ");
		$eDescripcion->setAttrib("class", "form-control");
		
		$subWrapper->addElements(array($eSubparametro,$eDescripcion));
        
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear Subparametro");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addSubForms(array($subWrapper));
		$this->addElement($eSubmit);
    }


}

