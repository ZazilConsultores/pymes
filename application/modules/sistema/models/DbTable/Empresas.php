<?php

class Sistema_Model_DbTable_Empresas extends Zend_Db_Table_Abstract
{

    protected $_name = 'Empresas';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

