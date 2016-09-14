<?php

class Sistema_Model_DbTable_ClientesEmpresa extends Zend_Db_Table_Abstract
{

    protected $_name = 'ClientesEmpresa';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

