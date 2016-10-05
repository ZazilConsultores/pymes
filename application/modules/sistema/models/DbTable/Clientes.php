<?php

class Sistema_Model_DbTable_Clientes extends Zend_Db_Table_Abstract
{

    protected $_name = 'Clientes';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

