<?php

class Sistema_Model_DbTable_Proveedores extends Zend_Db_Table_Abstract
{

    protected $_name = 'Proveedores';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

