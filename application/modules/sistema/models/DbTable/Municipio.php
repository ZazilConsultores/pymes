<?php

class Sistema_Model_DbTable_Municipio extends Zend_Db_Table_Abstract
{

    protected $_name = 'Municipio';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

