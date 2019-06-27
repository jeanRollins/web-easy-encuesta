window.addEventListener( 'load' , function() {
  console.log('Lanzador');
  GetDataEncuesta();

  document.querySelector('#btnLanzador').addEventListener( 'click', function(e){
    e.preventDefault() ;
    var inputSelectCarrera    = document.querySelector('#inputSelectCarrera').value ;
    var inputSelectSeccion    = document.querySelector('#inputSelectSeccion').value ;
    var inputSelectAsignatura = document.querySelector('#inputSelectAsignatura').value ;
    var formLanzadorEncuesta  = new FormData() ;

    formLanzadorEncuesta.append( 'inputSelectCarrera' , inputSelectCarrera );
    formLanzadorEncuesta.append( 'inputSelectSeccion' , inputSelectSeccion );
    formLanzadorEncuesta.append( 'inputSelectAsignatura' , inputSelectAsignatura );
    url = document.querySelector('#formLanzadorEncuesta').getAttribute('action') ;

    fetch( url ,{
      method : 'POST',
      body   : formLanzadorEncuesta
    })
    .then( res  => res.json() )
    .then( data => {
      console.log( data ) ;
      setTableBodyDataFilter( data );
    })

  });

  document.querySelector('#btnLanzadorEncuesta').addEventListener( 'click' , function(e){
    e.preventDefault();
    var dataRut = [] ;
    var rutDataUser = document.querySelectorAll('.rutDataUser');
    var formLanzador = new FormData() ;
    formLanzador.append( 'id_encuesta' , document.querySelector('#inputHiddenIdEncuesta').value ) ;

    for( const rutUser of rutDataUser ) {
        console.log( rutUser.dataset.rut );
        dataRut.push( rutUser.dataset.rut );
    }

    formLanzador.append( 'dataRut' , dataRut ) ;
    bootbox.confirm({
        message: "¿Estás seguro que deseas lanzar las encuestas?",
        buttons: {
            confirm: {
                label: 'Lanzar',
                className: 'btn-primary'
            },
            cancel: {
                label: 'Cancelar',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
          if(result != true)
          {
            console.log( 'false' ) ;
            return ;
          }

          var url = 'http://localhost/encuestas-web/encuestascontroller/LanzarEncuesta' ;
          fetch( url ,{
            method : 'POST' ,
            body   : formLanzador
          })
          .then( res 	=> res.text() )
          .then( data => {
            console.log( data );
            //toastr.info('La encuesta fue borrada con éxito.');  //respuesta ajax
          })

        }
    });

  });

});

function setTableBodyDataFilter( data ){
  tableBodyDataFilter = document.querySelector('#tableBodyDataFilter') ;
  tableBodyDataFilter.innerHTML = '' ;
  var largoDataLanzador = Object.keys( data ).length ;
  var tableBody = '' ;
  for (var i = 0; i < largoDataLanzador ; i++) {

    tableBody += "<tr><td>"   + i + 1  ;
    tableBody += "</td><td>"  + data[i].names   ;
    tableBody += "</td><td class='rutDataUser' data-rut='" + data[i].rut + "' >"  + data[i].rut   ;
    tableBody += "</td><td>"  + data[i].email ;
    tableBody += "</td><td>"  + data[i].name_carrera ;
    tableBody += "</td></tr>" ;
  }
  tableBodyDataFilter.innerHTML = tableBody ;
}

function GetDataEncuesta( ){
  url = 'http://localhost/encuestas-web/lanzadorcontroller/GetDataLanzador' ;
  fetch( url ,{
  })
  .then( res 	=> res.json() )
  .then( data => {
    console.log( data );
    setSelectsCarrera( data.carreras ) ;
    setSelectsSeccion( data.secciones ) ;
    setSelectsAsignatura( data.asignaturas ) ;
  })
}

function setSelectsAsignatura( data ){
  var select = '' ;
  var largoDataLanzador = Object.keys( data ).length ;
  var inputSelectAsignatura = document.querySelector('#inputSelectAsignatura') ;
  select += "<option value='0'>Seleccione Asignatura </option>" ;

  for ( var i = 0 ; i < largoDataLanzador ; i++ ) {
    select += "<option value='" + data[i].id_asignatura + "'>" + data[i].name_carrera + " </option>" ;
  }

  inputSelectAsignatura.innerHTML = select ;
}

function setSelectsCarrera( data ){
  var select = '' ;
  var largoDataLanzador = Object.keys( data ).length ;
  var inputSelectCarrera = document.querySelector('#inputSelectCarrera') ;
  select += "<option value='0'>Seleccione Carrera </option>" ;

  for ( var i = 0 ; i < largoDataLanzador ; i++ ) {
    select += "<option value='" + data[i].id_carrera + "'>" + data[i].name_carrera + " </option>" ;
  }
  inputSelectCarrera.innerHTML = select ;
}

function setSelectsSeccion( data ){
  var select = '' ;
  var largoDataLanzador = Object.keys( data ).length ;
  var inputSelectSeccion = document.querySelector('#inputSelectSeccion') ;
  select += "<option value='0'>Seleccione Sección </option>" ;

  for ( var i = 0 ; i < largoDataLanzador ; i++ ) {
    select += "<option value='" + data[i].id_seccion + "'>" + data[i].name_seccion + " </option>" ;
  }
  inputSelectSeccion.innerHTML = select ;
}
