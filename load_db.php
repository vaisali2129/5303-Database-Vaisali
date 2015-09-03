<?php
	
error_reporting(0);
	$servername = "localhost";
	$database = "vnamburi";
	$username = "vnamburi";
	$password = "vnamburi2015";
	
	

	// Create connection
	$db = new mysqli($servername,$username,$password,$database);
    
    // check connection
	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}	
	
	
	$json = file_get_contents("http://api.randomuser.me/?results=1000");
	
	$json_array = json_decode($json);
	
	
	 for($i=0;$i<sizeof($json_array->results);$i++){
    	$gender = $json_array->results[$i]->user->gender;  
    	$title = $json_array->results[$i]->user->name->title; 
    	$first = $json_array->results[$i]->user->name->firstt; 
    	$last = $json_array->results[$i]->user->name->last; 
    	$street = $json_array->results[$i]->user->location->street; 
    	$city = $json_array->results[$i]->user->location->city; 
    	$state = $json_array->results[$i]->user->location->state; 
    	$zip = $json_array->results[$i]->user->location->zip; 
    	$email = $json_array->results[$i]->user->email; 
    	$username = $json_array->results[$i]->user->username; 
    	$password = $json_array->results[$i]->user->password; 
    	$dob = $json_array->results[$i]->user->dob; 
    	$phone = $json_array->results[$i]->user->phone; 
    	$picture = $json_array->results[$i]->user->picture->medium; 

    	
    	echo "$gender\n"; 
    	echo "$title\n";
    	echo "$first\n";
    	echo "$last\n";
    	echo "$street\n";
    	echo "$city\n";
    	echo "$state\n";
    	echo "$zip\n";
    	echo "$email\n";
    	echo "$username\n";
    	echo "$pasword\n";
    	echo "$dob\n";
    	echo "$phone\n";
    	echo "$picture\n"; 
    	
    	$query1 = <<<SQL
		select * from Users where email='{$email}';
SQL;
		if(!$query1_result = $db->query($query1)){
			die('Error running the query [' . $db->error . ']');
		}		
		if(!$query1_result->num_rows>0){
			$query2 = <<<SQL
			INSERT into Users
			VALUES('$gender','$title','$first','$last','$street','$city','$state','$zip','$email','$username','$password','$dob','$phone','$picture'); 
SQL;
		if(!$query2_result = $db->query($query2)){
			die('Error running the query [' . $db->error . ']');	
		}
	}

    	
    }
