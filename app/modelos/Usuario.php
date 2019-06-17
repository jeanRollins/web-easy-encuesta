
<?php

class Usuario{

  private $db;


  public function __construct(){
      $this->db = new Base;
  }

  public function getUser( $idUser )
  {
    	$this->db->query( 'SELECT * FROM users WHERE id_user=:id_user' );
      $this->db->bind( ':id_user', $idUser );
      $result = $this->db->getRegisterBd();
      return $result ;
  }

  /*
  public function AddUser()
	{
    $password = '123456' ;
    $password = password_hash( $password , PASSWORD_BCRYPT ) ;
	 	$this->db->query("insert into users
                      values
    ( NULL, '2222222', 1 ,  'Luis Luis', 'Tapia Tapia', 1 , 'jsglhf5j45qhr389inbwvhirkbs', '" . $password . "' , 'luis@luis.cl'),
    ( NULL, '3333333', 1 ,  'Franco Franco', 'Maturana Maturana', 1 , '85hrkfndklhf5j45qhr389inbwvhirkbs', '" . $password . "' , 'franco@franco.cl')");
		//$this->db->bind( ':email', $email );
		$result = $this->db->getRegisterBd();
		return $result ;
	}
  */


}
