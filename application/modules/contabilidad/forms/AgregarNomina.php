
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
		$subEmpresa = new Zend_Form_SubForm();
		
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
		
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
    	$eEmpresa =  new Zend_Form_Element_Select('idEmpresas');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idEmpresas, $fila->razonSocial);
		}
		
		$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel('Sucursal:');
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setAttrib("required","true");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		$eProyecto =  new Zend_Form_Element_Select('idProyecto');
        $eProyecto->setLabel("Seleccionar Proyecto:");
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setRegisterInArrayValidator(FALSE);
		
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
		
		$formaPago = Zend_Registry::get('formaPago');
		$eFormaLiquidar = new Zend_Form_Element_Select('formaLiquidar');
		$eFormaLiquidar->setLabel('Forma Pago:');
		$eFormaLiquidar->setAttrib("class", "form-control");
		$eFormaLiquidar->setMultiOptions($formaPago);
		
		$eNumReferencia = new Zend_Form_Element_Text('numeroReferencia');
		$eNumReferencia->setLabel('Ingresar Número de Referencia:');
		$eNumReferencia->setAttrib("class", "form-control");
		$eNumReferencia;
		
		$eBanco = new Zend_Form_Element_Select('idBanco');
		$eBanco->setLabel('Seleccionar Banco');
		$eBanco->setAttrib("class", "form-control");  
		$eBanco->setRegisterInArrayValidator(FALSE);
		
		$ePagada = new Zend_Form_Element_Checkbox('pagada');
		$ePagada->setLabel("Pago nómina:");
		//$ePagada->setCheckedValue("1");
		$ePagada->setChecked("checked");
		
		$subEmpresa->addElements(array($eTipoMovimiento,$eEmpresa,$eSucursal,$eProyecto,$eProveedor,$eFecha, $eNumFolio,$eFolioFiscal,$ePagada,$eFormaLiquidar,$eBanco,$eNumReferencia));
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
		
		$eIMSS = new Zend_Form_Element_Text('IMSS');
		$eIMSS->setLabel('IMSS:');
		//$eIMSS->setAttrib("id", "36");
		$eIMSS->setAttrib("class", "form-control");
		$eIMSS->setValue(0);
		
		$eISPT = new Zend_Form_Element_Text('ISPT');
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


