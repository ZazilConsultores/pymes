<?php

class Contabilidad_Model_Consecutivo
{
	private $idTipoMovimiento;

    public function getIdTipoMovimiento() {
        return $this->idTipoMovimiento;
    }
    
    public function setIdTipoMovimiento($idTipoMovimiento) {
        $this->idTipoMovimiento = $idTipoMovimiento;
    }
	
	private $idSucursal;

    public function getIdSucursal() {
        return $this->idSucursal;
    }
    
    public function setIdSucursal($idSucursal) {
        $this->idSucursal = $idSucursal;
    }

    private $numero;

    public function getNumero() {
        return $this->numero;
    }
    
    public function setNumero($numero) {
        $this->numero = $numero;
    }

    	
	public function __construct(array $datos)
	{
		if(array_key_exists("idTipoMovimiento", $datos)) $this->tipoMovimiento = $datos["tipoMovimiento"];
		if(array_key_exists("idSucursal", $datos)) $this->idSucursal = $datos["idSucursal"];
		if(array_key_exists("numero", $datos)) $this->numero = $datos["numero"];	
	}

    public function toArray()
    {
        $datos = array();
		$datos["idTipoMovimiento"] = $this->idTipoMovimiento;
		$datos["idSucursal"] = $this->idSucursal;
		$datos["numero"] = $this->numero;
		
		return $datos;
    }


}

