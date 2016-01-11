<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Fiscales
{
	private $idFiscales;

    public function getIdFiscales() {
        return $this->idFiscales;
    }
    
    public function setIdFiscales($idFiscales) {
        $this->idFiscales = $idFiscales;
    }

    private $rfc;

    public function getRfc() {
        return $this->rfc;
    }
    
    public function setRfc($rfc) {
        $this->rfc = $rfc;
    }

    private $razonSocial;

    public function getRazonSocial() {
        return $this->razonSocial;
    }
    
    public function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
    }

    public function __construct(array $datos)
    {
        $this->idFiscales = $datos["idFiscales"];
		$this->rfc = $datos["rfc"];
		$this->razonSocial = $datos["razonSocial"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idFiscales"] = $this->idFiscales;
		$datos["rfc"] = $this->rfc;
		$datos["razonSocial"] = $this->razonSocial;
	}

}

