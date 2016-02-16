<?php

class Contabilidad_Model_Banco
{
	private $idBanco;

    public function getIdBanco() {
        return $this->idBanco;
    }
    
    public function setIdBanco($idBanco) {
        $this->idBanco = $idBanco;
    }
	
	private $idDivisa;

    public function getIdDivisa() {
        return $this->idDivisa;
    }
    
    public function setIdDivisa($idDivisa) {
        $this->idDivisa = $idDivisa;
    }

	private $cuenta;

    public function getCuenta() {
        return $this->cuenta;
    }
    
    public function setCuenta($cuenta) {
        $this->cuenta = $cuenta;
    }

	private $banco;

    public function getBanco() {
        return $this->banco;
    }
    
    public function setBanco($banco) {
        $this->banco = $banco;
    }

	private $cuentaContable;

    public function getCuentaContable() {
        return $this->cuentaContable;
    }
    
    public function setCuentaContable($cuentaContable) {
        $this->cuentaContable = $cuentaContable;
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
		if(array_key_exists("idBanco", $datos)) $this->idBanco = $datos["idBanco"];
		if(array_key_exists("idDvisa", $datos)) $this->idDivisa = $datos["idDivisa"];
		$this->cuenta = $datos["cuenta"];
		$this->banco = $datos["banco"];
		$this->cuentaContable = $datos["cuentaContable"];
		$this->tipo = $datos["tipo"];
		$this->fecha = $datos["fecha"];
		$this->saldo = $datos["saldo"];
		
		
	}

    public function toArray()
    {
        $datos = array();
		
		$datos["idBanco"] = $this->idBanco;
		$datos["idDivisa"] = $this->idDivisa;
		$datos["cuenta"] = $this->cuenta;
		$datos["banco"] = $this->banco;
		$datos["cuentaContable"] = $this->cuentaContable;
		$datos["tipo"] = $this->tipo;
		$datos["fecha"] = $this->fecha;		
		$datos["saldo"] = $this->saldo;
		return $datos;
    }

}

