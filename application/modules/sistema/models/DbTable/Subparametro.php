<?php

class Sistema_Model_DbTable_Subparametro extends Zend_Db_Table_Abstract
{

    protected $_name = 'Subparametro';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

