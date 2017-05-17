<?php

class Contabilidad_Form_GuiaContable extends Zend_Form
{

    public function init()
    {
           $decoratorsCategoria = array(
			//'Fieldset',
			'FormElements',
			//array(array('body' => 'HtmlTag'), array('tag' => 'tbody')),
			array(array('tabla' => 'HtmlTag'), array('tag' => 'table', 'class' => 'table table-striped table-condensed')),
			array('Fieldset', array('placement' => 'prepend')),
			//array(array('element' => 'HtmlTag'), array('tag' => 'td', 'colspan' => '2')),
			//array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		);
		
		$decoratorsElemento = array(
			'ViewHelper', //array('ViewHelper', array('class' => 'form-control') ), //'ViewHelper', 
			array(array('element' => 'HtmlTag'), array('tag' => 'td')), 
			array('label', array('tag' => 'td') ), 
			//array('Description', array('tag' => 'td', 'class' => 'label')), 
			array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		);
		
		$subCuenta = new Zend_Form_SubForm();
		$subCuenta->setLegend("Datos Cuenta Contable");
		
		$eCuenta = new Zend_Form_Element_Text("cta");
		$eCuenta->setAttrib("class", "form-control");
		$eCuenta->setLabel("Cuenta: ");
		$eCuenta->setAttrib("maxlength", "3");
		$eCuenta->setAttrib("minlength", "3");
		$eCuenta->setAttrib("required", "required");
		
		$eDescripcion = new Zend_Form_Element_Text("descripcion");
		$eDescripcion->setAttrib("class", "form-control");
		$eDescripcion->setLabel("Descripción: ");
		$eCuenta->setAttrib("required", "required");
		
		$eSub1 = new Zend_Form_Element_Text("sub1");
		$eSub1->setAttrib("class", "form-control");
		$eSub1->setLabel("Subcuenta 1: ");
		$eSub1->setAttrib("maxlength", "4");
		$eSub1->setAttrib("minlength", "4");
		$eSub1->setAttrib("required", "required");
		
		$eSub2 = new Zend_Form_Element_Text("sub2");
		$eSub2->setAttrib("class", "form-control");
		$eSub2->setLabel("Subcuenta 2: ");
		$eSub2->setAttrib("maxlength", "4");
		$eSub2->setAttrib("minlength", "4");
		$eSub2->setAttrib("required", "required");
		
		$eSub3 = new Zend_Form_Element_Text("sub3");
		$eSub3->setAttrib("class", "form-control");
		$eSub3->setLabel("Suncuenta 3: ");
		$eSub3->setAttrib("maxlength", "3");
		$eSub3->setAttrib("minlength", "3");
		$eSub3->setAttrib("required", "required");
		
		$eSub4 = new Zend_Form_Element_Text("sub4");
		$eSub4->setAttrib("class", "form-control");
		$eSub4->setLabel("Subcuenta 4: ");
		$eSub4->setAttrib("required", "required");
		
		$eSub5 = new Zend_Form_Element_Text("sub5");
		$eSub5->setAttrib("class", "form-control");
		$eSub5->setLabel("Subcuenta 5: ");
		$eSub5->setAttrib("required", "required");
		
		$subParametros = new Zend_Form_SubForm();
		$subParametros->setLegend("Parametros");
		
		$modulosDAO = new Contabilidad_DAO_GuiaContable;
		$modulos = $modulosDAO->obtenerModulos();
		
		$eModulo = new Zend_Form_Element_Select("idModulo");
		$eModulo->setAttrib("class", "form-control");
		$eModulo->setLabel("Seleccionar Módulo: ");
		
		foreach ($modulos as $modulo) {
			$eModulo->addMultiOption($modulo["idModulo"] , $modulo["descripcion"]);
		}
		
		$tiposProvDAO = new Sistema_DAO_Empresa;
		$tipos = $tiposProvDAO->obtenerTipoProveedor();
		
		$eTipoProv = new Zend_Form_Element_select("idTipoProveedor");
		$eTipoProv->setAttrib("class", "form-control");
		$eTipoProv->setLabel("Descripción Tipo Proveedor: ");
		
		foreach ($tipos as $tipo) {
			$eTipoProv->addMultiOption($tipo["idTipoProveedor"] , $tipo["descripcion"]);
		}
	
		$eCargo = new Zend_Form_Element_Checkbox("cargo");
		$eCargo->setLabel("Cargo:");
		
		$eAbono = new Zend_Form_Element_Checkbox("abono");
		$eAbono->setLabel("Abono:");
		
		$origen = Zend_Registry::get('origen');
		$eOrigen = new Zend_Form_Element_Select("origen");
		$eOrigen->setLabel('Origen:');
		$eOrigen->setAttrib("class", "form-control");
		$eOrigen->setMultiOptions($origen);
		//$eCargo->setAttrib("class", "form-control");
		/*$eClaveProv = new Zend_Form_Element_Text("clave");
		$eClaveProv->setAttrib("class", "form-control");
		$eClaveProv->setAttrib("maxlength", "2");
		$eClaveProv->setLabel("Clave Proveedor: ");
		$eClaveProv->setAttrib("required", "required");*/
	
		$subCuenta->addElements(array($eCuenta, $eDescripcion, $eSub1,$eSub2,$eSub3,$eSub4,$eSub5));
		$subCuenta->setElementDecorators($decoratorsElemento);
		$subCuenta->setDecorators($decoratorsCategoria);
		
		$subParametros->addElements(array($eModulo, $eTipoProv, $eCargo, $eAbono, $eOrigen));
		$subParametros->setElementDecorators($decoratorsElemento);
		$subParametros->setDecorators($decoratorsCategoria);
		
		$this->addSubForms(array($subCuenta, $subParametros));
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eSubmit);
		
    }
	

}

