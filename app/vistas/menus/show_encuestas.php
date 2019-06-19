<?php $i = 0 ; ?>
<h3 align="center" class="mt-3 mb-3">Mantenedor de Encuestas</h3>
<div class="container_show_encuestas p-3">
  <table id="tableEncuestaEdit" class="table table-hover">
    <thead>
      <tr>
        <td> <strong> N° </strong>  </td>
        <td> <strong>Nombre Encuesta</strong> </td>
        <td> <strong>Tipo Encuesta</strong>  </td>
        <td> <strong>Largo Encuesta</strong> </td>
        <td> <strong>Fecha de Edición</strong> </td>
        <td> <strong> Acciones </strong> </td>
      </tr>
    </thead>
    <tbody id="body_table_encuestas">
      <?php foreach( $datos['encuestas'] as $encuesta ): ?>
        <tr id='id_encuesta_<?php echo $encuesta->id_encuesta ;?>'>
          <td><?php $i++; echo $i ; ?> </td>
          <td> <?php echo $encuesta->name_encuesta ; ?> </td>
          <td> <?php echo $encuesta->tipo_encuesta ; ?> </td>
          <td> <?php echo $encuesta->largo_encuesta ; ?> </td>
          <td> <?php echo $encuesta->update_encuesta ; ?> </td>
          <td>
            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acción
              </button>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a class="dropdown-item btnGroupDrop editarEncuesta" data-id='<?php echo $encuesta->id_encuesta ;?>' href="#">Actualizar</a>
                <a class="dropdown-item deleteEncuestaClass" data-id='<?php echo $encuesta->id_encuesta ;?>' href="#">Borrar Encuesta</a>
              </div>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="" id="formEncuestaEdit" style="display:none;">
  <form id="formEditEncuesta" action="<?php echo RUTA_URL; ?>encuestascontroller/actualizarEncuesta" method="POST">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card mt-4">
          <div class="card-header bg-secondary">
            <h4 class="text-center">Editar Encuesta</h4>
          </div>
          <div class="card-body bg-light">
            <div class="container_encuesta">
              <div class="form-group">
                <p>Tipo de Encuesta</p>
                <select id="selectTipoEncuesta" class="form-control" name="selectTipoEncuesta">
                  <option value="0"> ... </option>
                  <option value="1"> Estudiantes</option>
                  <option value="2"> Publica </option>
                </select>
                <p style="display:none; color:red;" id="messageAlertTipoEncuesta">Debe seleccionar un tipo de encuesta.</p>
              </div>
              <div class="form-group">
                <p>Nombre Encuesta</p>
                <input type="text" id="nameEncuesta" name="nameEncuesta" class="form-control" >
                <p style="display:none; color:red;" id="messageAlertNameEncuesta">Debe Agregar un nombre de encuesta.</p>
              </div>
              <div class="form-group">
                <p>Cantidad de preguntas por Encuesta</p>
                <input type="number" id="select_largo_encuesta" name="select_largo_encuesta" class="form-control" disabled  value="">
                <input type="number" id="select_largo_encuesta_old" style="display:none; color:red;"  name="select_largo_encuesta_old" class="form-control"  value="">
              </div>
              <input type="text" style="display:none;" id="largoEncuesta"  value="">
            </div>
            <div class="form-group" id="input">
              <input type="text" id="largoEncuestaTemporal" name="" style="display:none;" value="">
              <div class="input-group mb-3">
                <input type="number" id="inputAddEncuesta" onkeyup="this.value = bloquearCaracteres( this.value )" class="form-control" placeholder="Agregar o quitar respuestas" aria-label="Recipient's username with two button addons" aria-describedby="button-addon4">
                <div class="input-group-append" id="button-addon4">
                  <button class="btn btn-primary" id="btnAddEncuesta" type="button">Agregar</button>
                  <button class="btn btn-danger" id="btnDeleteEncuesta" type="button">Quitar</button>
                </div>
              </div>
              <p style="display:none; color:red;" id="messageAlertAddEncuesta">No puede sacar menos preguntas de las que hay.</p>
              <p style="display:none; color:red;" id="messageAlertAddEncuestaVacio">Debe agregar un valor en el input.</p>
              <p style="display:none; color:red;" id="messageAlertAddEncuestaMenorCero">Debe agregar un valor mayor a cero.</p>
            </div>
            <button  id="buttonNext" class="btn btn-success btn-block">Siguiente</button>
            <p class="messa_response_fail_encuesta" style="display:none; color:red;">No se pudo agregar encuesta. Intente más tarde. </p>
            <div class="form-group row">
              <div class="col-6">
                <button  id="buttonBack" style="display:none;" class="btn btn-danger btn-block">Volver</button>
              </div>

              <div class="col-6">
                <p style="display:none; color:green;" align="center" class="procesando_message">Procesando...</p>
                <button type="submit" id="btnEncuestaForm" style="display:none;" name="submit" class="btn btn-success btn-block">Crear Encuesta</button>
              </div>
            </div>
            <div class="zone_buttons">

            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

</div>
