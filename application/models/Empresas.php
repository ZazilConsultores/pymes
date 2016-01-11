<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Empresas
{
	private $idEmpresas;

    public function getIdEmpresas() {
        return $this->idEmpresas;
    }
    
    public function setIdEmpresas($idEmpresas) {
        $this->idEmpresas = $idEmpresas;
    }

    private $idEmpresa;

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
    
    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    public function __construct(array $datos)
    {
        $this->idEmpresa = $datos["idEmpresa"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idEmpresas"] = $this->idEmpresas;
		$datos["idEmpresa"] = $this->idEmpresa;
		
		return $datos;
	}

}

