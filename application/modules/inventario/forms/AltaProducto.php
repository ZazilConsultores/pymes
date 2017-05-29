<?php	

class Inventario_Form_AltaProducto extends Zend_Form
{

    public function init()
    {
    	$subConfiguracion = new Zend_Form_SubForm();
		$subConfiguracion->setLegend("Configuracion de Producto");
 		//===================================================================================>>>>
    	
		$parametroDAO = new Inventario_DAO_Parametro;		
		$subparametroDAO = new Sistema_DAO_Subparametro;
		
		$parametros = $parametroDAO->obtenerParametros();
		
		foreach ($parametros as $parametro){
			$subparametros= $subparametroDAO->obtenerSubparametros($parametro->getIdParametro());		
			$elemento = new Zend_Form_Element_Select($parametro->getIdParametro());
			$elemento->setLabel($parametro->getParametro());
			$elemento->setRegisterInArrayValidator(FALSE);	
			$elemento->addMultiOption("0","Seleccione opcion");
			$elemento->setAttrib('required' , 'true');
			$elemento->setAttrib("class", "form-control");
				
			foreach ($subparametros as $subparametro ){
				$elemento->addMultiOption($subparametro->getIdSubparametro(), $subparametro->getSubparametro());
			}
		$subConfiguracion->addElement($elemento);
		
		}
		
		//$subDetalle = new Zend_Form_SubForm();
		//$subDetalle->setLegend("Detalle Producto");
		//===================================================================================>>>>		
		
		/*Descripcion */
		$eProducto = new Zend_Form_Element_Text('producto');
		$eProducto->setLabel('Producto:');
		$eProducto->setAttrib('class','form-control');
		$eProducto->setAttrib('required' , 'true');
		$eClaveProducto = new Zend_Form_Element_Hidden("claveProducto");
		//$eClaveProducto->setLabel('Clave Producto:');
		//$eClaveProducto->setAttrib('class','form-control');
		
		//$eIdsSubparametro = new Zend_Form_Element_Hidden("idsSubparametro");
		
		$eCodigoBarras = new Zend_Form_Element_Text('codigoBarras');
		$eCodigoBarras->setLabel('Codigo de Barras:');
		$eCodigoBarras->setValue('-');
		$eCodigoBarras->setAttrib('class','form-control');
		
		//$subDetalle->addElements(array($eProducto,$eClaveProducto, $eCodigoBarras));
		
		$eAgregar = new Zend_Form_Element_Submit('submit');
		$eAgregar->setLabel('Agregar Producto');
		$eAgregar->setAttrib("class", "btn btn-success");
		//============================Agregamos Subformas=====================================================>>>>		
		//$this->addElement($elemento);
		$this->addSubForms(array($subConfiguracion));
		//$this->addSubForms(array($subDetalle));
    	//$this->addElement($Configuracion);
    	$this->addElement($eProducto);
		$this->addElement($eClaveProducto);
		$this->addElement($eCodigoBarras);
		//$this->addElement($eIdsSubparametro);
	//	$this->addElement($eProducto);
    	
		
    
    	$this->addElement($eAgregar);
	}//cierra el public
	
}//cierra el Zend_Form

