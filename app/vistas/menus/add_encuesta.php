<form id="formAddEncuesta" action="<?php echo RUTA_URL; ?>encuestascontroller/addEncuesta" method="post">
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div class="card mt-4">
        <div class="card-header bg-secondary">
          <h4 class="text-center">Crear Encuesta</h4>
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
              <select id="select_largo_encuesta" class="form-control" name="select_largo_encuesta">
                <option id="1" value="1">1</option>
                <option id="2" value="2">2</option>
                <option id="3" value="3">3</option>
                <option id="4" value="4">4</option>
                <option id="5" value="5">5</option>
              </select>
            </div>
            <input type="text" style="display:none;" id="largoEncuesta" value="">
          </div>
          <div class="form-group" id="input">
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
