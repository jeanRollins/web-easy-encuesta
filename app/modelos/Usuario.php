<?php

class Usuario{

  private $db;


  public function __construct(){
      $this->db = new Base;
  }

  public function getUser( $idUser )
  {
    	$this->db->query( 'SELECT * FROM users WHERE id_user=:id_user' );
      $this->db->bind( ':id_user', $idUser );
      $result = $this->db->getRegisterBd();
      return $result ;
  }

  public function GetUsers()
  {
    $this->db->query( 'SELECT * FROM users' ) ;
    $result = $this->db->getRegistersBd() ;
    return $result ;
  }

  public function GetUserStudyData()
  {
    $this->db->query( 'SELECT DISTINCT u.id_user, u.rut , u.names, u.lastnames , u.email , c.name_carrera  FROM users u
                        INNER JOIN user_carreras uc ON u.rut = uc.rut
                        INNER JOIN carreras c ON uc.id_carrera= c.id_carrera
                        INNER JOIN asignaturas a ON a.id_carrera= uc.id_carrera
                        ORDER BY u.rut ;' ) ;

    $result = $this->db->getRegistersBd() ;
    return $result ;
  }

  private function GetUserStudyDataFilter( $query )
  {
    $this->db->query( 'SELECT DISTINCT u.id_user, u.rut , u.names, u.lastnames , u.email , c.name_carrera  FROM users u
                        INNER JOIN user_carreras uc ON u.rut = uc.rut
                        INNER JOIN carreras c ON uc.id_carrera = c.id_carrera
                        INNER JOIN asignaturas a ON a.id_carrera= uc.id_carrera'.
                        $query
                        .' ORDER BY u.rut ;' ) ;
    $result = $this->db->getRegistersBd() ;
    return $result ;
  }

  public function GetUserStudyFilter( $idCarrera , $idSeccion , $idAsignatura ){
    $query = '';
    $query = $idCarrera == 0 ? '' : " WHERE c.id_carrera =" . $idCarrera ;

    $response = $this->GetUserStudyDataFilter( $query );
    return $response ;
  }

  public function AddUserRespuestas( $rut , $id_encuesta , $id_pregunta )
  {
    $this->db->query( "INSERT INTO user_respuestas ( rut , id_encuesta , id_pregunta , id_respuesta , status )
                       VALUES
                      ( ':rut' , ':id_encuesta' , ':id_pregunta' , 'id_respuesta' , ':status' );" ) ;

    $this->db->bind( ':rut'          , $rut  ) ;
    $this->db->bind( ':id_encuesta'  , $id_encuesta  ) ;
    $this->db->bind( ':id_pregunta'  , $id_pregunta ) ;
    $this->db->bind( ':id_respuesta' , 0 ) ;
    $this->db->bind( ':status'       , 0 ) ;

    if ( $this->db->execute() ) {
          return true ;
    }
    return false ;
  }
}
