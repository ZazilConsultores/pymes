<?php

interface Inventario_Interfaces_IFiscales {
	public function obtenerFiscales($idEmpresa);
	public function obtenerDomicilios($idEmpresa);
	public function obtenerTelefonos($idEmpresa);
	public function obtenerEmails($idEmpresa);
}
