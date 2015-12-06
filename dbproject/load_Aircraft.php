<?php

error_reporting(1);

$host 	= 'localhost';
$user 	= 'rmannava';
$pass 	= 'rmannava2015';
$db 	= 'rmannava';

$load = new LoadAircrafts($host,$user,$pass,$db);

$load->addAircrafts();

class LoadAircrafts{

	var $db;
	
	function __construct($host,$user,$pass,$db){
		//connect to database on local server
		$this->db = new mysqli($host,$user,$pass,$db);

		if ($this->db->connect_errno) {
			echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
		}
		
	}
	function addAircrafts(){
		$file = fopen("Aircrafts.csv","r");
		$contents = array();			
		while(!feof($file)){	
			$contents = (fgetcsv($file));
			//print_r ($contents[7]);
			$tail_number = $contents[0];
			$airline = $contents[1];
			$manufacture = $contents[2];
			$model = $contents[3];
			$capacity = $contents[4];
			$status = rand(0,1);
			$first = $contents[5];
			$business = $contents[6];
			$coach = $contents[7];
			$this->insertAircrafts($tail_number,$airline,$manufacture,$model,$capacity,$status,$first,$business,$coach);
		 }
		fclose($file);
	}
	
	function insertAircrafts($tail_number,$airline,$manufacture,$model,$capacity,$status,$first,$business,$coach){		
		echo "data";
		$result = $this->db->query("TRUNCATE Aircraft");
		$query = "INSERT INTO Aircraft VALUES ('$tail_number','$airline','$manufacture','$model','$capacity','$status','$first','$business','$coach')";
		echo $query."\n";
		$result = $this->db->query($query);	
	}
}