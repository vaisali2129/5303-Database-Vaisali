<?php

error_reporting(1);

$host 	= 'localhost';
$user 	= 'rmannava';
$pass 	= 'rmannava2015';
$db 	= 'rmannava';

$load = new LoadDistanceData($host,$user,$pass,$db);

$load->addDistances();

class LoadDistanceData{

	var $db;
	
	function __construct($host,$user,$pass,$db){
		//connect to database on local server
		$this->db = new mysqli($host,$user,$pass,$db);

		if ($this->db->connect_errno) {
			echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
		}
		
	}
	function addDistances(){
		$file = fopen("airport_distance.csv","r");
		$contents = array();			
		while(!feof($file)){	
			$contents = (fgetcsv($file));
			
			$from = $contents[0];
			$to = $contents[1];
			$distance = $contents[2];
			$id = $contents[3];
			
			$this->addData($id,$from,$to,$distance);
		 }
		fclose($file);
	}
	
	function addData($id,$from,$to,$distance){		
		echo "data";
		$result = $this->db->query("TRUNCATE Distance");
		$query = "INSERT INTO Distance VALUES ('$from','$to','$distance','$id')";
		echo $query."\n";
		$result = $this->db->query($query);	
	}
}