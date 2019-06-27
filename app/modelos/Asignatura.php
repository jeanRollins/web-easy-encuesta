<?php

class Asignatura
{

  private $db ;

  public function __construct()
  {
    $this->db = new Base ;
  }

  public function GetAsignaturas()
  {
    $this->db->query( 'SELECT * FROM asignaturas' );
    $result = $this->db->getRegistersBd();
    return $result ;
  }
}
