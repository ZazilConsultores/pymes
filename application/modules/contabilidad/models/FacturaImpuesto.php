<?php

class Contabilidad_Model_FacturaImpuesto
{

	private $idFacturaImpuesto;

    public function getIdFacturaImpuesto() {
        return $this->idFacturaImpuesto;
    }
    
    public function setIdFacturaImpuesto($idFacturaImpuesto) {
        $this->idFacturaImpuesto = $idFacturaImpuesto;
    }

	private $idFactura;

    public function getIdFactura() {
        return $this->idFactura;
    }
    
    public function setIdFactura($idFactura) {
        $this->idFactura = $idFactura;
    }
	
    private $isrImporte;

    public function getIsrImporte() {
        return $this->isrImporte;
    }
    
    public function setIsrImporte($isrImporte) {
        $this->isrImporte = $isrImporte;
    }

    	
    private $iepsImporte;

    public function getIepsImporte() {
        return $this->iepsImporte;
    }
    
    public function setIepsImporte($iepsImporte) {
        $this->iepsImporte = $iepsImporte;
    }

    private $ivaImporte;

    public function getIvaImporte() {
        return $this->ivaImporte;
    }
    
    public function setIvaImporte($ivaImporte) {
        $this->ivaImporte = $ivaImporte;
    }

    private $ishImporte;

    public function getIshImporte() {
        return $this->ishImporte;
    }
    
    public function setIshImporte($ishImporte) {
        $this->ishImporte = $ishImporte;
    }

    
    public function __construct(array $datos){
    	if (array_key_exists("idFacturaImpuesto", $datos)) $this->idFacturaImpuesto = $datos["idFacturaImpuesto"];
    	$this->idFactura = $datos["idFactura"];
		$this->isrImporte = $datos["isrImporte"];
		$this->iepsImporte = $datos["iepsImporte"];
		$this->ivaImporte = $datos["ivaImporte"];
		$this->ishImporte = $datos["ishImporte"];
		
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idFacturaImpuesto"] = $this->idFacturaImpuesto;
		$datos["idFactura"] = $this->idFactura;
		$datos["isrImporte"] = $this->isrImporte;	
		$datos["iepsImporte"] = $this->iepsImporte;
		$datos["ivaImporte"]=$this->ivaImporte;
		$datos["ishImporte"]=$this->ishImporte;
		
		return $datos;		
		
	}

	


}


