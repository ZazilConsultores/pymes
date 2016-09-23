<?php

class Sistema_Model_DbTable_Fiscales extends Zend_Db_Table_Abstract
{

    protected $_name = 'Fiscales';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

