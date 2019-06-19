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
    var largoEncuestaTemporal = parseInt(document.querySelector('#largoEncuestaTemporal').value) ;
    var inputAddEncuesta = parseInt( document.querySelector('#inputAddEncuesta').value ) ;
    var largoTotal = largoEncuestaTemporal + inputAddEncuesta ;

    if( isNaN( inputAddEncuesta ) ){
      document.querySelector('#messageAlertAddEncuestaMenorCero').style.display = 'block' ;
      setTimeout( function(){ document.querySelector('#messageAlertAddEncuestaMenorCero').style.display = 'none'; } , 5000 );
      return false;
    }

    if( inputAddEncuesta < 1 ){
      document.querySelector('#messageAlertAddEncuestaMenorCero').style.display = 'block' ;
      setTimeout( function(){ document.querySelector('#messageAlertAddEncuestaMenorCero').style.display = 'none'; } , 5000 );
      return false;
    }
    if( inputAddEncuesta == 0 || inputAddEncuesta == '' ){
      document.querySelector('#messageAlertAddEncuestaVacio').style.display = 'block' ;
      setTimeout( function(){ document.querySelector('#messageAlertAddEncuestaVacio').style.display = 'none'; } , 5000 );
      return false;
    }
    document.querySelector('#largoEncuestaTemporal').value = largoTotal ;
    for (;;) {
      largoEncuestaTemporal++ ;
      createInputs( largoEncuestaTemporal ) ;
      if( largoEncuestaTemporal > 0 ) { enableElement( 'btnDeleteEncuesta' ) ; }

      if( largoEncuestaTemporal == largoTotal ) { break; }
    }
  });

  document.querySelector('#btnDeleteEncuesta').addEventListener( 'click' , function(e){
    var largoEncuestaTemporal = parseInt(document.querySelector('#largoEncuestaTemporal').value) ;
    var inputAddEncuesta  = parseInt( document.querySelector('#inputAddEncuesta').value ) ;
    var largoTotalRestado = largoEncuestaTemporal - inputAddEncuesta ;

    if( isNaN( inputAddEncuesta ) ){
      document.querySelector('#messageAlertAddEncuestaMenorCero').style.display = 'block' ;
      setTimeout( function(){ document.querySelector('#messageAlertAddEncuestaMenorCero').style.display = 'none'; } , 5000 );
      return false;
    }

    if( inputAddEncuesta == 0 || inputAddEncuesta == '' ){
      document.querySelector('#messageAlertAddEncuestaVacio').style.display = 'block' ;
      setTimeout( function(){ document.querySelector('#messageAlertAddEncuestaVacio').style.display = 'none'; } , 5000 );
      return false;
    }

    if( inputAddEncuesta < 1 ){
      document.querySelector('#messageAlertAddEncuestaMenorCero').style.display = 'block' ;
      setTimeout( function(){ document.querySelector('#messageAlertAddEncuestaMenorCero').style.display = 'none'; } , 5000 );
      return false;
    }

    console.log( 'largoEncuestaTemporal: ' + largoEncuestaTemporal );
    console.log( 'largoTotalRestado: ' + largoTotalRestado );
    console.log('______________________');

    if( largoTotalRestado < 0 ){
      document.querySelector('#messageAlertAddEncuesta').style.display = 'block' ;
      setTimeout( function(){ document.querySelector('#messageAlertAddEncuesta').style.display = 'none'; } , 5000 );
      return false;
    }
    document.querySelector('#largoEncuestaTemporal').value = largoTotalRestado ;

    for(;;){
      document.querySelector('#form-pregunta' + largoEncuestaTemporal ).remove() ;
      document.querySelector('#form-respuesta' + largoEncuestaTemporal ).remove() ;
      console.log( 'largoEncuestaTemporal: ' + largoEncuestaTemporal );
      largoEncuestaTemporal-- ;
      if( largoEncuestaTemporal < 1){
        disableElement('btnDeleteEncuesta');
      }
      else{
        enableElement( 'btnDeleteEncuesta' ) ;
      }
      if( largoEncuestaTemporal == largoTotalRestado ){  break ; }
    }
  });
  document.querySelector('#btnEncuestaForm').addEventListener( 'click' , function(e){
    //this.style.display = 'none';
    e.preventDefault();
    var nameEncuesta  = document.querySelector('#nameEncuesta') ;
    var selectTipoEncuesta  = document.querySelector('#selectTipoEncuesta') ;
    var largoEncuesta = parseInt( document.querySelector('#largoEncuestaTemporal').value ) ;
    enableElement( 'select_largo_encuesta' );
    document.querySelector('#select_largo_encuesta_old').value = document.querySelector('#select_largo_encuesta').value ;

    document.querySelector('#select_largo_encuesta').value = largoEncuesta ;

    for (var i = 0 ; i < largoEncuesta ; i++) {
      if( document.querySelector('#preguntaText'+ ( i + 1 ) ).value == '' )
      {
        document.querySelector('#messageResponsePregunta'+ ( i + 1 ) ).style.display = 'block' ;
        setTimeout( function(){ document.querySelector('#messageResponsePregunta'+ ( i + 1 ) ).style.display = 'none'; } , 4000 );
        document.querySelector('#messageResponsePregunta'+ ( i + 1 ) ).focus();
        return false ;
        break;
      }

      if( document.querySelector('#largoRespuesta'+ ( i + 1 ) ).value == '0' )
      {
        document.querySelector('#messageResponseLargoRespuesta'+ ( i + 1 ) ).style.display = 'block' ;
        setTimeout( function(){ document.querySelector('#messageResponseLargoRespuesta' + ( i + 1 ) ).style.display = 'none'; } , 4000 );
        document.querySelector('#messageResponseLargoRespuesta'+ ( i + 1 ) ).focus() ;
        return false ;
        break ;
      }
    }

    formEditEncuesta = document.querySelector("#formEditEncuesta") ;
    var form = new FormData( formEditEncuesta ) ;

    url = formEditEncuesta.getAttribute('action') ; //obtiene el atributo action;
    console.log( url );

    fetch( url ,{
      method : 'POST',
      body   : form
    })
    .then( res  => res.text() )
    .then( data => {
      console.log( data ) ;
    })
  });

});

function disableElement( element ){
  document.querySelector( '#' + element ).disabled = true ;
}
function enableElement( element ){
  document.querySelector( '#' + element ).disabled = false ;
}

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
  <div class="form-group" id="form-pregunta${i}">
    <p>Pregunta ${i}</p>
    <input type="text" id="preguntaText${i}" name="preguntaText${i}"  class="form-control"/>
    <p id="messageResponsePregunta${i}" style="display:none;color:red;">Debe agregar una pregunta.</p>
  </div>
  <div class="form-group" id="form-respuesta${i}">
    <p>Cantidad Respuestas</p>
    <select id="largoRespuesta${i}" name="largoRespuesta${i}"  class="form-control">
      <option value="0">Cantidad Respuestas</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
    </select>
    <p id="messageResponseLargoRespuesta${i}" style="display:none;color:red;">Debe agregar un largo.</p>
  </div>`;
  input.appendChild(element) ;

}

// Recorrer class de los botones
function GetEncuestas()
{
  var encuestas;
  fetch( 'http://localhost/encuestas-web/encuestascontroller/showencuestas')
  .then( res 	=> res.json() )
  .then( data => {
    ListarEncuestas( data ) ;
    LoadScript('scriptsMenus/show_encuestas');
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
    console.log( 'data.encuestaResponse.largo_encuesta: ' + data.encuestaResponse.largo_encuesta );
    document.querySelector('#largoEncuestaTemporal').value = data.encuestaResponse.largo_encuesta ;

    var largoEncuesta = parseInt( data.encuestaResponse.largo_encuesta ) ;
    console.log( data.encuestaPregunta ) ;
    instanceInputs( largoEncuesta ) ;
    input.style.display = 'none';
    for ( var i = 0 ; i < largoEncuesta ; i++ ) {
      document.querySelector('#preguntaText' + ( i + 1 ) ).value = data.encuestaPregunta[i].name_pregunta ;
      document.querySelector('#largoRespuesta' + ( i + 1 ) ).selectedIndex = parseInt(data.encuestaPregunta[i].largo_pregunta) - 1  ;
    }
    if( largoEncuesta < 1 ){
      disableElement('btnDeleteEncuesta') ;
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

function bloquearCaracteres(string){
    var out = '';
    var filtro = '1234567890';

    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1)
	     out += string.charAt(i);
    return out;
}
