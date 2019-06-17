<?php

class Testing extends Controlador{

  public function  __construct(){
		//crear una variable this usuario modelo y llamo al metodo carga modelo
		// pasandole como parametro la clase usuario
		$this->loginModelo = $this->cargaModelo('Usuario');
	}

  public function Createusers()
  {
    $result = $this->loginModelo->AddUser();
    var_dump( $result );
  }
}


?>
