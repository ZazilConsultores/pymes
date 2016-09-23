<?php
  /**
 * Clase que opera sobre libros en la biblioteca
 * @author Alizon Fernanda Díaz
 * @copyright 2016
 * @version 1.0.0
 */
 
 class Biblioteca_DAO_LibrosMateria implements Biblioteca_Interfaces_ILibrosMateria {
 	
	private $tablaLibrosMateria;
	private $tablaLibro;
	private $tablaMateria;
	
	function __construct(){
		$this->tablaLibrosMateria = new Biblioteca_Model_DbTable_LibrosMateria;
		$this->tablaLibro = new Biblioteca_Model_DbTable_Libro;
		$this->tablaMateria = new Biblioteca_Model_DbTable_Materia;
	
	}
	
	/**
	 * Función que agrega la relación entre el idMateria y los idsLibros
	 * @param $librosMateria 
	 */
	public function agregarLibrosMateria($idMateria, $idLibro){
		//obtenemos el registro de la materia
		$tablaLibrosMateria = $this->tablaLibrosMateria;
		$select = $tablaLibrosMateria->select()->from($tablaLibrosMateria)->where("idMateria=?",$idMateria);
		$rowLibrosMateria = $tablaLibrosMateria->fetchRow($select); 
		
		if( is_null($rowLibrosMateria) ){
			//No existe la materia en la tabla
			$data = array();
			$data["idMateria"] = $idMateria;
			$data["idsLibro"] = $idLibro; 
			$tablaLibrosMateria->insert($data);
		}else{ // Si ya existe el registro de la materia con id: $idMateria
			$idsLibro = $rowLibrosMateria->idsLibro;
			$arrayIdsLibro = explode(",", $idsLibro);
			if( in_array($idLibro, $arrayIdsLibro) ){
				//esta en los ids
			}else{
				// no esta, lo agregamos
				$arrayIdsLibro[] = $idLibro;
				$idsLibro = implode(",", $arrayIdsLibro);
				$data = array("idsLibro" => $idsLibro);
				$where = $tablaLibrosMateria->getDefaultAdapter()->quoteInto("idMateria=?", $idMateria);
				try{
					$tablaLibrosMateria->update($data, $where);
				}catch(Exception $ex){
					print_r($ex->getMessage());
				}
				
			}
		}
		
		//$tablaLibrosMateria->insert($materia->toArray());
	 }
	 
	 
	/* public function agregarLibrosMateria(array $datos){
	 	
		try{
			
			$idMateria = $this->getParam("Libro","idLibro");
		}catch(Exxception $ex){
			
		}
	 }*/
	 
	 
	 
	 /**
	 * Función que obtiene el id de la relación de Libros-Materia
	 * @param $librosMateria 
	 */
	
	
	public function obtenerLibrosMateria($idLibrosMateria){
		
		$tablaLibrosMateria = $this->tablaLibrosMateria;
		$select = $tablaLibrosMateria->select()->from($tablaLibrosMateria)->where("idLibrosMateria = ?",$idLibrosMateria);
		$rowLibrosMateria= $tablaLibrosMateria->fetchRow($select);
		
		$librosmateriaModel = new Biblioteca_Model_LibrosMateria($rowLibrosMateria->toArray());
		$librosmateriaModel->setIdLibrosMateria($rowLibrosMateria->idLibrosMateria);
		
		return $librosmateriaModel;
		
	}
	
	public function obtenerTelefonosSucursal($idLibrosMateria){
		$librosMateria = $this->obtenerLibrosMateria($idLibrosMateria);
		$idsLibros = explode(",", $librosMateria["idsLibro"]);
		//print_r($idsLibros);
		$libros = array();
		$tablaLibro = $this->tablaLibro;
		//print_r("<br />");
		foreach ($idsLibro as $index => $idLibro) {
			if($idLibro != ""){	//El ultimo elemento generado por la funcion explode es un string vacio, este ultimo no se toma en cuenta
				//print_r($idLibro);
				//print_r("<br />");
				$select = $tablaLibro->select()->from($tablaLibro)->where("idLibro=?",$idLibro);
				//print_r($select->__toString());
				//print_r("<br />");
				$rowLibro = $tablaLibro->fetchRow($select);
				//print_r($rowLibro->toArray());
				//print_r("<br />");
				$libros[] = $rowLibro->toArray();
			}
		}
		//print_r("<br />");
		//print_r($libros);
		return $libros;
	}
	 
	 
 }
 	
?>