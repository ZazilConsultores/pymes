<?php

class Sistema_Model_DbTable_FiscalesTelefonos extends Zend_Db_Table_Abstract
{

    protected $_name = 'FiscalesTelefonos';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

