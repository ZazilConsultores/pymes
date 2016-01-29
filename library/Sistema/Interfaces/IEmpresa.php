<?php

interface Sistema_Interfaces_IEmpresa {
	public function obtenerEmpresa($idEmpresa);
	public function obtenerEmpresas();
	public function crearEmpresa(Sistema_Model_Empresa $empresa);
}
