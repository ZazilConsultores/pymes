<?php

class Encuesta_Form_AltaSeleccion extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        /*
        $tablaOpcion = new Encuesta_Model_DbTable_Opcion;
		$rowsetOpciones = $tablaOpcion->fetchAll();
		
		//$eOpciones = new Zend_Form_Element_Multiselect("opciones");
		$eOpciones = new Zend_Form_Element_MultiCheckbox("opciones");
		$eOpciones->setLabel("Opciones Disponibles:");
		//$eOpciones->setAttrib("class", "form-control");
		
		foreach ($rowsetOpciones as $opcion) {
			$eOpciones->addMultiOption($opcion->idOpcion, $opcion->opcion);
		}
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Guardar Opciones");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eOpciones);
		$this->addElement($eSubmit);
		*/
		$categoriaDAO = new Encuesta_DAO_Categoria;
		$opcionDAO = new Encuesta_DAO_Opcion;
		
		$modelCategorias = $categoriaDAO->obtenerCategorias();
		
		foreach ($modelCategorias as $modelCategoria) {
			$sub = new Zend_Form_SubForm;
			$sub->setLegend($modelCategoria->getCategoria() . " :: " . $modelCategoria->getDescripcion());
			$modelOpciones = $categoriaDAO->obtenerOpciones($modelCategoria->getIdCategoria());
			$eElement = new Zend_Form_Element_MultiCheckbox($modelCategoria->getIdCategoria());
			foreach ($modelOpciones as $modelOpcion) {
				$eElement->addMultiOption($modelOpcion->getIdOpcion(), $modelOpcion->getOpcion());
			}
			$sub->addElement($eElement);
			$this->addSubForm($sub, $modelCategoria->getIdCategoria());
		}
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Guardar Opciones");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eSubmit);
    }


}

