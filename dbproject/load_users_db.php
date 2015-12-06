<?php

error_reporting(1);

$host 	= 'localhost';
$user 	= 'rmannava';
$pass 	= 'rmannava2015';
$db 	= 'rmannava';

$load = new LoadTestData($host,$user,$pass,$db);

$load->addUsers(100);

class LoadTestData{

	var $db;
	var $Roles;
	var $Credits;
	function __construct($host,$user,$pass,$db){
		//connect to database on local server
		$this->db = new mysqli($host,$user,$pass,$db);

		if ($this->db->connect_errno) {
			echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
		}
		
		$this->Roles = array();
		$this->Credits = array();
		$this->loadRoles();
		$this->loadCreditIds();		
	}
	
	function addUsers($number=100){
		$result = $this->db->query("TRUNCATE Users");
		$json_array = json_decode(file_get_contents("http://api.randomuser.me/?results=100"));
		
		for($i=0;$i<$number;$i++){		
			
				$uuid = uniqid();			
				//Get rest of user info
				$first = $json_array->results[$i]->user->name->first;
				$last = $json_array->results[$i]->user->name->last;
				$Street = $json_array->results[$i]->user->location->street;
				$City = $json_array->results[$i]->user->location->city;
				$State = $json_array->results[$i]->user->location->state;
				$Zip = $json_array->results[$i]->user->location->zip;
				$Email = $json_array->results[$i]->user->email;		
				$Password = $json_array->results[$i]->user->password;
				$Phone = $json_array->results[$i]->user->phone;			
				$role = $this->randomRole();
				$creditId = $this->getCreditId($i);
				$query = "INSERT INTO Users VALUES ('$uuid','$last','$first','$Street','$City','$State','$Zip','$Email','$Password','$Phone','$role','$creditId')";
				echo $query."\n";
				$result = $this->db->query($query);
		}
	}
	
	function randomRole(){
		return $this->Roles[rand()%3]['Role_Id'];
	}

	function getCreditId($i){
		return $this->Credits[$i]['Credit_Id'];
	}
	
	private function loadRoles(){
		
		$query = "SELECT Role_Id FROM Role";
        $result = $this->db->query($query);
        if($result) {
            while ($row = $result->fetch_assoc()) {
            	$this->Roles[] = $row;
             }
        }
	}
	
	private function loadCreditIds(){
		
		$query = "SELECT Credit_Id FROM Credit_Details";
        $result = $this->db->query($query);
        if($result) {
            while ($row = $result->fetch_assoc()) {
            	$this->Credits[] = $row;
             }
        }		
	}
}

