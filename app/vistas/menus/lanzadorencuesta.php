<h2 align="center" class="mb-4">Lanzador de Encuestas </h2>
<form class="" id="formLanzadorEncuesta" action="<?php echo RUTA_URL; ?>lanzadorcontroller/filterDataUsers" method="">
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="inputState">Carrera</label>
      <select id="inputSelectCarrera" class="form-control">
      </select>
    </div>
    <input type="hidden" id="inputHiddenIdEncuesta" value="<?php echo $_GET['id_encuesta']; ?>">
    <div class="form-group col-md-3">
      <label for="inputState">Asignaturas</label>
      <select id="inputSelectAsignatura" class="form-control">
      </select>
    </div>

    <div class="form-group col-md-2">
      <label for="inputState">Sección</label>
      <select id="inputSelectSeccion" class="form-control">
      </select>
    </div>

    <div class="form-group col-md-2">
      <label for="btnLanzador"> Buscar </label>
      <button type="button" id="btnLanzador" class="btn btn-primary form-control" name="button"> Buscar </button>
    </div>

    <div class="form-group col-md-2">
      <label for="btnLanzador"> Lanazar </label>
      <button type="button" id="btnLanzadorEncuesta" class="btn btn-primary form-control" name="button"> Lanzar </button>
    </div>

  </div>
</form>

<table class="table table-hover p-5">
  <thead>
    <tr>
      <td> N° </td>
      <td> Nombres </td>
      <td> Rut </td>
      <td> Email </td>
      <td> Carrera </td>
    </tr>
  </thead>
  <tbody id="tableBodyDataFilter">
      <?php $count = 0 ; ?>
      <?php  foreach ( $datos as $dato ) : ?>
        <tr>
          <td> <?php $count++ ; echo $count ;   ?> </td>
          <td> <?php echo $dato->names ;        ?> </td>
          <td class="rutDataUser" data-rut='<?php echo $dato->rut ?>'> <?php echo $dato->rut ;          ?> </td>
          <td> <?php echo $dato->email ;        ?> </td>
          <td> <?php echo $dato->name_carrera ; ?> </td>
        </tr>
      <?php endforeach ; ?>
    </tbody>

</table>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="idModalEncuesta" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModalEncuesta"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="tipo_encuesta"></p>
        <p id="update_encuesta"></p>
        <p id="create_encuesta"></p>
        <p id="largoEncuestaForm"></p>
        <div id="container_preguntas_encuestas">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
