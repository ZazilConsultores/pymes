<?php

class Sistema_Model_DbTable_Estado extends Zend_Db_Table_Abstract
{

    protected $_name = 'Estado';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

