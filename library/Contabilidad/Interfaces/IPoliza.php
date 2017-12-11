<?php

interface Contabilidad_Interfaces_IPoliza {
	
	public function generacxc($datos);
	public function generacxp($datos);
	public function generacxc_Fo($datos);
	public function generacxp_Fo($datos);
	
	public function generacxpRemisiones($datos);
	
	public function generaGruposFacturaProveedor($datos);
	public function generaGruposFacturaCliente($datos);
	
	
	public function crear_Texto();
	
}