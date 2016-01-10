<?php

class Application_Model_Banco
{
	private $idBanco;

    public function getIdBanco() {
        return $this->idBanco;
    }
    
    public function setIdBanco($idBanco) {
        $this->idBanco = $idBanco;
    }

    private $banco;

    public function getBanco() {
        return $this->banco;
    }
    
    public function setBanco($banco) {
        $this->banco = $banco;
    }

    private $cuenta;

    public function getCuenta() {
        return $this->cuenta;
    }
    
    public function setCuenta($cuenta) {
        $this->cuenta = $cuenta;
    }

    private $tipo;

    public function getTipo() {
        return $this->tipo;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    private $saldo;

    public function getSaldo() {
        return $this->saldo;
    }
    
    public function setSaldo($saldo) {
        $this->saldo = $saldo;
    }

    public function __construct(array $datos)
    {
        $this->banco = $datos["banco"];
		$this->cuenta = $datos["cuenta"];
		$this->tipo = $datos["tipo"];
		$this->fecha = $datos["fecha"];
		$this->saldo = $datos["saldo"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idBanco"] = $this->idBanco;
		$datos["banco"] = $this->banco; 
		$datos["cuenta"] = $this->cuenta;
		$datos["tipo"] = $this->tipo;
		$datos["fecha"] = $this->fecha;
		$datos["saldo"] = $this->saldo;
	}
	 

}

