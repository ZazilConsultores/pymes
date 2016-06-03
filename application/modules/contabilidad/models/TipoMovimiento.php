<?php

class Contabilidad_Model_TipoMovimiento
{
	protected $_name = 'TipoMovimiento';
	
	private $idTipoMovimiento;

    public function getIdTipoMovimiento() {
        return $this->idTipoMovimiento;
    }
    
    public function setIdTipoMovimiento($idTipoMovimiento) {
        $this->idTipoMovimiento = $idTipoMovimiento;
    }

    private $tipoMovimiento;

    public function getTipoMovimiento() {
        return $this->tipoMovimiento;
    }
    
    public function setTipoMovimiento($tipoMovimiento) {
        $this->tipoMovimiento = $tipoMovimiento;
    }
	
	private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    private $afectaInventario;

    public function getAfectaInventario() {
        return $this->afectaInventario;
    }
    
    public function setAfectaInventario($afectaInventario) {
        $this->afectaInventario = $afectaInventario;
    }

    private $afectaSaldo;

    public function getAfectaSaldo() {
        return $this->afectaSaldo;
    }
    
    public function setAfectaSaldo($afectaSaldo) {
        $this->afectaSaldo = $afectaSaldo;
    }

    public function __construct(array $datos)
	{
		if(array_key_exists("idTipoMovimiento", $datos)) $this->idTipoMovimiento = $datos["idTipoMovimiento"];
		
		$this->tipoMovimiento = $datos["tipoMovimiento"];
		$this->descripcion = $datos["descripcion"];
		$this->afectaInventario = $datos["afectaInventario"];
		$this->afectaSaldo = $datos["afectaSaldo"];

		
		
	}

    public function toArray()
    {
        $datos = array();
		
		$datos["idTipoMovimiento"] = $this->idTipoMovimiento;
		$datos["tipoMovimiento"] = $this->tipoMovimiento;
		$datos["descripcion"] = $this->descripcion;
		$datos["afectaInventario"] = $this->afectaInventario;
		$datos["afectaSaldo"] = $this->afectaSaldo;
		
		return $datos;
    }

}

