<?php

class Sistema_Model_DbTable_FiscalesDomicilios extends Zend_Db_Table_Abstract
{

    protected $_name = 'FiscalesDomicilios';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

