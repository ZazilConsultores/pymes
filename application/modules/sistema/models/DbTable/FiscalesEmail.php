<?php

class Sistema_Model_DbTable_FiscalesEmail extends Zend_Db_Table_Abstract
{

    protected $_name = 'FiscalesEmail';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

