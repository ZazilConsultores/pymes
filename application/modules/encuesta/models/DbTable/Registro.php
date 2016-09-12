<?php

class Encuesta_Model_DbTable_Registro extends Zend_Db_Table_Abstract
{

    protected $_name = 'Registro';
	
	public function __construct() {
		$dbAdapter = Zend_Db::factory('PDO_MYSQL',Zend_Registry::get('dbconfigmodencuesta'));
		$this->setDefaultAdapter($dbAdapter);
	}
}

