<?php

class Contabilidad_Model_FacturaImpuesto
{


	private $idFactura;

    public function getIdFactura() {
        return $this->idFactura;
    }
    
    public function setIdFactura($idFactura) {
        $this->idFactura = $idFactura;
    }
	
    private $idImpuesto;

    public function getIdImpuesto() {
        return $this->idImpuesto;
    }
    
    public function setIdImpuesto($idImpuesto) {
        $this->idImpuesto = $idImpuesto;
    }

       	
    private $importe;

    public function getImporte() {
        return $this->importe;
    }
    
    public function setImporte($importe) {
        $this->importe = $importe;
    }

        
    public function __construct(array $datos){
    	if (array_key_exists("idFactura", $datos)) $this->idFactura = $datos["idFactura"];
    	if (array_key_exists("idImpuesto", $datos)) $this->idImpuesto = $datos["idImpuesto"];
		$this->importe = $datos["importe"];
		
		
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idFactura"] = $this->idFactura;
		$datos["idImpuesto"] = $this->idImpuesto;
		$datos["importe"] = $this->importe;	
		return $datos;		
		
	}

}


