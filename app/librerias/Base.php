<?php


class Base{


 	private $host=DB_HOST;
 	private $user=DB_USUARIO;
 	private $password=DB_PASSWORD;
 	private $name_db=DB_NOMBRE;

 	private $dbh;
 	private $stmt;
 	private $error;

 	public function __construct(){

 		$dsn = 'mysql:host=' . $this->host. ';dbname=' .$this->name_db;

 		$options = array(
 			PDO::ATTR_PERSISTENT => true,
 			PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION
 		);

 		try{
 			$this->dbh = new PDO($dsn,$this->user,$this->password,$options);
 			$this->dbh->exec('set names utf8');
 		}catch (PDOExeption $e){
 			$this->error = $e->getMessage();
 			echo $this->error;
 			die();
 		}
 	}

 	public function query($sql){
 		$this->stmt=$this->dbh->prepare($sql);
 	}

 	public function bind($param ,$value ,$type = null){
 		if(is_null($type)){
 			switch (true){
 				case is_int($value):
 				$type= PDO::PARAM_INT;
 				break;
 				case is_bool($value):
 				$type= PDO::PARAM_BOL;
 				break;
 				case is_null($value):
 				$type= PDO::PARAM_NULL;
 				break;

 				default:
 				$type=PDO::PARAM_STR;
 				break;
 			}
 		}

 		$this->stmt->bindValue($param,$value,$type);
 	}

 	public function execute(){
 		return $this->stmt->execute();

 	}

 	public function getRegistersBd(){
 		$this->execute();
 		return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	 }

	 public function getNumberRowBd(){
	 	$this->execute();
	 	return $this->stmt->fetch(PDO::FETCH_ASSOC);
	 }

	 public function getRegisterBd(){
		 $this->execute();
		 return $this->stmt->fetch(PDO::FETCH_OBJ);
	 }

	 public function rowCount(){
 		return $this->stmt->rowCount();
 	}

 }

 ?>
