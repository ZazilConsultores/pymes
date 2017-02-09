<?php

class Biblioteca_MateriaController extends Zend_Controller_Action
{
	private $librosDAO = null;
    private $materiaDAO = null;
    private $librosMateriaDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->librosDAO= new Biblioteca_DAO_Libro;
         $this->materiaDAO= new Biblioteca_DAO_Materia;
		 $this->librosMateriaDAO = new Biblioteca_DAO_LibrosMateria;
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
        // action body
             $request = $this->getRequest();
		
		$formulario = new Biblioteca_Form_AltaMateria();
		
		
        if($request->isGet()){
        	$this->view->formulario = $formulario;
        }elseif($request->isPost()){
        	if($formulario->isValid($request->getPost())){
        		$datos = $formulario->getValues();
				//print_r($datos);
				
				$materia = new Biblioteca_Model_Materia($datos);
				//print_r($materia->toArray());
				
				try{
					$this->materiaDAO->agregarMateria($materia);
					$this->view->messageSuccess = "La materia: <strong>".$materia->getMateria()."</strong> ha sido agregado correctamente !!";
				}catch(Exception $ex){
					$this->view->messageFail = "La materia: <strong>".$materia->getMateria()."</strong> no ha sido agregado. Error: <strong>".$ex->getMessage()."<strong>";
				}
				
        	}
        }
    }

    /**
     * @deprecated
     */
    public function asociarlibroAction()
    {
        // action body
    }

    public function agregarlibroAction() {
    		
    	$idMateria = $this -> getParam("idMateria");
		//print_r($idMateria);
        $request = $this->getRequest();
		//print_r($this->librosDAO->getAllLibros());
        $formulario = new Biblioteca_Form_AltaLibrosMateria();
		//$this->view->formulario = $formulario;
		//print_r($request->getPost());
		if ( $request->isGet() ) {
			$this->view->formulario = $formulario;
		} elseif ($request->isPost()) {
			if ($formulario->isValid($request->getPost())) {
				$datos = $formulario->getValues();
				
				//$librosMateria = new Biblioteca_Model_LibrosMateria($datos);
				
				try{
					//$this->librosMateriaDAO->agregarLibrosMateria($datos);
					$this->librosMateriaDAO->agregarLibrosMateria($datos["idMateria"], $datos["idsLibro"]);
					$this->view->messageSuccess = "Exito en la inserción ";
				}catch(Exception $ex){
					$this->view->messageFail = "Fallo al insertar en la BD Error:".$ex->getMessage()."<strong>";
				}
				
			}
			
		}
    }

    public function consultalibroAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Biblioteca_Form_ConsultaLibroPorMateria;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$libros = $this->materiaDAO->getLibrosByIdMateria($datos["idMateria"]);
				$this->view->libros = $libros;
				print_r($libros);
				
				$librosArray = $libros;
		
       
        
			}
		}
    }


}


