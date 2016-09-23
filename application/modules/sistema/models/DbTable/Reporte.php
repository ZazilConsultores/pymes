<?php

class Sistema_Model_DbTable_Reporte extends Zend_Db_Table_Abstract
{

    protected $_name = 'Reporte';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

