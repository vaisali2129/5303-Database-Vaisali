<?php

error_reporting(1);

$host 	= 'localhost';
$user 	= 'rmannava';
$pass 	= 'rmannava2015';
$db 	= 'rmannava';

$load = new LoadAirports($host,$user,$pass,$db);

$load->addAirports();

class LoadAirports{

	var $db;
	
	function __construct($host,$user,$pass,$db){
		//connect to database on local server
		$this->db = new mysqli($host,$user,$pass,$db);

		if ($this->db->connect_errno) {
			echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
		}
		
	}
	function addAirports(){
		$file = fopen("airports.csv","r");
		$contents = array();			
		while(!feof($file)){	
			$contents = (fgetcsv($file));
			//print_r ($contents);
			$waste = $contents[0];
			$city = $contents[1];
			$state = $contents[2];
			$code = $contents[3];
			$name = $contents[4];
			$this->insertAirports($code,$name,$city,$state);
		 }
		fclose($file);
	}
	
	function insertAirports($code,$name,$city,$state){		
		echo "data";
		//$result = $this->db->query("TRUNCATE Airports");
		$query = "INSERT INTO Airports VALUES ('$code','$name','$city','$state')";
		echo $query."\n";
		$result = $this->db->query($query);	
	}
}