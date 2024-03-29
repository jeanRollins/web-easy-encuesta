<?php
session_start();

class Sessioncontroller extends  Controlador{

  public function __construct()
  {
    $this->encuesta = $this->cargaModelo('Encuesta') ;
    $this->user = $this->cargaModelo('Usuario') ;
  }

  public function loguot()
  {
    session_destroy();
    redirect('logincontroller/login');
  }

  public function dashboard()
  {
    $this->ValidateSession( $_SESSION );
    $this->cargaVista('paginas/dashboard') ;
  }
  public function addencuesta()
  {
    $this->ValidateSession( $_SESSION ) ;
    $this->cargaVista('paginas/addencuesta') ;
  }
  public function showencuestas()
  {
    $this->ValidateSession( $_SESSION ) ;
    $encuestas = $this->encuesta->GetEncuestas()  ;

    $encuestasArray = [
      'encuestas'   =>  $encuestas
    ];

    $this->cargaVista('paginas/showencuestas' , $encuestasArray ) ;
  }

  public function lanzadorencuesta()
  {
    $this->ValidateSession( $_SESSION ) ;
    $encuestas = $this->user->GetUserStudyData() ;
    $this->cargaVista('paginas/lanzadorencuesta' , $encuestas ) ;
  }
  


}

 ?>
