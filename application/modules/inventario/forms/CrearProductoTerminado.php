<?php

class Inventario_Form_CrearProductoTerminado extends Zend_Form
{

    public function init()
    {
        $parametroDAO = new Inventario_DAO_Parametro;		
		$subparametroDAO = new Sistema_DAO_Subparametro;
		
		//$subparametros= $subparametroDAO->obtenerSubparametroBebida($idSubparametro = 2);		
			/*$elemento = new Zend_Form_Element_Select($subparametros->getIdParametro());
			$elemento->setLabel($subparametros->getParametro());
			$elemento->setRegisterInArrayValidator(FALSE);	
			$elemento->addMultiOption("0","Seleccione opcion");
			$elemento->setAttrib('required' , 'true');
			$elemento->setAttrib("class", "form-control");
				
			foreach ($subparametros as $subparametro){
				$elemento->addMultiOption($subparametro->getIdParametro(), $subparametro->getSubparametro());
			}*/
		$parametroDAO = new Sistema_DAO_Subparametro;;
		$rowset = $parametroDAO->obtenerSubparametroBebida();
		
		$eSuBebida = new Zend_Form_Element_Select('subBedidas');
		$eSuBebida->setLabel('Seleccionar Bebida: ');
		$eSuBebida->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eSuBebida->addMultiOption($fila->idProducto, $fila->producto);
		}
		
		$rowset = $parametroDAO->obtenerSubparametroAbarrotes();
		$eSubAbarrotes = new Zend_Form_Element_Select('subAbarrotes');
		$eSubAbarrotes->setLabel('Seleccionar Abarrote: ');
		$eSubAbarrotes->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eSubAbarrotes->addMultiOption($fila->idProducto, $fila->producto);
		}
		$this->addElement($eSuBebida);
		$this->addElement($eSubAbarrotes);
		
		
    }


}

