<?php

class Sistema_Model_DbTable_ProveedoresEmpresa extends Zend_Db_Table_Abstract
{

    protected $_name = 'ProveedoresEmpresa';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

