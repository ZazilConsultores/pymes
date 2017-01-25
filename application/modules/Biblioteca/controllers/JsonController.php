<?php

class Biblioteca_JsonController extends Zend_Controller_Action
{

    private $materiaDAO = null;

    private $libroDAO = null;

    private $tablaLibro = null;

    public function init()
    {
        /* Initialize action controller here */
        $dbAdapter = Zend_Registry::get('dbmodgeneral');
		
        $this->materiaDAO =  new Biblioteca_DAO_Materia;
		$this->libroDAO = new Biblioteca_DAO_Libro;
		$this->tablaLibro = new Biblioteca_Model_DbTable_Libro(array('db'=>$dbAdapter));
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
        // action body
    }

    public function consultabasicaAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();
        // =============================================================
        $parametros = $this->getAllParams();
		unset($parametros["module"]);
		unset($parametros["controller"]);
		unset($parametros["action"]);
		//print_r($parametros);
		//print_r("<br /> <br />");
		$cadenaCondicional = "";
		// construimos la cadena condicional SQL
		foreach ($parametros as $key => $value) {
			if(strlen($cadenaCondicional) > 0) $cadenaCondicional .= " AND ";
			if($value != ""){
				$cadenaCondicional .=  $key . " like " . "'"."%" . $value . "%"."'";
			}
		}
		
		$querySelect = "select * from Libro where " . $cadenaCondicional;
		
		//print_r($querySelect);
		//print_r("<br /><br />");
		
		//$db = $this->tablaLibro->getAdapter();
        $db = $identity["adapter"];
		$libros = $db->query($querySelect)->fetchAll();
		
		
		//$libros = $this->tablaLibro->fetchAll($querySelect);
		$librosArray = $libros;
		
        //print_r($librosArray);
		//print_r("<br /><br />");
		echo Zend_Json::encode($libros);
        
        // =============================================================
        /*
        $idMateria = $this->getParam("idMateria");
		$libros = $this->libroDAO->obtenerLibros($idMateria);
		$arrayMaterias = array();
		
		foreach($materias as $materias){
			$arrayMaterias[] = array("idMateria"=>$materia->getIdMateria(),"materia"=>$materia->getMateria());
		}
		
		echo Zend_Json::encode($arrayMaterias);
		 *
		 */
    }

    public function consultapormateriaAction()
    {
        // action body
    }


}





