window.addEventListener('load', function(){

  const buttonsEditar = document.querySelectorAll(".editarEncuesta");
  for (const button of buttonsEditar) {
    button.addEventListener('click', function(event) {
      var tableEncuestaEdit = document.querySelector("#tableEncuestaEdit") ;
      var formEncuestaEdit  = document.querySelector("#formEncuestaEdit") ;
      tableEncuestaEdit.style.display = 'none'  ;
      formEncuestaEdit.style.display  = 'block' ;
      GetEncuesta( this.dataset.id ) ;

    });
  }


  const buttonsDelete = document.querySelectorAll(".deleteEncuestaClass");
  for (const button of buttonsDelete) {
    button.addEventListener('click', function( e ) {
      e.preventDefault();
      var idEncuesta = this.dataset.id ;
      bootbox.confirm({
          message: "¿Estás seguro que deseas eliminar la encuesta? <br> Ten en cuenta que no se podrá recuperar.",
          buttons: {
              confirm: {
                  label: 'Borrar',
                  className: 'btn-danger'
              },
              cancel: {
                  label: 'Cancelar',
                  className: 'btn-success'
              }
          },
          callback: function (result) {
            if(result != true)
            {
              console.log( 'false' ) ;
              return ;
            }
            var url = 'http://localhost/encuestas-web/encuestascontroller/deleteencuesta?id_encuesta=' + idEncuesta ;
            console.log( url );
            fetch( url ,{  //url de la ruta para enviar ajax
              method 	: 'GET' , // metodo de envio POST,GET,PUT, etc.
            })
            .then( res 	=> res.json() )
            .then( data => {
              document.querySelector('#id_encuesta_'+ data.id_encuesta).remove();
              toastr.info('La encuesta fue borrada con éxito.');  //respuesta ajax
            })

          }
      });
    });
  }

  document.querySelector('#buttonNext').addEventListener('click' ,function( e ){
    e.preventDefault();
    if( document.querySelector('#selectTipoEncuesta').value === '0' )
    {
      var messageAlertTipoEncuesta  = document.querySelector("#messageAlertTipoEncuesta");
      messageAlertTipoEncuesta.style.display = 'block' ;
      setTimeout( function(){ messageAlertTipoEncuesta.style.display = "none"; } , 4000 );
      return false ;
    }

    if( document.querySelector('#nameEncuesta').value === '' )
    {
      var messageAlertNameEncuesta  = document.querySelector("#messageAlertNameEncuesta");
      messageAlertNameEncuesta.style.display = 'block';
      setTimeout( function(){ messageAlertNameEncuesta.style.display = "none"; } , 4000 );
      nameEncuesta.focus();
      return false;
    }

    document.querySelector(".container_encuesta").style.display = 'none' ;
    document.querySelector("#buttonNext").style.display = 'none' ;
    document.querySelector("#btnEncuestaForm").style.display = 'block' ;
    document.querySelector("#buttonBack").style.display = 'block' ;
    document.querySelector("#input").style.display = 'block' ;
  });

  document.querySelector('#buttonBack').addEventListener( 'click' , function( e ){
    e.preventDefault();

    document.querySelector(".container_encuesta").style.display = 'block' ;
    document.querySelector("#btnEncuestaForm").style.display = 'none' ;
    document.querySelector("#buttonNext").style.display = 'block' ;
    document.querySelector("#buttonBack").style.display = 'none' ;
    document.querySelector("#input").style.display = 'none' ;
  });

  document.querySelector('#btnAddEncuesta').addEventListener( 'click' , function( e ){
    e.preventDefault();

    console.log( sumarValorInputEncuesta() );


  });



});

function sumarValorInputEncuesta()
{
  var largoEncuesta = document.querySelector('#largoEncuestaTemporal') ;
  var valorInputAddEncuesta = parseInt( document.querySelector('#inputAddEncuesta').value ) ;
  largoEncuesta.value =  parseInt( largoEncuesta.value ) + valorInputAddEncuesta ;
  return largoEncuesta.value ;
}

function instanceInputs( cantidadInputs ){
  for ( i = 0 ; i < cantidadInputs ; i++ ) {
      createInputs( i + 1 );
  }
}

function createInputs( i ){
  var element = document.createElement('div');
  var input   = document.querySelector("#input");
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
  input.appendChild(element) ;
  input.style.display = 'none';
}

// Recorrer class de los botones
function GetEncuestas()
{
  var encuestas;
  fetch( 'http://localhost/encuestas-web/encuestascontroller/showencuestas')
  .then( res 	=> res.json() )
  .then( data => {
    ListarEncuestas( data ) ;
    console.log('paso1');
    LoadScript('scriptsMenus/show_encuestas');
    console.log('paso2');
  })
}

function GetEncuesta( idEncuesta )
{
  console.log('idEncuesta: ' + idEncuesta );
  fetch( 'http://localhost/encuestas-web/encuestascontroller/updateEncuesta?id_encuesta=' + idEncuesta,{     		//url de la ruta para enviar ajax
    method 	: 'GET' , // metodo de envio POST,GET,PUT, etc.
  })
  .then( res 	=> res.json() )
  .then( data => {
    console.log( data ) ;
    document.querySelector('#select_largo_encuesta').value = data.encuestaResponse.largo_encuesta ;
    document.querySelector('#selectTipoEncuesta').selectedIndex = data.encuestaResponse.tipo_encuesta ;
    document.querySelector('#nameEncuesta').value = data.encuestaResponse.name_encuesta ;
    document.querySelector('#largoEncuestaTemporal').value = data.encuestaResponse.largo_encuesta ;

    var largoEncuesta = parseInt( data.encuestaResponse.largo_encuesta ) ;
    console.log( data.encuestaPregunta ) ;
    instanceInputs( largoEncuesta ) ;
    for ( var i = 0 ; i < largoEncuesta ; i++ ) {
      document.querySelector('#preguntaText' + ( i + 1 ) ).value = data.encuestaPregunta[i].name_pregunta ;
      document.querySelector('#largoRespuesta' + ( i + 1 ) ).selectedIndex = parseInt(data.encuestaPregunta[i].largo_pregunta) - 1  ;
    }
  })
}

function LoadScript( nameScript )
{
  var script = document.createElement( "script" );
  script.type = "text/javascript";
  script.src = 'http://localhost/encuestas-web/public/js/' + nameScript + '.js';
  script.onload = function () {

  };
  document.getElementsByTagName('head')[0].appendChild(script);
}

function ListarEncuestas( data )
{
  var bodyTableEncuestas = document.querySelector('#body_table_encuestas');
  bodyTableEncuestas.innerHTML = "" ;
  var tableBody = "" ;
  var count = 1 ;
  for (var encuesta in data)
  {
     tableBody += "<tr><td>" ;
     tableBody += count ;
     tableBody += "</td><td>" ;
     tableBody += data[encuesta].name_encuesta ;
     tableBody += "</td><td>" ;
     tableBody += data[encuesta].tipo_encuesta ;
     tableBody += "</td><td>" ;
     tableBody += data[encuesta].largo_encuesta ;
     tableBody += "</td><td>" ;
     tableBody += data[encuesta].create_encuesta ;
     tableBody += "</td><td>" ;
     tableBody += "<div class='btn-group' role='group'>";
     tableBody += "<button id='btnGroupDrop1' type='button' data-id='" + data[encuesta].id_encuesta + "' class='btn btn-primary dropdown-toggle deleteEncuestaClass' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Acciones";
     tableBody += "</button>";
     tableBody += "<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>"; //data[encuesta].id_encuesta
     tableBody += "<a class='dropdown-item editarEncuesta' data-id='" + data[encuesta].id_encuesta + "'  href='#'>Actualizar Encuesta</a>" ;
     tableBody += "<a class='dropdown-item deleteEncuestaClass' data-id='" + data[encuesta].id_encuesta + "'  href='#'>Borrar Encuesta</a>" ;
     tableBody += "</div></div>";
     tableBody += "</td></tr>";
     count = count + 1 ;

  }
  bodyTableEncuestas.innerHTML = tableBody ;
}
