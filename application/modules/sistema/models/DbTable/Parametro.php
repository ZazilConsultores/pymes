<?php

class Sistema_Model_DbTable_Parametro extends Zend_Db_Table_Abstract
{

    protected $_name = 'Parametro';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

