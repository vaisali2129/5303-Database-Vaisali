<?php

// connect
	$user = new MongoClient();

// selecting a database
	$db = $user->vnamburi;

// selecting a collection
	$collection = $db->random_people;

// Gets 1000 users from the randomuser api, and loads it into a variable called $json
	$json = file_get_contents("http://api.randomuser.me/?results=1000");

// This turns the variable into a PHP object
	$json_array=json_decode($json);

// Iteration for inserting into the result using $json_array
	for ($i=0;$i<sizeof($json_array->results);$i++){

// Inserting users results into database
		$collection->insert($json_array->results[$i]);

	}

?>
