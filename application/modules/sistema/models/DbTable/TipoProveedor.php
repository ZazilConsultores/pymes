<?php

class Sistema_Model_DbTable_TipoProveedor extends Zend_Db_Table_Abstract
{

    protected $_name = 'TipoProveedor';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

