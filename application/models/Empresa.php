<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Empresa
{
	private $idEmpresa;

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
    
    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    private $idFiscales;

    public function getIdFiscales() {
        return $this->idFiscales;
    }
    
    public function setIdFiscales($idFiscales) {
        $this->idFiscales = $idFiscales;
    }
	
	private $tipo;

    public function getTipo() {
        return $this->tipo;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function __construct(array $datos)
    {
        $this->idFiscales = $datos["idFiscales"];
		$this->tipo = $datos["tipo"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idEmpresa"] = $this->idEmpresa;
		$datos["idFiscales"] = $this->idFiscales;
		$datos["tipo"] = $this->tipo;
		
		return $datos;
	}

}

