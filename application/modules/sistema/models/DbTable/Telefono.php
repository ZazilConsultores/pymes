<?php

class Sistema_Model_DbTable_Telefono extends Zend_Db_Table_Abstract
{

    protected $_name = 'Telefono';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

