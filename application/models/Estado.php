<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Estado
{
	private $idEstado;

    public function getIdEstado() {
        return $this->idEstado;
    }
    
    public function setIdEstado($idEstado) {
        $this->idEstado = $idEstado;
    }

    private $estado;

    public function getEstado() {
        return $this->estado;
    }
    
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    private $claveEstado;

    public function getClaveEstado() {
        return $this->claveEstado;
    }
    
    public function setClaveEstado($claveEstado) {
        $this->claveEstado = $claveEstado;
    }
	
	public function __construct(array $datos)
	{
		$this->idEstado = $datos["idEstado"];
		$this->estado = $datos["estado"];
		$this->claveEstado = $datos["claveEstado"];
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idEstado"] = $this->idEstado;
		$datos["estado"] = $this->estado;
		$datos["claveEstado"] = $this->claveEstado;
	}

}

