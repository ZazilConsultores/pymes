<?php

class Contabilidad_Form_PagosProveedor extends Zend_Form
{

    public function init()
    {
    	$decoratorsPresentacion = array(
			'FormElements',
			//array(array('tabla'=>'Htmltag'),array('tag'=>'table', 'class'=>'table table-striped table-condensed')),
			array('Fieldset', array('placement'=>'prepend'))

		);
		
		/*$decoratorsElemento =array(
			
			'ViewHelper',
			array(array('element'=>'HtmlTag'), array('tag'=>'td')),
			array('label', array('tag'=>'td')),
			array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

		);*/

		$decoratorsElemento =array(
			/*Decoradores*/
			'ViewHelper',
			//array(array('element'=>'HtmlTag'), array('tag'=>'tr')),
			//array('element' => 'td', array('tag'=>'tr')),
			 //array(array('element'=>'HtmlTag'), array('tag'=>'td'), array(array('row'=>'HtmlTag'),array('tag'=>'td')))
			//array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
			array('element' =>'HtmlTag', array('tag' => 'tr', 'row' => 'HtmlTag'),array('tag'=>'tr'))

		);
		
    	$tablaFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablaFiscales->obtenerInformacionEmpresasIdFiscales();
		
		$eEmpresa = new Zend_Form_Element_Select('idEmpresas');     
    	$eEmpresa->setLabel('Seleccionar Empresa');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach($rowset as $fila){
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);	
		}
		
		$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel('Sucursal:');
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		$eSucursal->setAttrib("required", "true");
		
		$tablaEmpresa = new Contabilidad_DAO_NotaEntrada;
		$rowset = $tablaEmpresa->obtenerProveedores();
		
		$eProveedor = new Zend_Form_Element_Select('idCoP');
		$eProveedor->setLabel('Seleccionar Proveedor:');
		$eProveedor->setAttrib("class", "form-control");
		
		
		foreach ($rowset as $fila) {
			$eProveedor->addMultiOption($fila->idEmpresa, $fila->razonSocial);	
		}
		
		$eNumeroFactura = new Zend_Form_Element_Text('numeroFactura');
		$eNumeroFactura->setLabel('Ingresar Numero Factura');
		$eNumeroFactura->setAttrib("class", "form-control");
		$eNumeroFactura->setAttrib("required", "Ingresar Factura");
		$eNumeroFactura->setAttrib("placeholder", "Numero Factura");
		
		$eValores = new Zend_Form_Element_Hidden('valores');
		$eValores->setAttrib("class", "form-control");
		$eValores->setAttrib("required", "Ingresar Factura");

    	
		$subFoo = new Zend_Form_SubForm;
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Buscar Factura'); 
		$submit->setAttrib("class", "btn btn-success");
		
		$sCancelar = new Zend_Form_Element_Submit('cancelar');
		$sCancelar->setLabel('Cancelar'); 
		$sCancelar->setAttrib("class", "btn btn-info");
		
		
		$this->addElement($eEmpresa);
		$this->addElement($eSucursal);
		$this->addElement($eProveedor);
		$this->addElement($eNumeroFactura);
		//$this->addElement($eValores);
		$subFoo->addElements(array($submit,$sCancelar));
		$subFoo->setElementDecorators($decoratorsElemento);
		$subFoo->setDecorators($decoratorsPresentacion);
		//$this->addSubForm($subFoo);
		$this->addSubForm($subFoo, "pie");
    }


}

