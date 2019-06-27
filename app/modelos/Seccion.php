<?php

class Seccion
{

  private $db ;

  public function __construct()
  {
    $this->db = new Base ;
  }

  public function GetSecciones()
  {
    $this->db->query( 'SELECT * FROM secciones' );
    $result = $this->db->getRegistersBd();
    return $result ;
  }
}
