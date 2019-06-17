
<?php
session_start();
class Logincontroller extends Controlador{



	public function  __construct(){
		//crear una variable this usuario modelo y llamo al metodo carga modelo
		// pasandole como parametro la clase usuario

		$this->usuarioModelo = $this->cargaModelo('Usuario');
		$this->cargaApi = $this->cargaLibreria('Api');
		$this->loginModelo = $this->cargaModelo('Login');

	}

	public function index(){

		$this->cargaVista('paginas/inicio');
	}

	public function login(){
		$this->cargaVista('paginas/login');
	}

	public function LoginAuth()
	{
		extract( $_POST ) ;

		if( $_SERVER['REQUEST_METHOD'] !='POST' || count( $_POST ) == 0 )
		{
			echo 'false' ;
			return false ;
		}
		if( empty( $email ) || empty( $password ) )
		{
			echo 'false' ;
			return false;
		}
		if( !isset( $email ) || !isset( $password ) )
		{
			echo 'false' ;
			return false ;
		}

		try {

			$email = $this->Sanity( $email ) ; //metodo para limpiar caracteres raros
			$response = $this->Validate( $email , $password ) ; //funcion para validar usuario

		 	if( !$response )
			{
				$data = array(
						'response' => false ,
						'data' 		 => 0
				);
				echo json_encode( $data , JSON_FORCE_OBJECT ) ;
				return false ;
			}
			//Guarda id del usuario y genera Token para usuario
			$_SESSION['idUser']  = $response->id_user ;
			$_SESSION['token']   = $this->GenerateToken();
			$_SESSION['active']  = 1 ;
			//redirect('logincontroller/dashboard');
			$data = array(
					'response' => true ,
					'data' 		 => (int)$response->id_user
			);
			echo json_encode( $data , JSON_FORCE_OBJECT ) ;

		} catch (\Exception $exception)
		{
			echo 'Error LoginAuth : ' . $exception->getMessage() ;
		}


	}

	private function Validate( $email , $password )
	{
		$userFounded = $this->loginModelo->consultLogin( $email ) ;

		if( $userFounded == NULL ){

			return false ;
		}
		if( $email != $userFounded->email ){

			return false ;
		}
		if( !password_verify( $password , $userFounded->password ) ){

			return false ;
		}
		return $userFounded ;
	}

	public function dashboard()
	{
		extract( $_SESSION );
		$this->ValidateSession( $_SESSION ) ;
		$userFounded = $this->usuarioModelo->getUser( (int) $idUser );

		$_SESSION['names'] = $userFounded->names ;

		$this->cargaVista('paginas/dashboard' , $userFounded ) ;
	}

	public function encuesta(){
		$this->cargaVista('paginas/home/createpoll');
	}


	public function addPool(){

		$pregunta="pregunta";
		$select=$_POST['select'];
		echo $select."<br>";

		for($i = 1;$i<=$select;$i++){
			$pregunta.$i=$_POST['pregunta'.$i];
			echo $pregunta.$i."<br>";
		}


	}

	public function createVariable($i,$preguntas){
			$preguntaguardada=$preguntas.$i;
			$preguntaguardada=$_POST['pregunta'.$i];
	}

	private function GenerateToken()
	{
		return bin2hex(openssl_random_pseudo_bytes(64)) ;
	}






}

 ?>
