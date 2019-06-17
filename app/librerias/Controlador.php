<?php


// clase controlador principal
//se encarga de poder cargar los medelos y las vistas

class Controlador{
	// carga modelo

	public function cargaModelo($modelo){
		//carga modelo
		require_once '../app/modelos/'. $modelo. '.php';
		// instanciar modelo
		return new $modelo();
	}

	public function cargaLibreria($libreria){
		//carga libreria
		require_once '../app/librerias/'. $libreria. '.php';
		// instanciar libreria
		return new $libreria();
	}

	public function cargaVista($vista, $datos = []){
		//verificar si el la vista existe
		if(file_exists('../app/vistas/'.$vista .'.php')){
			require_once '../app/vistas/'. $vista. '.php';

		}else{
			die('la vista no existe');
		}
	}

	public function Sanity( $data ) : string
	{
		$data  = trim( $data ) ;
		$data  = htmlspecialchars( $data ) ;
		$data  = filter_var( $data , FILTER_SANITIZE_STRING ) ;
		return $data ;
	}

	public function ValidateSession( $dataUser )
	{
		if( $dataUser['token'] == '' )
		{
			session_destroy();
			redirect('logincontroller/login');
		}
		if( $dataUser['active'] != 1 )
		{
			session_destroy();
			redirect('logincontroller/login');
		}
		if( $dataUser['idUser'] == '' || $dataUser['idUser'] == NULL )
		{
			session_destroy();
			redirect('logincontroller/login');
		}
		return true ;
	}

}

 ?>
