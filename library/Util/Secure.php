<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Util_Secure {
	
	public static function generateKey(array $datos, $algo)
	{
		$firma = implode(",", $datos);
		$hash = hash($algo, $firma);
		
		return $hash;
	}
}
