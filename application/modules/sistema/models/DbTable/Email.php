<?php

class Sistema_Model_DbTable_Email extends Zend_Db_Table_Abstract
{

    protected $_name = 'Email';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

