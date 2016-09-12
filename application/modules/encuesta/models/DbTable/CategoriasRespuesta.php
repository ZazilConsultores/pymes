<?php

class Encuesta_Model_DbTable_CategoriasRespuesta extends Zend_Db_Table_Abstract
{

    protected $_name = 'CategoriasRespuesta';
	
	public function __construct() {
		$dbAdapter = Zend_Db::factory('PDO_MYSQL',Zend_Registry::get('dbconfigmodencuesta'));
		$this->setDefaultAdapter($dbAdapter);
	}
}

