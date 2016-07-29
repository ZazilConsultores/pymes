<?php

interface Contabilidad_Interfaces_IFondeo {
	
	public function obtenerBancosEmpresas();
	public function obtenerBancosEmpresa($idBanco);
	public function guardarFondeo(array $encabezado);

}
