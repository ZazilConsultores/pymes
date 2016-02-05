<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */

class Sistema_Model_Email
{
	private $idEmail;

    public function getIdEmail() {
        return $this->idEmail;
    }
    
    public function setIdEmail($idEmail) {
        $this->idEmail = $idEmail;
    }

    private $email;

    public function getEmail() {
        return $this->email;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
	
	private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
	
	private $fecha;

    function getFecha() {
        return $this->fecha;
    }
    
    function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    
    private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->hash = Util_Secure::generateKey($this->toArray());
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos)
    {
    	if(array_key_exists("idEmail", $datos)) $this->idEmail = $datos["idEmail"];
        $this->email = $datos["email"];
		if(array_key_exists("descripcion", $datos)) $this->descripcion = $datos["descripcion"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idEmail"] = $this->idEmail;
		$datos["email"] = $this->email;
		$datos["descripcion"] = $this->descripcion;
		$datos["fecha"] = $this->fecha;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
	


}

