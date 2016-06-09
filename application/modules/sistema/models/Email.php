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
	
	public function __construct(array $datos)
    {
    	if(array_key_exists("idEmail", $datos)) $this->idEmail = $datos["idEmail"];
        $this->email = $datos["email"];
		$this->descripcion = $datos["descripcion"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idEmail"] = $this->idEmail;
		$datos["email"] = $this->email;
		$datos["descripcion"] = $this->descripcion;
		
		return $datos;
	}
	


}

