<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" href="<?php echo RUTA_URL; ?>public/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo RUTA_URL; ?>public/css/estilos.css">
  <link rel="stylesheet" href="<?php echo RUTA_URL; ?>public/css/toastr.css">
  <link rel="stylesheet" href="<?php echo RUTA_URL; ?>public/css/datatables.css">
</head>
<body>

  <header style="background-color: #009933;color: #fff;">
    <div class="container">
      <div class="row">
        <div class="col-5">
          <a href="<?php echo RUTA_URL; ?>"><img src="<?php echo RUTA_IMG; ?>/logo_ciisa.png" width="200" heigth="50" alt=""></a>
        </div>
        <div class="col-5 align-self-end">
          <h4>Bienvenido   <?php echo  $_SESSION['names']  ; ?> </h4>
        </div>
        <div class="col-2 align-self-end">
            <a href="<?php echo RUTA_URL; ?>sessioncontroller/loguot" class="btn btn-light btn-sm nav-link"> Cerrar Sesión </a>
        </div>
      </div>
    </div>



    <hr />
  </header>
