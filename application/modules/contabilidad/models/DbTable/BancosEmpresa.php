<?php

class Contabilidad_Model_DbTable_BancosEmpresa extends Zend_Db_Table_Abstract
{

    protected $_name = 'BancosEmpresa';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}


}

