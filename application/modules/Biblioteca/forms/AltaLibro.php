<?php

class Biblioteca_Form_AltaLibro extends Zend_Dojo_Form
{


	public function init()
	{
		
		$this->setDecorators(array(
		'FormElements',
		array('TabContainer',array(
			'id' =>'tabContainer',
			'style' =>'width: 600px; height:500px;',
			'dijitParams'=> array(
					'tabPosition'=>'top'
			),
					
		)),
			'DijitForm',		
		));
		
		$subform1=new Zend_Dojo_Form_SubForm();
		$subform1->setAttribs(array(
			'name'=> 'textboxtab',
			'legend'=>'Text Elements',
			'dijitParams'=>array(
					'title'=>'Text Elements'),
		));
		
		/*
		$subform1->addElement(
		'');
		*/
		
			/*$this->addSubForm($subForm1);*/
	}
	

	
	
	
	}