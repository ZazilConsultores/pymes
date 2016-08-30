<?php

class Contabilidad_Form_Impuestos extends Zend_Form
{

    public function init()
    {
    	$decoratorsPresentacion = array(
			'FormElements',
			array(array('tabla'=>'Htmltag'),array('tag'=>'table', 'class'=>'table table-striped table-condensed')),
			array('Fieldset', array('placement'=>'prepend'))
		);
		$decoratorsElemento =array(
			'ViewHelper',
			array(array('element'=>'HtmlTag'), array('tag'=>'td')),
			array('label', array('tag'=>'td')),
			array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
		);
		
    	$subImpuestos = new Zend_Form_SubForm;
		$subImpuestos->setLegend("Impuestos");
		
        /* Form Elements & Other Definitions Here ... */
        $eIva = new Zend_Form_Element_Text('iva');
		$eIva->setLabel('IVA:');
		$eIva->setAttrib("class", "form-control");
		$eIva->setAttrib("required","true");
		
		$eISH = new Zend_Form_Element_Text('ish');
		$eISH->setLabel('ISH:');
		$eISH->setAttrib("class", "form-control");
		$eISH->setAttrib("required","true");
		
		$eISR = new Zend_Form_Element('isr');  
		$eISR->setLabel('ISR:');
		$eISR->setAttrib("class", "form-control");
		$eISR->setAttrib("required","true");
		
		$eIEPS = new Zend_Form_Element_Text('ieps');
		$eIEPS->setLabel('IEPS:');
		$eIEPS->setAttrib("class", "form-control");
		$eIEPS->setAttrib("required","true");
		
		$eDescuento = new Zend_Form_Element_Text('descuento');
		$eDescuento->setLabel('Descuento:');
		$eDescuento->setAttrib("class", "form-control");
		$eDescuento->setAttrib("required","true");
		
		$eSubtotal = new Zend_Form_Element_Text('subtotal');
		$eSubtotal->setLabel('Subtotal:');
		$eSubtotal->setAttrib("class", "form-control");
		$eSubtotal->setAttrib("required","true");
		
		$eTotal = new Zend_Form_Element_Text('total');
		$eTotal->setLabel('Total:');
		$eTotal->setAttrib("class", "form-control");
		$eTotal->setAttrib("required","true");
		
		$subImpuestos->addElements(array($eIva,$eISH,$eISR,$eIEPS,$eDescuento,$eSubtotal,$eTotal));
		$subImpuestos->setElementDecorators($decoratorsElemento);
		$subImpuestos->setDecorators($decoratorsPresentacion);
		$this->addSubForms(array($subImpuestos));
		
		
		}

}

