<style>
	.img-loading{
		width:  35% ;
		margin-left: 25%;
		display: none;
	}
</style>
<?php require RUTA_APP . '/vistas/inc/header.php';?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>

</head>
<body>
	<form id="loginForm" action="<?php echo RUTA_URL; ?>logincontroller/loginAuth" method="post">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-4">
				<div class="card card-center mt-4">
					<div class="card-header">
						<h4 class="text-center">Login Encuestas Web</h4>
					</div>
					<div class="card-body">
						<div class="form-group">
							<p>Email</p>
							<input type="text" class="form-control" id="email" name="email">
							<p id="error" style="display: none; color:red;">Debe ingresar un 	Correo.</p>
						</div>
						<div class="form-group">
							<p>Contraseña</p>
							<input type="password" class="form-control" id="password" name="password">
							<br>
							<p id="error2" style="display:none; color:red;">Debe ingresar una Contraseña.</p>
							<p class="messageResponse" style="display:none; color:red;">Contraseña o Usuario Incorrecto.</p>
						</div>
						<button type="submit"  class="btn btn-outline-success btn-block btnLogin" >Ingresar</button>
						<div class="center-block img-loading">
							<img src="<?php echo RUTA_IMG; ?>/load.gif"  class="img-fluid"  alt="Responsive image">
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
</form>
</body>
</html>
<?php require RUTA_APP . '/vistas/inc/footer_login.php';?>
