<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_Form_AltaParametro extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $subWrapper = new Zend_Form_SubForm;
		$subWrapper->setLegend("Alta de Parametro");
		
        $eParametro = new Zend_Form_Element_Text("parametro");
		$eParametro->setLabel("Parametro: ");
		$eParametro->setAttrib("class", "form-control");
		
		$eDescripcion = new Zend_Form_Element_Text("descripcion");
		$eDescripcion->setLabel("Descripcion: ");
		$eDescripcion->setAttrib("class", "form-control");
		
		$subWrapper->addElements(array($eParametro,$eDescripcion));
        
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear Parametro");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addSubForms(array($subWrapper));
		$this->addElement($eSubmit);
    }
}

