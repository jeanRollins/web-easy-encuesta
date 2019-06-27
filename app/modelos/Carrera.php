<?php

class Carrera
{

  private $db ;

  public function __construct()
  {
    $this->db = new Base ;
  }

  public function GetCarreras()
  {
    $this->db->query( 'SELECT * FROM carreras' );
    $result = $this->db->getRegistersBd();
    return $result ;
  }
}
