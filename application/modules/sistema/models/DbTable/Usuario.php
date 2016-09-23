<?php

class Sistema_Model_DbTable_Usuario extends Zend_Db_Table_Abstract
{

    protected $_name = 'Usuario';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

