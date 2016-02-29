<?php	

class Inventario_Form_AltaProducto extends Zend_Form
{

    public function init()
    {
        //===================================================================================>>>>
		$subConfiguracion = new Zend_Form_SubForm();
		$subConfiguracion->setLegend("Configuracion de Producto");
		
		$parametroDAO = new Inventario_DAO_Parametro;
		$subparametroDAO = new Sistema_DAO_Subparametro;
		
	
		$parametros = $parametroDAO->obtenerParametros();
		
		foreach ($parametros as $parametro) {
			$subparametros = $subparametroDAO->obtenerSubparametros($parametro->getIdParametro());
			$elemento = new Zend_Form_Element_Select($parametro->getIdParametro());
			$elemento->setLabel($parametro->getParametro());
			$elemento->setAttrib("class", "form-control");
			$elemento->addMultiOption("0","Seleccione opcion");
			foreach ($subparametros as $subparametro) {
				$elemento->addMultiOption($subparametro->getIdSubparametro(),$subparametro->getSubparametro());	
				$elemento->setRegisterInArrayValidator(FALSE);
			}
			
			
			$subConfiguracion->addElement($elemento);
			
		}
       	$subDetalle = new Zend_Form_SubForm();
		$subDetalle->setLegend("Detalle Producto");
		
		/*Descripcion */
		$eProducto = new Zend_Form_Element_Text('producto');
		$eProducto->setLabel('Descripcion:');
		$eProducto->setAttrib('class','form-control');
		
	
		$eCodigoBarras = new Zend_Form_Element_Text('codigoBarras');
		$eCodigoBarras->setLabel('Codigo de Barras:');
		$eCodigoBarras->setValue('-');
		$eCodigoBarras->setAttrib('class','form-control');
		
		/*Presentacion*/		
		$subPresentacion = new Zend_Form_SubForm();
		$subPresentacion->setLegend("Presentacion:");
		
		$unidadDAO = new Inventario_DAO_Unidad;
		$unidades = $unidadDAO->obtenerUnidades();
		
		$eCantidad = new Zend_Form_Element_Text('cantidad');
		$eCantidad->setLabel('Cantidad:');
		$eCantidad->setAttrib('class','form-control');
		
		$ePresentacion = new Zend_Form_Element_Select('unidad');
		$ePresentacion->setLabel('Presentacion:');
		$ePresentacion->setAttrib('class','form-control');
		
		foreach ($unidades as $unidad) {
			$ePresentacion->addMultiOption($unidad->getIdUnidad(),$unidad->getUnidad());
		}
		
		$eAgregar = new Zend_Form_Element_Submit('submit');
		$eAgregar->setLabel('Agregar Producto');
		$eAgregar->setAttrib("class", "btn btn-success");
		
		$eClaveProducto = new Zend_Form_Element_Text('claveProducto');
		$eClaveProducto->setLabel('Clave Producto:');
		$eClaveProducto->setAttrib('class','form-control');	
		//$eClaveProducto = $subparametro->getSubparametro();
		//$subConfiguracion->addElements(array($eTipoArticulo));
		$subDetalle->addElements(array( $eClaveProducto,$eProducto, $eCodigoBarras));
		$subPresentacion->addElements(array($eCantidad,$ePresentacion));
		//$subForm->addElements(array($eTipoArticulo, $eSubtipo,$eMarcas, $eMedidas,$eColores,$eModelo,$eLargo,$eProducto,$eClaveProducto,$eCodigoBarras,$eAgregar));
	
		$this->addSubForms(array($subConfiguracion,$subDetalle, $subPresentacion));
		
		$this->addElement($eAgregar);
		
		//$this->addElements(array($eTipoArticulo, $eSubtipo, $eMarcas,$eMedidas,$eColores,$eModelo,$eLargo,$eProducto,$eClaveProducto, $eCodigoBarras,$eAgregar));

		
	}
		
}

