<?php

error_reporting(1);

$host 	= 'localhost';
$user 	= 'rmannava';
$pass 	= 'rmannava2015';
$db 	= 'rmannava';

$load = new LoadPrice($host,$user,$pass,$db);

$load->addPrice();

class LoadPrice{
	var $db;
	var $ReservationIds;	
	
	function __construct($host,$user,$pass,$db){
		//connect to database on local server
		$this->db = new mysqli($host,$user,$pass,$db);

		if ($this->db->connect_errno) {
			echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
		}	
		$this->ReservationIds = array();
		$this->loadIDs();
	}
	function addPrice(){		
		$count = $this->getCount();		
		for($i=0;$i<$count;$i++){
			$id = $this->ReservationIds[$i]['Reservations_Id'];
			$distance = $this->getDistance($id);			
			$cost = $this->getCostPerMile($id);			
			$price = 50 + $distance * $cost;
				
			$this->insertPrice($id,$price);	
		}
		
	}
	
	private function insertPrice($id,$price){		
		echo "data";
		//$result = $this->db->query("TRUNCATE Airports");
		$query = "INSERT INTO Price VALUES ('$price','$id')";
		echo $query."\n";
		$result = $this->db->query($query);
	}
	
	function getCount(){
		$query = "select count(*) from Reservations";		
        $result = $this->db->query($query);        
		return $result->fetch_assoc()['count(*)'];
	}
	function getDistance($id){
		$query = "SELECT Distance
				from Distance
				where Distance_Id = (
					select Distance_Id 
					from Flights
					where Flight_Number = (select Flight_Number from Reservations where Reservations_Id='$id')
					and Flight_Date = (select Flight_Date from Reservations where Reservations_Id='$id')
				)";	
        $result = $this->db->query($query);  
		//print_r ($result->fetch_assoc()['Distance']);
		return $result->fetch_assoc()['Distance'];
	}
	function getCostPerMile($id){
		$query = "SELECT f.Cost_Per_Mile
				  FROM Flight_Fare f
				  WHERE (
				  SELECT Flight_Date
				  FROM Reservations
				  WHERE Reservations_Id =  '$id'
				  )
					BETWEEN f.Start_Date
					AND f.End_Date";	
        $result = $this->db->query($query);  
		//print_r ($result->fetch_assoc()['Cost_Per_Mile']);
		return $result->fetch_assoc()['Cost_Per_Mile'];
	}
	private function loadIDs(){
		$query = "SELECT Reservations_Id FROM Reservations";		
        $result = $this->db->query($query);
        if($result) {
            while ($row = $result->fetch_assoc()) {				
            	$this->ReservationIds[] = $row;				
             }
        }
	}
}