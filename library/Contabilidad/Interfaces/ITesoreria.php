<?php

interface Contabilidad_Interfaces_ITesoreria {
	public function obtenerEmpleadosNomina();
	public function crearNomina( array $datos);
	
}