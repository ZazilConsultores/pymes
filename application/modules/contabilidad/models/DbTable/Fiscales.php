<?php

class Contabilidad_Model_DbTable_Fiscales extends Zend_Db_Table_Abstract
{

    protected $_name = 'fiscales';
	
	public function obtenerColumnas($columnas)
	{
		if (is_array($columnas)) {
			$select = $this->select()->from($this, $columnas);
			return $this->fetchAll($select);
		}
	}


}

