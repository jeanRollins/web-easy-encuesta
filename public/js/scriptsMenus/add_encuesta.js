window.addEventListener('load',function(){
  //$('#tableEditEncuestas').DataTable();



  //Envio de formulario Encuesta
  document.querySelector('#btnEncuestaForm').addEventListener('click', function(e){
    this.style.display = 'none';
    e.preventDefault();
    var nameEncuesta  = document.querySelector('#nameEncuesta') ;
    var selectTipoEncuesta  = document.querySelector('#selectTipoEncuesta') ;
    var largoEncuesta = parseInt( document.querySelector("#largoEncuesta").value ) ;

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

    formAddEncuesta = document.querySelector("#formAddEncuesta") ;
    var form = new FormData( formAddEncuesta ) ;

    url = formAddEncuesta.getAttribute('action') ; //obtiene el atributo action;
    console.log( url );

    fetch( url ,{     		//url de la ruta para enviar ajax
      method 	: 'POST' , // metodo de envio POST,GET,PUT, etc.
      body		: form //datos del formulario
    })
    .then( res 	=> res.json() )
    .then( data => {
      console.log( data );
      if( data.response !=true )
      {
        document.querySelector('#btnEncuestaForm').style.display = 'block';
        setTimeout( function(){ document.querySelector('.messa_response_fail_encuesta').style.display = 'block'} , 5000);
        return ;
      }
      toastr.info('Encuesta agregada '+ data.message + ' fue con exito');  //respuesta ajax
    })
  });

});
