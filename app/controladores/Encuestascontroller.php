<?php

Class Encuestascontroller extends Controlador{

  public function __construct()
  {
    $this->encuesta = $this->cargaModelo('Encuesta') ;
    $this->pregunta = $this->cargaModelo('Preguntas') ;
  }

  public function addEncuesta(){

    $encuestasArr = $_POST ;
    $encuestas = $this->ArrayOrder( $encuestasArr );

    extract( $encuestas[0] ) ;
    $responseAdd = $this->encuesta->AddEncuesta( $selectTipoEncuesta , $nameEncuesta , $select_largo_encuesta );
    //$responseAdd si es true, retorna id_encuesta, de lo contrario false
    if( $responseAdd == false || $responseAdd == NULL || $responseAdd == '' )
    {
      $data = array(
          'response'  => false ,
          'message' 	=> 'Error with insert user to table encuesta.'
      );
      echo json_encode( $data , JSON_FORCE_OBJECT ) ;
      return false ;
    }

    try {
      $validation = true ;
      foreach ( $encuestas as $enc )
      {
        $res = $this->encuesta->AddRespuesta( (int)$responseAdd , $enc['preguntaText'] , (int) $enc['largoRespuesta'] );


        if ( $res == false )
        {
          $data = array(
              'response'  => false ,
              'message' 	=> 'Error with insert user to table preguntas.'
          );
          echo json_encode( $data , JSON_FORCE_OBJECT ) ;
          return false ;
        }
      }

      $data = array(
          'response'  => true ,
          'message' 	=> $nameEncuesta
      );
      echo json_encode( $data , JSON_FORCE_OBJECT ) ;
    }
    catch (Exception $exception) {

      echo 'Error LoginAuth : ' . $exception->getMessage() ;
    }
  }

  private function ArrayOrder( $arr )
  {
    $encuestaTotal = array() ;
    for ($i=0; $i < (int)$arr["select_largo_encuesta"] ; $i++) {
      $encuestaTotal [] = array(
        'selectTipoEncuesta'     => $arr['selectTipoEncuesta'] ,
        'nameEncuesta'           => $arr['nameEncuesta'] ,
        'select_largo_encuesta'  => $arr['select_largo_encuesta'] ,
        'preguntaText'           => $arr["preguntaText".( $i + 1 )] ,
        'largoRespuesta'         => $arr["largoRespuesta".( $i + 1 )]
      );
    }
    return $encuestaTotal ;
  }

  public function showencuestas()
  {
    $encuestas = $this->encuesta->GetEncuestas()  ;
    echo json_encode( $encuestas , JSON_FORCE_OBJECT ) ;
  }

  public function deleteencuesta()
  {
    extract( $_GET );

    $responseRespuesta = $this->encuesta->DeletePregunta( (int)$id_encuesta ) ;
    if( !$responseRespuesta )
    {
      $data = array (
        'response'    =>  false
      );
      return ;
    }

    $responseEncuesta = $this->encuesta->DeleteEncuesta( (int) $id_encuesta ) ;
    if( !$responseEncuesta )
    {
      $data = array(
        'response' =>  false
      );
      echo json_encode( $data , JSON_FORCE_OBJECT ) ;
      return ;
    }

    $data = array (
      'response'    =>  true,
      'id_encuesta' =>  $id_encuesta
    );
    echo json_encode( $data , JSON_FORCE_OBJECT ) ;
  }

  public function updateEncuesta()
  {
    extract( $_GET ) ;
    $encuestaResponse = $this->encuesta->GetEncuesta( $id_encuesta ) ;
    $encuestaPregunta = $this->pregunta->GetPreguntasPorEncuestas( $id_encuesta ) ;

    $encuestaArr = array(
      'encuestaResponse'  =>  $encuestaResponse ,
      'encuestaPregunta'  =>  $encuestaPregunta
    );

    echo json_encode( $encuestaArr , JSON_FORCE_OBJECT ) ;
  }

  private function ArrayOrderUpdate( $arr )
  {
    $encuestaTotal = array() ;
    for ($i=0; $i < (int)$arr["select_largo_encuesta"] ; $i++) {
      $encuestaTotal [] = array(
        'selectTipoEncuesta'        => $arr['selectTipoEncuesta'] ,
        'nameEncuesta'              => $arr['nameEncuesta'] ,
        'select_largo_encuesta'     => $arr['select_largo_encuesta'] ,
        'select_largo_encuesta_old' => $arr['select_largo_encuesta_old'],
        'idEncuestaForm'            => $arr['idEncuestaForm'],
        'preguntaText'              => $arr["preguntaText".( $i + 1 )] ,
        'largoRespuesta'            => $arr["largoRespuesta".( $i + 1 )]
      );
    }
    return $encuestaTotal ;
  }

  public function actualizarEncuesta()
  {
    $post = $this->ArrayOrderUpdate( $_POST ) ;
    var_dump( $post[0] ) ;
    extract( $post[0] ) ;
    die();

    $this->pregunta->DeletePregunta( (int) $idEncuestaForm ) ;
    //separo en dos array uno para Actualizar y otro para isertar
    for ( $i = 0; $i < count( $post ) ; $i++ ) {
      $encuestasActualizar [] =  array(
        'selectTipoEncuesta'        => $enc['selectTipoEncuesta'] ,
        'nameEncuesta'              => $enc['nameEncuesta'] ,
        'select_largo_encuesta'     => $enc['select_largo_encuesta'] ,
        'preguntaText'              => $enc["preguntaText".( $i + 1 )] ,
        'largoRespuesta'            => $enc["largoRespuesta".( $i + 1 )],
        'select_largo_encuesta_old' => $enc['select_largo_encuesta_old']
      );
    }
  }




}

 ?>
