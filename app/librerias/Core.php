<?php

	/*mapear la url ingresada en el navegador
	1.conrolador
	2.metodo
	3.metodo
	*/

	class Core{
		protected $controladorActual='logincontroller';
		protected $metodoActual ='login';
		protected $parametros = [];

		//constructor
		public function __construct() {
			$url = $this->obtenerUrl();
			//print_r($this->obtenerUrl());

			//busca controladores si existe
			if (file_exists('../app/controladores/'.ucwords($url[0]).'.php')) {
				//si existe , se setea como controlador por defecto
				$this->controladorActual = ucwords($url[0]);
				//unset indice
				unset($url[0]);

			}

			require_once '../app/controladores/'.$this->controladorActual .'.php';
				$this->controladorActual = new $this->controladorActual;

				//chequear la parte de la url (metodo)
				if(isset($url[1])){
					if(method_exists($this->controladorActual, $url[1])){
					//revisamos el metodo
					$this->metodoActual= $url[1];
					unset($url[1]);
					}
				}
				//test traer metodo
				//echo $this->metodoActual;

				//obtener parametros

				$this->parametros= $url ? array_values($url) : [];
				// llamar callaback con parametro array
				call_user_func_array([$this->controladorActual,$this->metodoActual],$this->parametros);
			}

		public function obtenerUrl(){
			//echo $_GET['url'];

			if(isset($_GET['url'])){
				$url = rtrim($_GET['url'],'/');

				$url = filter_var($url,FILTER_SANITIZE_URL);
				$url = explode('/', $url);

				return $url;

			}
		}
	}

 ?>
