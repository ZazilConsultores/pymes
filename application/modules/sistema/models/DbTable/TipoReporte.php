<?php

class Sistema_Model_DbTable_TipoReporte extends Zend_Db_Table_Abstract
{

    protected $_name = 'TipoReporte';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

