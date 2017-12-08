<?php

interface Contabilidad_Interfaces_IPoliza {
	
	public function generacxc($datos);
	public function generacxp($datos);
	public function generacxc_Fo($datos);
	public function generacxp_Fo($datos);
	public function generaCompra();
	public function generaVenta();
	public function generacxpRemisiones($datos);
	
	public function generaGruposFacturaProveedor($datos);
	public function generaGruposFacturaCliente($datos);
	
	public function busca_Tipo($Persona,$Empresa); // Busca si es cliente o Proveedor;	
	public function busca_Proveedor($Persona,$Empresa); //$Empresa = EmpresaProveedor o solo Proveedor	
	public function genera_Poliza_F($modulo, $tipo, $iva);
	public function armaDescripcion($banco, $guia);
	public function busca_SubCuenta($persona, $origen);
	//public function busca_SubCuenta($persona, $origen);
	public function arma_Cuenta($nivel, $posicion, $subCta, $sub1, $sub2, $sub3, $sub4, $sub5);
	//public function arma_Cuenta($nivel, $posicion);
	public function crear_Texto();
	
}