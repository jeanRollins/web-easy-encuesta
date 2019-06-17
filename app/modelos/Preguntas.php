<?php

class Preguntas{

  private $db ;

 	public function __construct() {
 		$this->db = new Base ;
 	}

  public function GetPreguntasPorEncuestas( $id_encuesta )
  {
    $this->db->query( 'SELECT * FROM preguntas where id_encuesta=' . $id_encuesta );
    $result = $this->db->getRegistersBd();
    return $result ;
  }

}
