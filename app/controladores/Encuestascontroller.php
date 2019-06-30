<?php

Class Encuestascontroller extends Controlador{

  public function __construct()
  {
    $this->encuesta = $this->cargaModelo('Encuesta')  ;
    $this->pregunta = $this->cargaModelo('Preguntas') ;
    $this->User     = $this->cargaModelo('Usuario')   ;
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
    extract( $post[0] ) ;

    $responsePregunta = $this->pregunta->DeletePregunta( (int) $idEncuestaForm ) ;
    if( !$responsePregunta ){
      $data = array(
          'response'  => false ,
          'message' 	=> 'Error with delete pregunstas to table preguntas.'
      );
      echo json_encode( $data , JSON_FORCE_OBJECT ) ;
      return false ;
    }

    for ( $i = 0; $i < count( $post ) ; $i++ ) {
      $res = $this->encuesta->AddRespuesta( (int) $post[$i]['idEncuestaForm'] , $post[$i]['preguntaText'] , (int) $post[$i]['largoRespuesta'] );
      if ( $res == false ){

        $data = array(
            'response'  => false ,
            'message' 	=> 'Error with insert pregunstas to table pregunstas.'
        );
        echo json_encode( $data , JSON_FORCE_OBJECT ) ;
        return false ;
      }
    }

    $responseUpdate = $this->encuesta->UpdateEncuesta( (int) $post[0]['idEncuestaForm'] , (int) $selectTipoEncuesta , $nameEncuesta , (int) $select_largo_encuesta ) ;

    if( !$responseUpdate ){
      $data = array(
          'response'  => false ,
          'message' 	=> 'Error with update ecnuestas to table preguntas.'
      );
      echo json_encode( $data , JSON_FORCE_OBJECT ) ;
      return false ;
    }

    $data = array(
        'response'  => true ,
        'message' 	=> 'La Encuesta fue actualizada con exito.'
    );
    echo json_encode( $data , JSON_FORCE_OBJECT ) ;
  }

  public function GetDetalleEncuesta(){
    extract( $_GET ) ;
    $encuestaRespuestas = $this->encuesta->GetPreguntaRespuesta( (int)$id_encuesta ) ;
    echo json_encode( $encuestaRespuestas , JSON_FORCE_OBJECT ) ;
  }

  private function OrderLanzarEncuesta( $rutUsers , $idEncuesta , $idPreguntasEncuestas ){
    for ( $i = 0 ; $i < count( $rutUsers ) ; $i++ ) {
      for ( $j = 0 ; $j < count( $idPreguntasEncuestas ) ; $j++) {
        $encuestaTotal[] = array(
            'rut'                    =>  $rutUsers[$i] ,
            'idEncuesta'             =>  $idEncuesta   ,
            'idPreguntasEncuestas'   =>  $idPreguntasEncuestas[$j]->id_pregunta
        );
      }
    }
    return $encuestaTotal ;
  }

  public function LanzarEncuesta(){
    extract( $_POST ) ;
    $rutUsers = explode( ',' , $dataRut ) ;
    $idPreguntasEncuestas = $this->encuesta->GetIdPreguntas( $id_encuesta ) ;
    $responseOrderLanzarEncuesta = $this->OrderLanzarEncuesta( $rutUsers , $id_encuesta , $idPreguntasEncuestas ) ;

    foreach ( $responseOrderLanzarEncuesta as $encuestaData ) {
      $response = $this->User->AddUserRespuestas( $encuestaData['rut'] , (int)$encuestaData['idEncuesta'] , (int) $encuestaData['idPreguntasEncuestas'] ) ;
      if( !$response ){
        break ; echo 'false' ; return ;
      }
    }
    echo 'true' ;
  }


}

 ?>
