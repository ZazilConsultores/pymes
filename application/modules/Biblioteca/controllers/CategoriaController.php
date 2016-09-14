<?php

class Biblioteca_CategoriaController extends Zend_Controller_Action
{
	
	private $categoriaDAO;
	
    public function init()
    {
        /* Initialize action controller here */
        $this->categoriaDAO = new Biblioteca_DAO_Categoria;
    }

    public function indexAction()
    {
        // action body
    }

    public function altaAction()
    {
        // action body
        
        $request = $this->getRequest();
		
		$formulario = new Biblioteca_Form_AltaCategoria();
		
		
		if ($request->isGet()) {
			$this->view->formulario = $formulario;
		} elseif ($request->isPost()){
			if ($formulario->isValid($request->getPost())) {
				$datos = $formulario->getValues();
				
				$categoria = new Biblioteca_Model_Categoria($datos);
				
				try{
					$this->categoriaDAO->agregarCategoria($categoria);
					$this->view->messageSuccess = "Categoría: <strong>".$categoria->getCategoria()."</strong> guardada con exito";
				}catch(Exception $ex){
					$this->view->messageFail = "Categoría: <strong>".$categoria->getCategoria()."</strong> no ha sido guardada. Error: <strong>".$ex->getMessage()."</strong>";
				}
				
			}
			
		}
		
    }


}



