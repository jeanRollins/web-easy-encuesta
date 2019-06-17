<?php

class Login {

	private $db;

	public function __construct(){
		$this->db = new Base;

	}

	public function consultLogin( $email )
	{
	 	$this->db->query('SELECT id_user , email , password FROM users WHERE email=:email');
		$this->db->bind( ':email', $email );
		$result = $this->db->getRegisterBd();
		return $result ;
	}


}



 ?>
