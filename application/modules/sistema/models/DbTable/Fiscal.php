<?php

class Sistema_Model_DbTable_Fiscal extends Zend_Db_Table_Abstract
{

    protected $_name = 'Fiscal';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

