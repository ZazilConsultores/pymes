<?php

class Sistema_Form_AltaFiscales extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eRFC = new Zend_Form_Element_Text('rfc');
		$eRFC->setLabel('RFC:');
		$eRFC->setAttrib("class", "form-control");
		
		$eRazonSocial = new Zend_Form_Element_Text('razonSocial');
		$eRazonSocial->setLabel('Razon Social:');
		$eRazonSocial->setAttrib("class", "form-control");
		
		$eRFCAlfa = new Zend_Form_Element_Text('rfcAlfa');
		$eRFCAlfa->setLabel('RFCALFA:');
		$eRFCAlfa->setAttrib("class", "form-control");
		
		$eRFCNum = new Zend_Form_Element_Text('rfcNum');
		$eRFCNum->setLabel('RFCNUM:');
		$eRFCNum->setAttrib("class", "form-control");
		
		$eRFCHom= new Zend_Form_Element_Text('rfcHom');
		$eRFCHom->setLabel('RFCHOM:');
		$eRFCHom->setAttrib("class", "form-control");
		
		$eAgregar = new Zend_Form_Element_Submit('agregar');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		$this->addElement($eRFC);
		$this->addElement($eRazonSocial);
		$this->addElement($eRFCAlfa);
		$this->addElement($eRFCNum);
		$this->addElement($eRFCHom);
		$this->addElement($eAgregar);
		
    }


}

