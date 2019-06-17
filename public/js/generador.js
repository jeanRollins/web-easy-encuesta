
window.addEventListener('load',function(){

var i = "" ;
var input = document.querySelector("#input");
var select = document.querySelector("#select_largo_encuesta");
var buttonNext = document.querySelector("#buttonNext");
var buttonNext = document.querySelector("#buttonNext");
var buttonBack = document.querySelector("#buttonBack");
var nameEncuesta  = document.querySelector("#nameEncuesta");
var btnEncuestaForm  = document.querySelector("#btnEncuestaForm");
var containerEncuesta = document.querySelector(".container_encuesta");
var selectTipoEncuesta = document.querySelector("#selectTipoEncuesta");

buttonNext.addEventListener( 'click',function(e){
  e.preventDefault();
  document.querySelector("#largoEncuesta").value = select.value ;
  if( selectTipoEncuesta.value === '0' )
  {
    var messageAlertTipoEncuesta  = document.querySelector("#messageAlertTipoEncuesta");
    messageAlertTipoEncuesta.style.display = 'block' ;
    setTimeout( function(){ messageAlertTipoEncuesta.style.display = "none"; } , 4000 );
    return false ;
  }

  if( nameEncuesta.value === '' )
  {
    var messageAlertNameEncuesta  = document.querySelector("#messageAlertNameEncuesta");
    messageAlertNameEncuesta.style.display = 'block';
    setTimeout( function(){ messageAlertNameEncuesta.style.display = "none"; } , 4000 );
    nameEncuesta.focus();
    return false;
  }

  containerEncuesta.style.display = 'none' ;
  buttonNext.style.display = 'none' ;
  btnEncuestaForm.style.display = 'block' ;
  buttonBack.style.display = 'block' ;
  input.innerHTML = "" ;

  for(i =1;i<=select.value;i++){
    createInputs();
  }
});

buttonBack.addEventListener('click',function(e){
  e.preventDefault();
  containerEncuesta.style.display = 'block' ;
  btnEncuestaForm.style.display = 'none' ;
  buttonNext.style.display = 'block' ;
  buttonBack.style.display = 'none' ;
  input.innerHTML = "" ;
});


function createInputs(){
  var element = document.createElement('div');
  element.innerHTML=`
  <div class="form-group">
    <p>Pregunta ${i}</p>
    <input type="text" id="preguntaText${i}" name="preguntaText${i}"  class="form-control"/>
    <p id="messageResponsePregunta${i}" style="display:none;color:red;">Debe agregar una pregunta.</p>
  </div>
  <div class="form-group">
    <p>Cantidad Respuestas</p>
    <select id="largoRespuesta${i}" name="largoRespuesta${i}"  class="form-control">
      <option value="0">Cantidad Respuestas</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
    </select>
    <p id="messageResponseLargoRespuesta${i}" style="display:none;color:red;">Debe agregar un largo.</p>
  </div>
  `;
  input.appendChild(element);
}

});


/*crear cada pregunta con diferentes repuestas ejemplo
pregunta uno tiene 5 respuestas
pregunta dos 3 respuestas
cada pregunta debe tener su select para selecionar cantidad respuesta
*/
