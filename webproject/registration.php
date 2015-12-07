<?php

error_reporting(1);

$host 	= 'localhost';
$user 	= 'rmannava';
$pass 	= 'rmannava2015';
$db 	= 'rmannava';

$load = new LoadReservations($host,$user,$pass,$db);

$load->addUser();

class LoadReservations{

	var $db;	
	
	function __construct($host,$user,$pass,$db){
		//connect to database on local server
		$this->db = new mysqli($host,$user,$pass,$db);

		if ($this->db->connect_errno) {
			echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
		}
	}
	function addUser(){
		
		$id = $this->checkId(uniqid());
		//$this->checkId($id);
		//echo $id;
		$firstname = $_POST['fn'];
		$lastname = $_POST['ln'];
		$street = $_POST['street'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$email = $_POST['email'];		
		$password = $_POST['password'];
		$phone = $_POST['phone'];
		$creditcard = $_POST['ccn'];
		$expiration = $_POST['exp'];
		$cvc = $_POST['cvc'];
		$credit_id = ($this->getLastCreditId()) + 1;
		//$this->insertCreditDetails($credit_id,$creditcard,$expiration,$cvc);
		$role_id = $this->getRoleId();
		//echo $credit_id."\n";
		//echo $role_id."\n";
		$result = $this->insertUser($id,$firstname,$lastname,$street,$city,$state,$zip,$email,$password,$phone,$credit_id,$creditcard,$expiration,$cvc,$role_id);			
		if($result > 0)
			header('Location: login.html');
		else
			header('Location: Registration_Form.html');
	}
	
	function checkId($id){
		$query = "SELECT * FROM  `Users` WHERE UUID =  '$id'";		
        $result = $this->db->query($query);   
		if(empty($result->fetch_assoc())){
			//echo "empty";
			return $id;
		}
		else{
			//echo $result->fetch_assoc()['First_Name'];
			$this->checkId(uniqid());
		}		
	}
	
	function getLastCreditId(){
		$query = "SELECT MAX( Credit_Id ) AS credit FROM Credit_Details";		
        $result = $this->db->query($query);        
		return $result->fetch_assoc()['credit'];
	}
	
	private function insertCreditDetails($credit_id,$creditcard,$expiration,$cvc){		
		//echo "data";		
		$query = "INSERT INTO Credit_Details VALUES ('$credit_id','$creditcard','$expiration','$cvc')";
		//echo $query."\n";
		$result = $this->db->query($query);
	}
	
	function getRoleId(){
		$query = "SELECT Role_Id FROM Role WHERE User_Type =  'Passenger'";		
        $result = $this->db->query($query);        
		return $result->fetch_assoc()['Role_Id'];
	}
	
	private function insertUser($id,$firstname,$lastname,$street,$city,$state,$zip,$email,$password,$phone,$credit_id,$creditcard,$expiration,$cvc,$role_id){		
		$this->insertCreditDetails($credit_id,$creditcard,$expiration,$cvc);
		//echo "data";		
		$query = "INSERT INTO Users VALUES ('$id','$lastname','$firstname','$street','$city','$state','$zip','$email','$password','$phone','$role_id','$credit_id')";
		//echo $query."\n";
		$result = $this->db->query($query);
		//echo $result;
		return $result;
	}
}