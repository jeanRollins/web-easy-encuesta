window.addEventListener('load',function(){

	var form = document.querySelector("#loginForm");
	form.addEventListener('submit',function(e){
		e.preventDefault();
		document.querySelector(".img-loading").style.display = 'block' ;
		document.querySelector(".btnLogin").style.display = 'none' ;
		var email		 = document.querySelector("#email");
		var password = document.querySelector("#password");

		if( email.value === "" ) {
			document.querySelector(".img-loading").style.display = 'none' ;
			document.querySelector(".btnLogin").style.display = 'block' ;
			var error = document.querySelector("#error");
			error.style.display = "block"; //muestra el mensaje de error
			email.focus();
			setTimeout( function(){ error.style.display = "none"; } , 4000 ); //oculta el mensaje de error despues de 4 segundos
			return false;
		}
		if( password.value === "" ){
			document.querySelector(".img-loading").style.display = 'none' ;
			document.querySelector(".btnLogin").style.display = 'block' ;
			var error2 = document.querySelector("#error2");
			password.focus();
			error2.style.display = "block" ; //muestra el mensaje de error
			setTimeout( function(){ error2.style.display = "none"; } , 4000 ); //oculta el mensaje de error despues de 4 segundos
			return false ;
		}
		url  = form.getAttribute('action') ; //obtiene el atributo action;

		var formData = new FormData( form );

		fetch( url ,{     		//url de la ruta para enviar ajax
			method 	: 'POST' , // metodo de envio POST,GET,PUT, etc.
			body		: formData //datos del formulario
		})
		.then( res 	=> res.json() )
		.then( data => {
			console.log( data );  //respuesta ajax
			if( !data.response ){
				var messageResponse = document.querySelector(".messageResponse");
				messageResponse.style.display = 'block';
				setTimeout( function(){ messageResponse.style.display = 'none'; } , 4000 );
				document.querySelector(".img-loading").style.display = 'none' ;
				document.querySelector(".btnLogin").style.display = 'block' ;
				return ;
			}
			urlUser = 'http://localhost/encuestas-web/logincontroller/dashboard';
			window.location.replace( urlUser );
		})

	});





});
