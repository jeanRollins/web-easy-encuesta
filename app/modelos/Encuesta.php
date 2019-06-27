<?php


class Encuesta {

  private $db ;

	public function __construct()
  {
		$this->db = new Base ;
	}

  public function AddEncuesta( $tipoEncuesta , $nameEncuesta , $largoEncuesta)
  {
    $this->db->query("INSERT INTO encuestas ( tipo_encuesta , name_encuesta , largo_encuesta , create_encuesta, update_encuesta )
    VALUES
    ( :tipo_encuesta , :name_encuesta , :largo_encuesta, now() , now() ) ") ;

    $this->db->bind(':tipo_encuesta'  , $tipoEncuesta );
    $this->db->bind(':name_encuesta'  , $nameEncuesta );
    $this->db->bind(':largo_encuesta' , $largoEncuesta );

    if( $this->db->execute() ){
      $this->db->query("SELECT LAST_INSERT_ID() AS last_id");
      $result = $this->db->getRegisterBd();
      return $result->last_id ;
    }
    else{
      return false ;
    }
  }

  public function AddRespuesta( $idEncuesta , $namePregunta , $largoPregunta )
  {
    $this->db->query("INSERT INTO preguntas ( id_encuesta , name_pregunta , largo_pregunta )
    VALUES
    ( :id_encuesta , :name_pregunta , :largo_pregunta ) ") ;

    $this->db->bind(':id_encuesta'    , $idEncuesta    ) ;
    $this->db->bind(':name_pregunta'  , $namePregunta  ) ;
    $this->db->bind(':largo_pregunta' , $largoPregunta ) ;

    if ( $this->db->execute() ) {
          return true ;
    }
    return  false ;
  }

  public function GetEncuestas()
  {
    $this->db->query( 'SELECT * FROM encuestas' );
    $result = $this->db->getRegistersBd();
    return $result ;
  }

  public function GetEncuesta( $id_encuesta )
  {
    $this->db->query( 'SELECT * FROM encuestas where id_encuesta=' . $id_encuesta );
    $result = $this->db->getRegisterBd();
    return $result ;
  }

  public function DeleteEncuesta( $id_encuesta )
  {
    $this->db->query( 'DELETE FROM encuestas WHERE id_encuesta=:id_encuesta' );
    $this->db->bind(':id_encuesta' , $id_encuesta ) ;

    if ( $this->db->execute() ) {
          return true ;
    }
    return false ;
  }

  public function DeletePregunta( $id_encuesta )
  {
    $this->db->query( 'DELETE FROM preguntas WHERE id_encuesta=:id_encuesta' );
    $this->db->bind(':id_encuesta' , $id_encuesta ) ;

    if ( $this->db->execute() ) {
          return true ;
    }
    return false ;
  }

  public function UpdateEncuesta( $idEncuesta , $tipoEncuesta , $nameEncuesta , $largoEncuesta )
  {
    $this->db->query( 'UPDATE encuestas SET  tipo_encuesta=:tipo_encuesta , name_encuesta=:name_encuesta , largo_encuesta=:largo_encuesta WHERE id_encuesta=:id_encuesta' );
    $this->db->bind(':id_encuesta'    , $idEncuesta    ) ;
    $this->db->bind(':tipo_encuesta'  , $tipoEncuesta  ) ;
    $this->db->bind(':name_encuesta'  , $nameEncuesta  ) ;
    $this->db->bind(':largo_encuesta' , $largoEncuesta ) ;

    if ( $this->db->execute() ) {
          return true ;
    }
    return false ;
  }

  public function GetPreguntaRespuesta( $id_encuesta )
  {
    $this->db->query( "SELECT e.id_encuesta , e.name_encuesta , te.name_tipo , e.largo_encuesta , e.update_encuesta , p.largo_pregunta , e.create_encuesta , p.id_pregunta , p.name_pregunta
                        FROM encuestas e
                        INNER JOIN preguntas p ON e.id_encuesta = p.id_encuesta
                        INNER JOIN tipo_encuesta te ON te.id_tipo = e.tipo_encuesta
                        WHERE e.id_encuesta = :id_encuesta
                        ORDER BY e.update_encuesta  DESC  ;	" );

    $this->db->bind(':id_encuesta' , $id_encuesta ) ;

    $result = $this->db->getRegistersBd() ;
    return $result ;

  }

  public function GetPreguntasRespuestas( )
  {
    $this->db->query( "SELECT e.id_encuesta , e.name_encuesta , te.name_tipo , e.largo_encuesta , e.update_encuesta ,p.id_pregunta , p.name_pregunta
                        FROM encuestas e
                        INNER JOIN preguntas p ON e.id_encuesta = p.id_encuesta
                        INNER JOIN tipo_encuesta te ON te.id_tipo = e.tipo_encuesta
                        ORDER BY e.update_encuesta  DESC  ;	" );
    $result = $this->db->getRegistersBd() ;
    return $result ;
  }

  public function GetIdPreguntas( $id_encuesta )
  {
    $this->db->query( "SELECT id_pregunta FROM preguntas WHERE id_encuesta=:id_encuesta" ) ;
    $this->db->bind(':id_encuesta' , $id_encuesta ) ;

    if ( $this->db->execute() ) {
          return true ;
    }
    return false ;
  }

}


?>
