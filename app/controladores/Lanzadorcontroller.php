<?php
Class Lanzadorcontroller extends Controlador{

  public function __construct()
  {
    $this->Asignatura = $this->cargaModelo('Asignatura') ;
    $this->Carrera    = $this->cargaModelo('Carrera') ;
    $this->Seccion    = $this->cargaModelo('Seccion') ;
    $this->User       = $this->cargaModelo('Usuario') ;
  }

  public function GetDataLanzador(){

    $asignaturas = $this->Asignatura->GetAsignaturas() ;
    $carreras    = $this->Carrera->GetCarreras() ;
    $secciones   = $this->Seccion->GetSecciones() ;

    $data = array(
        'asignaturas' => $asignaturas ,
        'carreras'  	=> $carreras ,
        'secciones'  	=> $secciones
    );

    echo json_encode( $data , JSON_FORCE_OBJECT ) ;
  }

  public function filterDataUsers(){
    $post = array_map( 'intval' , $_POST );
    extract( $post ) ;

    $responseDataUsers = $this->User->GetUserStudyFilter( $inputSelectCarrera , $inputSelectSeccion , $inputSelectAsignatura );
    echo json_encode( $responseDataUsers , JSON_FORCE_OBJECT ) ;
  }

}
