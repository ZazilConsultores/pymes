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

    public function __construct(array $datos)
    {
        $this->email = $datos["email"];
    }
	
	public function toArray()
	{
		//$datos = array();
		//$datos["email"] = $this->email;
		//return $datos;
		
		$datos = array();
		
		if(!is_null($this->idEmail)) $datos["idEmail"] = $this->idEmail;
		$datos["email"] = $this->email;
				
		return $datos;
	}
	


}

