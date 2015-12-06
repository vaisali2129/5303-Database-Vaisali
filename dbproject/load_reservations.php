<?php

error_reporting(1);

$host 	= 'localhost';
$user 	= 'rmannava';
$pass 	= 'rmannava2015';
$db 	= 'rmannava';

$load = new LoadReservations($host,$user,$pass,$db);

$load->addReservations();

class LoadReservations{

	var $db;
	var $Flights;
	var $Meals;
	var $Users;
	var $Class;
	
	function __construct($host,$user,$pass,$db){
		//connect to database on local server
		$this->db = new mysqli($host,$user,$pass,$db);

		if ($this->db->connect_errno) {
			echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
		}
		$this->Flights = array();
		$this->Meals = array();
		$this->Users = array();
		$this->Class = array();
		$this->loadFlights();
		$this->loadMeals();
		$this->loadUsers();
		$this->loadClasses();
	}
	function addReservations(){
		for($i=0;$i<30;$i++){
			$id = uniqid();
			$j = rand(0,29);
			$k = rand(0,100);
			$flight_number = $this->getFlightNumber($j);
			$flight_date = $this->getFlightDate($j);
			$seat_num = $this->getSeat($flight_number,$flight_date);
			$meal_id = $this->getMealId();
			$uuid = $this->getUUID($k);
			$class_id = $this->getClassId();
			$this->insertReservations($id,$flight_number,$flight_date,$seat_num,$meal_id,$uuid,$class_id);			
		}		
	}
	
	private function insertReservations($id,$flight_number,$flight_date,$seat_num,$meal_id,$uuid,$class_id){		
		echo "data";		
		$query = "INSERT INTO Reservations VALUES ('$id','$flight_number','$flight_date','$seat_num','$meal_id','$uuid','$class_id')";
		echo $query."\n";
		$result = $this->db->query($query);
	}
	
	function getFlightNumber($j){		
		return $this->Flights[$j]['Flight_Number'];
	}
	function getFlightDate($j){
		return $this->Flights[$j]['Flight_Date'];
	}
	function getMealId(){		
		return $this->Meals[rand()%3]['Meal_Id'];
	}
	function getUUID($k){		
		return $this->Users[$k]['UUID'];
	}
	function getClassId(){		
		return $this->Class[rand()%3]['Class_Id'];
	}
	function getSeat($flight_number,$flight_date){
		$query = "SELECT  Capacity FROM `Aircraft` WHERE Tail_Number = (select Tail_Number from Flights where Flight_Number = '$flight_number' and Flight_Date = '$flight_date')";		
        $result = $this->db->query($query);        
		return rand(1,$result->fetch_assoc()['Capacity']);
	}
	
	private function loadFlights(){
		$query = "SELECT Flight_Number,Flight_Date FROM Flights";		
        $result = $this->db->query($query);
        if($result) {
            while ($row = $result->fetch_assoc()) {				
            	$this->Flights[] = $row;				
             }
        }
	}
	
	private function loadMeals(){
		$query = "SELECT Meal_Id FROM Meals";		
        $result = $this->db->query($query);
        if($result) {
            while ($row = $result->fetch_assoc()) {				
            	$this->Meals[] = $row;
             }
        }
	}
	
	private function loadUsers(){
		$query = "SELECT UUID FROM Users";		
        $result = $this->db->query($query);
        if($result) {
            while ($row = $result->fetch_assoc()) {				
            	$this->Users[] = $row;				
             }
        }
	}
	
	private function loadClasses(){
		$query = "SELECT Class_Id FROM Class";		
        $result = $this->db->query($query);
        if($result) {
            while ($row = $result->fetch_assoc()) {				
            	$this->Class[] = $row;				
             }
        }
	}
}