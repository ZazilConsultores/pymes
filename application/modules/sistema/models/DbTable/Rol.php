<?php

class Sistema_Model_DbTable_Rol extends Zend_Db_Table_Abstract
{

    protected $_name = 'Rol';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

