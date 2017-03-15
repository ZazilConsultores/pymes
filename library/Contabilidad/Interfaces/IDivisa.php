<?php

interface Contabilidad_Interfaces_IDivisa {
	
	public function obtenerDivisas();
	public function obtenerDivisa($idDivisa);
	public function editaDivisa($idDivisa, array $divisa);
	public function nuevaDivisa(Contabilidad_Model_Divisa $divisa);

}