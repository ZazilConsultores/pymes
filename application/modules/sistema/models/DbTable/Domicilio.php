<?php

class Sistema_Model_DbTable_Domicilio extends Zend_Db_Table_Abstract
{

    protected $_name = 'Domicilio';
	
	public function getAdapter() {
		$registry = Zend_Registry::getInstance();
		return $registry['dbmodgeneral'];
	}
}

