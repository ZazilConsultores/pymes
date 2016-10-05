<?php

class Sistema_Model_DbTable_Sucursal extends Zend_Db_Table_Abstract
{

    protected $_name = 'Sucursal';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

