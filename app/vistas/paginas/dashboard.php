<?php require RUTA_APP . '/vistas/inc/header_session.php';?>
<div class="container" >
  <div class="row">
    <div class="col-2 menu">
      <?php require RUTA_APP . '/vistas/inc/menu.php';?>
    </div>
    <div class="col-10 content" >
      <div class="card">
        <div class="containerMenu" id="containerMenu">

          <div class="homeMenu" >
            <?php include RUTA_APP . '/vistas/menus/home.php'; ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<?php require RUTA_APP . '/vistas/inc/footer.php';?>

<script src="<?php echo RUTA_URL; ?>public/js/Chart.bundle.min.js"></script>
<script src="<?php echo RUTA_URL; ?>public/js/graficos.js"></script>
