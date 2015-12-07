<?php

error_reporting(1);

$host 	= 'localhost';
$user 	= 'rmannava';
$pass 	= 'rmannava2015';
$db 	= 'rmannava';

$load = new LoadReservations($host,$user,$pass,$db);

$load->checkUser();

class LoadReservations{

	var $db;	
	
	function __construct($host,$user,$pass,$db){
		//connect to database on local server
		$this->db = new mysqli($host,$user,$pass,$db);

		if ($this->db->connect_errno) {
			echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
		}
	}
	
	function checkUser(){
		$email = $_POST['email'];
		$password = $_POST['password'];
		//echo $email;
		//echo $password;
		$this->getResult($email,$password);
	}
	
	function getResult($email,$password){
		$query = "SELECT * FROM  `Users` WHERE Email_Address =  '$email' and Password = '$password'";		
        $result = $this->db->query($query);   
		if(empty($result->fetch_assoc())){
			 header('Location: login.html');
		}
		else{
			//echo "success";
			//$json = json_encode(array("login"=>true));
			 header('Location: passengers.php');
		}		
	}
}