<?php

class Sistema_Model_DbTable_Empresa extends Zend_Db_Table_Abstract
{

    protected $_name = 'Empresa';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

