<?php

interface Sistema_Interfaces_IFiscales {
	public function obtenerFiscalesEmpresa();
	public function obtenerFiscalesCliente();
	public function obtenerFiscalesProveedor();
	public function crearEmpresa(Sistema_Model_Empresa $empresa);
}
