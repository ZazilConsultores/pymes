
<?php

class Contabilidad_Form_AgregarNomina extends Zend_Form

{

    public function init()

    {
    	$decoratorsPresentacion = array(
    		'FormElements',
    		array(array('tabla'=>'Htmltag'),array('tag'=>'table','class'=>'table table-striped table-condensed')),
    		array('Fieldset', array('placement'=>'prepend'))
		);
		
		$decoratorsElemento = array(
			'ViewHelper',
			array(array('element'=>'HtmlTag'), array('tag'=>'td')),
			array('label',array('tag'=>'td')),
			array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
		);
		
		$subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend("Nuevo Fondeo");
		
		$eTipoMovimiento = new Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovimiento->setLabel('Tipo Movimiento:');
		$eTipoMovimiento->setAttrib("class", "form-control");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tipoMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();

		foreach($tipoMovimientos as $tipoMovimiento){
			if($tipoMovimiento->getIdTipoMovimiento()=="20"){
				$eTipoMovimiento->addMultiOption($tipoMovimiento->getIdTipoMovimiento(), $tipoMovimiento->getDescripcion());
			}
			
		}
		
		$subEmpresa = new Zend_Form_SubForm();
		$subEmpresa->setLegend("Seleccionar Empresa");
		
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
    	$eEmpresa =  new Zend_Form_Element_Select('idEmpresas');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel('Sucursal:');
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setAttrib("required","true");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		$tablaProveedores = new Contabilidad_DAO_Tesoreria;
		$rowset = $tablaProveedores->obtenerEmpleadosNomina();
		
		$eProveedor = new Zend_Form_Element_Select('idCoP');
		$eProveedor->setLabel('Seleccionar Empleado:');
		$eProveedor->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eProveedor->addMultiOption($fila->idProveedores, $fila->razonSocial);
		}
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Seleccionar fecha:');
		$eFecha->setAttrib("class", "form-control");
		$eFecha->setAttrib("required","true");
		
		$eNumFolio = new Zend_Form_Element_Text('numFolio');
		$eNumFolio->setLabel('Ingresar número de Folio');
		$eNumFolio->setAttrib("class", "form-control");
		$eNumFolio->setValue(0);
		$eNumFolio->setAttrib("required", "true");
		
		$eFolioFiscal = new Zend_Form_Element_Text('folioFiscal');
		$eFolioFiscal->setLabel('Ingresar Folio Fiscal:');
		$eFolioFiscal->setAttrib("class", "form-control");
		$eFolioFiscal->setAttrib("minlength", "32");
		$eFolioFiscal->setAttrib("maxlength", "32" );
		$eFolioFiscal->setAttrib("required", "true");  
		 
		$subEmpresa->addElements(array($eTipoMovimiento,$eEmpresa,$eSucursal,$eProveedor,$eFecha, $eNumFolio, $eFolioFiscal));
		$subEmpresa->setElementDecorators($decoratorsElemento);
		$subEmpresa->setDecorators($decoratorsPresentacion);
		
		//=================================================================>>
		$subDatosNomina = new Zend_Form_SubForm();
		$subDatosNomina->setLegend("Ingresar Datos:");
		
		$eSueldo = new Zend_Form_Element_Text('sueldo');
		$eSueldo->setLabel('Sueldos y Salarios:');
		$eSueldo->setAttrib("class", "form-control");
		$eSueldo->setValue(0);
		
		$eSubsidio =  new Zend_Form_Element_Text('subsidio');
		$eSubsidio->setLabel('Subsidio / Importe Exento:');
		$eSubsidio->setAttrib("class", "form-control");
		$eSubsidio->setValue(0);
		
		/*$eImpuestoImss = new Zend_Form_Element_Select('idImss');
		//$eImpuestoImss->setLabel('IMSS:');
		$eImpuestoImss->setAttrib("class", "form-control");
		
		
		$impuestoDAO = new Contabilidad_DAO_Impuesto;
		$impuestos = $impuestoDAO->obtenerImpuestos();

		foreach($impuestos as $impuesto){
			if($impuesto->getIdImpuesto()=="36"){
				$eImpuestoImss->addMultiOption($impuesto->getIdImpuesto(), $impuesto->getAbreviatura());
			}
		}*/
		
		$eIMSS = new Zend_Form_Element_Text('imss');
		$eIMSS->setLabel('IMSS:');
		//$eIMSS->setAttrib("id", "36");
		$eIMSS->setAttrib("class", "form-control");
		$eIMSS->setValue(0);
		
		/*$eImpuestoISPT = new Zend_Form_Element_Select('idISPT');
		$eImpuestoISPT->setLabel('ISPT:');
		$eImpuestoISPT->setAttrib("class", "form-control");
		
		foreach($impuestos as $impuesto){
			if($impuesto->getIdImpuesto()=="37"){
				$eImpuestoISPT->addMultiOption($impuesto->getIdImpuesto(), $impuesto->getAbreviatura());
			}
			
		}*/

		$eISPT = new Zend_Form_Element_Text('ispt');
		$eISPT->setLabel('ISPT / ISR:');
		$eISPT->setAttrib("class", "form-control");
		$eISPT->setValue(0);
		
		$eNominaxPagar = new Zend_Form_Element_Text('nominaxpagar');
		$eNominaxPagar->setLabel("Nomina por Pagar:");
		$eNominaxPagar->setAttrib("class", "form-control");
		//$eNominaxPagar->setAttrib("disabled", "true");
		
		$eSubmit =  new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		//$subEmpresa->addElements(array($eTipoMovimiento,$eEmpresa,$eSucursal,$eProveedor,$eFecha, $eNumFolio));
		$subDatosNomina->addElements(array($eSueldo,$eSubsidio, $eIMSS, $eISPT,$eNominaxPagar));
		$subDatosNomina->setElementDecorators($decoratorsElemento);
		$subDatosNomina->setDecorators($decoratorsPresentacion);
	
		//$this->addElement($eImpuestoImss);
		//$eImpuestoImss->setElementDecorators($decoratorsElemento);
		//$eImpuestoImss->setDecorators($decoratorsPresentacion);
		
		
		$this->addSubForms(array($subEmpresa,$subDatosNomina));
		$this->addElement($eSubmit);
       
	}
}


